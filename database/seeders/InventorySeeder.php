<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Beverages',
            'Food Ingredients',
            'Bakery',
            'Dairy',
            'Cleaning Supplies',
            'Disposables',
            'Equipment Parts'
        ];

        $createdCategories = [];
        foreach ($categories as $categoryName) {
            $createdCategories[$categoryName] = Category::create([
                'category_name' => $categoryName
            ]);
        }

        $suppliers = [
            [
                'supplier_name' => 'Bean & Brew Co.',
                'contact_number' => '+63 917 123 4567',
                'email' => 'orders@beanbrewco.ph',
                'address' => 'Manila, Philippines',
                'delivery_status' => 'delivered'
            ],
            [
                'supplier_name' => 'Fresh Dairy Farm',
                'contact_number' => '+63 918 234 5678',
                'email' => 'sales@freshdairy.ph',
                'address' => 'Laguna, Philippines',
                'delivery_status' => 'delivered'
            ],
            [
                'supplier_name' => 'Golden Bakery Supplies',
                'contact_number' => '+63 919 345 6789',
                'email' => 'info@goldenbakery.ph',
                'address' => 'Quezon City, Philippines',
                'delivery_status' => 'pending'
            ],
            [
                'supplier_name' => 'Clean Pro Solutions',
                'contact_number' => '+63 920 456 7890',
                'email' => 'support@cleanpro.ph',
                'address' => 'Makati, Philippines',
                'delivery_status' => 'delivered'
            ],
            [
                'supplier_name' => 'EcoWare Packaging',
                'contact_number' => '+63 921 567 8901',
                'email' => 'orders@ecoware.ph',
                'address' => 'Pasig, Philippines',
                'delivery_status' => 'partial'
            ]
        ];

        $createdSuppliers = [];
        foreach ($suppliers as $supplierData) {
            $createdSuppliers[] = Supplier::create($supplierData);
        }

        $inventoryItems = [
            [
                'item_name' => 'Arabica Coffee Beans',
                'category' => 'Beverages',
                'supplier' => 0,
                'quantity' => 50,
                'unit' => 'kg',
                'reorder_level' => 20,
                'expiration_date' => Carbon::now()->addMonths(6),
                'delivery_date' => Carbon::now()->subDays(5),
                'notes' => 'Premium quality, store in cool dry place'
            ],
            [
                'item_name' => 'Robusta Coffee Beans',
                'category' => 'Beverages',
                'supplier' => 0,
                'quantity' => 30,
                'unit' => 'kg',
                'reorder_level' => 15,
                'expiration_date' => Carbon::now()->addMonths(6),
                'delivery_date' => Carbon::now()->subDays(5),
                'notes' => 'Strong flavor blend'
            ],
            [
                'item_name' => 'Whole Milk',
                'category' => 'Dairy',
                'supplier' => 1,
                'quantity' => 25,
                'unit' => 'liters',
                'reorder_level' => 30,
                'expiration_date' => Carbon::now()->addDays(5),
                'delivery_date' => Carbon::now()->subDays(2),
                'notes' => 'Refrigerate immediately'
            ],
            [
                'item_name' => 'Fresh Cream',
                'category' => 'Dairy',
                'supplier' => 1,
                'quantity' => 15,
                'unit' => 'liters',
                'reorder_level' => 20,
                'expiration_date' => Carbon::now()->addDays(4),
                'delivery_date' => Carbon::now()->subDays(1),
                'notes' => 'Keep refrigerated at 4°C'
            ],
            [
                'item_name' => 'White Sugar',
                'category' => 'Food Ingredients',
                'supplier' => 2,
                'quantity' => 100,
                'unit' => 'kg',
                'reorder_level' => 50,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(10),
                'notes' => 'Store in airtight container'
            ],
            [
                'item_name' => 'Brown Sugar',
                'category' => 'Food Ingredients',
                'supplier' => 2,
                'quantity' => 40,
                'unit' => 'kg',
                'reorder_level' => 25,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(10),
                'notes' => 'Keep moisture-free'
            ],
            [
                'item_name' => 'All-Purpose Flour',
                'category' => 'Bakery',
                'supplier' => 2,
                'quantity' => 80,
                'unit' => 'kg',
                'reorder_level' => 40,
                'expiration_date' => Carbon::now()->addMonths(4),
                'delivery_date' => Carbon::now()->subDays(7),
                'notes' => 'Check for weevils regularly'
            ],
            [
                'item_name' => 'Cocoa Powder',
                'category' => 'Bakery',
                'supplier' => 2,
                'quantity' => 10,
                'unit' => 'kg',
                'reorder_level' => 15,
                'expiration_date' => Carbon::now()->addMonths(8),
                'delivery_date' => Carbon::now()->subDays(15),
                'notes' => 'Premium Dutch-processed'
            ],
            [
                'item_name' => 'Vanilla Syrup',
                'category' => 'Beverages',
                'supplier' => 0,
                'quantity' => 12,
                'unit' => 'bottles',
                'reorder_level' => 10,
                'expiration_date' => Carbon::now()->addMonths(12),
                'delivery_date' => Carbon::now()->subDays(3),
                'notes' => '750ml bottles'
            ],
            [
                'item_name' => 'Caramel Syrup',
                'category' => 'Beverages',
                'supplier' => 0,
                'quantity' => 8,
                'unit' => 'bottles',
                'reorder_level' => 10,
                'expiration_date' => Carbon::now()->addMonths(12),
                'delivery_date' => Carbon::now()->subDays(3),
                'notes' => '750ml bottles'
            ],
            [
                'item_name' => 'Paper Cups (12oz)',
                'category' => 'Disposables',
                'supplier' => 4,
                'quantity' => 500,
                'unit' => 'pcs',
                'reorder_level' => 300,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(2),
                'notes' => 'Eco-friendly material'
            ],
            [
                'item_name' => 'Paper Cups (16oz)',
                'category' => 'Disposables',
                'supplier' => 4,
                'quantity' => 400,
                'unit' => 'pcs',
                'reorder_level' => 250,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(2),
                'notes' => 'Eco-friendly material'
            ],
            [
                'item_name' => 'Plastic Lids',
                'category' => 'Disposables',
                'supplier' => 4,
                'quantity' => 800,
                'unit' => 'pcs',
                'reorder_level' => 500,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(2),
                'notes' => 'Fits 12oz and 16oz cups'
            ],
            [
                'item_name' => 'Wooden Stirrers',
                'category' => 'Disposables',
                'supplier' => 4,
                'quantity' => 1000,
                'unit' => 'pcs',
                'reorder_level' => 500,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(5),
                'notes' => 'Biodegradable'
            ],
            [
                'item_name' => 'Napkins',
                'category' => 'Disposables',
                'supplier' => 4,
                'quantity' => 2000,
                'unit' => 'pcs',
                'reorder_level' => 1000,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(5),
                'notes' => 'Paper napkins, 30x30cm'
            ],
            [
                'item_name' => 'Dish Soap',
                'category' => 'Cleaning Supplies',
                'supplier' => 3,
                'quantity' => 10,
                'unit' => 'bottles',
                'reorder_level' => 8,
                'expiration_date' => Carbon::now()->addMonths(18),
                'delivery_date' => Carbon::now()->subDays(20),
                'notes' => '1 liter bottles, antibacterial'
            ],
            [
                'item_name' => 'Multi-Surface Cleaner',
                'category' => 'Cleaning Supplies',
                'supplier' => 3,
                'quantity' => 8,
                'unit' => 'bottles',
                'reorder_level' => 6,
                'expiration_date' => Carbon::now()->addMonths(24),
                'delivery_date' => Carbon::now()->subDays(20),
                'notes' => 'Spray bottles, 500ml'
            ],
            [
                'item_name' => 'Microfiber Cloths',
                'category' => 'Cleaning Supplies',
                'supplier' => 3,
                'quantity' => 20,
                'unit' => 'pcs',
                'reorder_level' => 15,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(30),
                'notes' => 'Reusable, machine washable'
            ],
            [
                'item_name' => 'Croissants (Frozen)',
                'category' => 'Bakery',
                'supplier' => 2,
                'quantity' => 5,
                'unit' => 'kg',
                'reorder_level' => 10,
                'expiration_date' => Carbon::now()->addDays(3),
                'delivery_date' => Carbon::now()->subDays(1),
                'notes' => 'Keep frozen until use'
            ],
            [
                'item_name' => 'Espresso Machine Filter',
                'category' => 'Equipment Parts',
                'supplier' => 0,
                'quantity' => 3,
                'unit' => 'pcs',
                'reorder_level' => 2,
                'expiration_date' => null,
                'delivery_date' => Carbon::now()->subDays(60),
                'notes' => 'Replacement parts for main espresso machine'
            ]
        ];

        foreach ($inventoryItems as $itemData) {
            InventoryItem::create([
                'item_name' => $itemData['item_name'],
                'category_id' => $createdCategories[$itemData['category']]->id,
                'supplier_id' => $createdSuppliers[$itemData['supplier']]->id,
                'quantity' => $itemData['quantity'],
                'unit' => $itemData['unit'],
                'reorder_level' => $itemData['reorder_level'],
                'expiration_date' => $itemData['expiration_date'],
                'delivery_date' => $itemData['delivery_date'],
                'notes' => $itemData['notes']
            ]);
        }
    }
}