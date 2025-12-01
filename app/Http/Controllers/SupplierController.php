<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'delivery_status' => 'nullable|in:pending,partial,delivered,cancelled'
        ]);

        $supplier = Supplier::create($data);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    public function show($id)
    {
        $supplier = Supplier::with('inventoryItems')->findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'delivery_status' => 'nullable|in:pending,partial,delivered,cancelled'
        ]);

        $supplier->update($data);

        return redirect()->route('suppliers.show', $supplier->id)
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplierName = $supplier->supplier_name;
        
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', "Supplier '{$supplierName}' deleted successfully!");
    }
}