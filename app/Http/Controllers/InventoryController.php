<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::with(['supplier', 'category'])
            ->orderBy('item_name', 'asc')
            ->get();

        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('inventory.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date|after:today',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $item = InventoryItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Item added successfully!');
    }

    public function show($id)
    {
        $item = InventoryItem::with(['supplier', 'category'])->findOrFail($id);

        return view('inventory.show', compact('item'));
    }

    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('inventory.edit', compact('item', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date|after:today',
            'delivery_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $item->update($validated);

        return redirect()->route('inventory.show', $item->id)
            ->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $itemName = $item->item_name;
        
        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', "Item '{$itemName}' deleted successfully!");
    }

    public function lowStock()
    {
        $items = InventoryItem::with(['supplier', 'category'])
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity', 'asc')
            ->get();

        return view('inventory.low-stock', compact('items'));
    }

    public function expiringSoon()
    {
        $today = Carbon::today();
        $upcoming = $today->copy()->addDays(7);

        $items = InventoryItem::with(['supplier', 'category'])
            ->whereBetween('expiration_date', [$today, $upcoming])
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('inventory.expiring', compact('items'));
    }
}