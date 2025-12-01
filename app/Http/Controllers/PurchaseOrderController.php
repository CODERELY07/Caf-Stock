<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\InventoryItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('supplier', 'items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchase-orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $inventoryItems = InventoryItem::orderBy('item_name')->get();

        return view('purchase-orders.create', compact('suppliers', 'inventoryItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'order_date' => 'nullable|date',
            'expected_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'nullable|exists:inventory_items,id',
            'items.*.item_name' => 'required|string',
            'items.*.ordered_quantity' => 'required|integer|min:1',
            'items.*.unit' => 'nullable|string',
            'items.*.unit_price' => 'nullable|numeric|min:0'
        ]);

        DB::transaction(function () use ($data, $request) {
            $poNumber = 'PO-' . strtoupper(Str::random(8));

            $po = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $data['supplier_id'] ?? null,
                'created_by' => $request->user()->id ?? null,
                'order_date' => $data['order_date'] ?? now(),
                'expected_date' => $data['expected_date'] ?? null,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'inventory_item_id' => $item['inventory_item_id'] ?? null,
                    'item_name' => $item['item_name'],
                    'ordered_quantity' => $item['ordered_quantity'],
                    'received_quantity' => 0,
                    'unit' => $item['unit'] ?? null,
                    'unit_price' => $item['unit_price'] ?? null
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order created successfully!');
    }

    public function show($id)
    {
        $order = PurchaseOrder::with('supplier', 'items.inventoryItem')->findOrFail($id);

        return view('purchase-orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = PurchaseOrder::with('items')->findOrFail($id);
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('purchase-orders.edit', compact('order', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);

        $data = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'expected_date' => 'nullable|date',
            'status' => 'nullable|in:pending,partially_delivered,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $po->update($data);

        return redirect()->route('purchase-orders.show', $po->id)
            ->with('success', 'Purchase Order updated successfully!');
    }

    public function receive(Request $request, $id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);

        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.purchase_order_item_id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($po, $data) {
            $allReceived = true;
            
            foreach ($data['items'] as $line) {
                $poi = $po->items->where('id', $line['purchase_order_item_id'])->first();
                
                if (!$poi) {
                    throw new \Exception("PO item not found");
                }

                $received = intval($line['received_quantity']);
                $poi->received_quantity += $received;
                $poi->save();

                if ($poi->inventory_item_id) {
                    $inv = InventoryItem::find($poi->inventory_item_id);
                    if ($inv) {
                        $inv->quantity += $received;
                        $inv->save();
                    }
                }

                if ($poi->received_quantity < $poi->ordered_quantity) {
                    $allReceived = false;
                }
            }

            $po->status = $allReceived ? 'delivered' : 'partially_delivered';
            $po->save();

            if ($po->supplier) {
                $po->supplier->delivery_status = $po->status === 'delivered' ? 'delivered' : 'partial';
                $po->supplier->save();
            }
        });

        return redirect()->route('purchase-orders.show', $po->id)
            ->with('success', 'Received quantities recorded successfully!');
    }

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $poNumber = $po->po_number;
        
        $po->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', "Purchase Order '{$poNumber}' deleted successfully!");
    }
}