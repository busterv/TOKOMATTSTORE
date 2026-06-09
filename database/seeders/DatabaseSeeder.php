<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. SEED USER
        // ============================================
        $admin = User::create([
            'name' => 'Admin MATTSTORE',
            'email' => 'admin@mattstore.com',
            'password' => Hash::make('password123'),
        ]);

        // ============================================
        // 2. SEED CATEGORIES
        // ============================================
        $categories = [
            'Smartphone Flagship',
            'Smartphone Mid-Range',
            'Smartphone Budget',
            'Tablet',
            'Aksesoris HP',
            'Gadget Second',
        ];

        $categoryModels = [];
        foreach ($categories as $catName) {
            $categoryModels[$catName] = Category::create(['category_name' => $catName]);
        }

        // ============================================
        // 3. SEED MENU / PRODUK HP
        // ============================================
        $products = [
            // Flagship
            ['category' => 'Smartphone Flagship', 'item_name' => 'iPhone 15 Pro Max', 'brand' => 'Apple', 'price' => 21999000, 'stock' => 15, 'description' => '256GB, Natural Titanium'],
            ['category' => 'Smartphone Flagship', 'item_name' => 'iPhone 15 Pro', 'brand' => 'Apple', 'price' => 18499000, 'stock' => 20, 'description' => '128GB, Blue Titanium'],
            ['category' => 'Smartphone Flagship', 'item_name' => 'Samsung Galaxy S24 Ultra', 'brand' => 'Samsung', 'price' => 22999000, 'stock' => 12, 'description' => '512GB, Titanium Gray'],
            ['category' => 'Smartphone Flagship', 'item_name' => 'Samsung Galaxy Z Fold 5', 'brand' => 'Samsung', 'price' => 26999000, 'stock' => 8, 'description' => '512GB, Phantom Black'],
            ['category' => 'Smartphone Flagship', 'item_name' => 'Xiaomi 14 Pro', 'brand' => 'Xiaomi', 'price' => 14999000, 'stock' => 10, 'description' => '512GB, Black'],

            // Mid-Range
            ['category' => 'Smartphone Mid-Range', 'item_name' => 'Samsung Galaxy A55', 'brand' => 'Samsung', 'price' => 6499000, 'stock' => 25, 'description' => '128GB, Awesome Navy'],
            ['category' => 'Smartphone Mid-Range', 'item_name' => 'Xiaomi Redmi Note 13 Pro+', 'brand' => 'Xiaomi', 'price' => 5499000, 'stock' => 30, 'description' => '256GB, Midnight Black'],
            ['category' => 'Smartphone Mid-Range', 'item_name' => 'Oppo Reno 11 F', 'brand' => 'Oppo', 'price' => 4999000, 'stock' => 22, 'description' => '256GB, Ocean Blue'],
            ['category' => 'Smartphone Mid-Range', 'item_name' => 'Vivo V30', 'brand' => 'Vivo', 'price' => 5299000, 'stock' => 18, 'description' => '256GB, Peacock Green'],
            ['category' => 'Smartphone Mid-Range', 'item_name' => 'Realme 12 Pro+', 'brand' => 'Realme', 'price' => 5799000, 'stock' => 15, 'description' => '256GB, Navigator Beige'],

            // Budget
            ['category' => 'Smartphone Budget', 'item_name' => 'Xiaomi Redmi 13C', 'brand' => 'Xiaomi', 'price' => 1599000, 'stock' => 50, 'description' => '128GB, Midnight Black'],
            ['category' => 'Smartphone Budget', 'item_name' => 'Samsung Galaxy A05', 'brand' => 'Samsung', 'price' => 1399000, 'stock' => 45, 'description' => '64GB, Light Green'],
            ['category' => 'Smartphone Budget', 'item_name' => 'Oppo A18', 'brand' => 'Oppo', 'price' => 1499000, 'stock' => 40, 'description' => '64GB, Glowing Blue'],
            ['category' => 'Smartphone Budget', 'item_name' => 'Vivo Y17s', 'brand' => 'Vivo', 'price' => 1699000, 'stock' => 35, 'description' => '128GB, Forest Green'],

            // Tablet
            ['category' => 'Tablet', 'item_name' => 'iPad Pro 12.9 M2', 'brand' => 'Apple', 'price' => 18999000, 'stock' => 10, 'description' => '256GB, WiFi, Space Gray'],
            ['category' => 'Tablet', 'item_name' => 'Samsung Galaxy Tab S9', 'brand' => 'Samsung', 'price' => 12999000, 'stock' => 12, 'description' => '256GB, WiFi, Graphite'],
            ['category' => 'Tablet', 'item_name' => 'Xiaomi Pad 6', 'brand' => 'Xiaomi', 'price' => 5499000, 'stock' => 20, 'description' => '128GB, WiFi, Champagne Gold'],

            // Aksesoris
            ['category' => 'Aksesoris HP', 'item_name' => 'AirPods Pro 2', 'brand' => 'Apple', 'price' => 3799000, 'stock' => 30, 'description' => 'USB-C, Active Noise Cancellation'],
            ['category' => 'Aksesoris HP', 'item_name' => 'Samsung Galaxy Buds 2 Pro', 'brand' => 'Samsung', 'price' => 2499000, 'stock' => 25, 'description' => 'Graphite, ANC'],
            ['category' => 'Aksesoris HP', 'item_name' => 'Charger Anker 65W', 'brand' => 'Anker', 'price' => 599000, 'stock' => 50, 'description' => 'GaN II, USB-C'],
            ['category' => 'Aksesoris HP', 'item_name' => 'Powerbank Xiaomi 20000mAh', 'brand' => 'Xiaomi', 'price' => 399000, 'stock' => 60, 'description' => 'Fast Charge 22.5W'],
            ['category' => 'Aksesoris HP', 'item_name' => 'Case iPhone 15 Pro', 'brand' => 'Spigen', 'price' => 299000, 'stock' => 40, 'description' => 'Ultra Hybrid, Clear'],

            // Gadget Second
            ['category' => 'Gadget Second', 'item_name' => 'iPhone 13 (Second)', 'brand' => 'Apple', 'price' => 9500000, 'stock' => 5, 'description' => '128GB, Midnight, Mulus 95%'],
            ['category' => 'Gadget Second', 'item_name' => 'Samsung S22 Ultra (Second)', 'brand' => 'Samsung', 'price' => 11500000, 'stock' => 4, 'description' => '256GB, Phantom Black, Fullset'],
            ['category' => 'Gadget Second', 'item_name' => 'Xiaomi 12 Pro (Second)', 'brand' => 'Xiaomi', 'price' => 6500000, 'stock' => 6, 'description' => '256GB, Gray, Garansi Resmi'],
        ];

        $menuModels = [];
        foreach ($products as $product) {
            $menuModels[] = Menu::create([
                'category_id' => $categoryModels[$product['category']]->id,
                'item_name' => $product['item_name'],
                'brand' => $product['brand'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'description' => $product['description'],
            ]);
        }

        // ============================================
        // 4. SEED TRANSAKSI (30 transaksi acak 6 bulan terakhir)
        // ============================================
        $allMenus = Menu::all();

        for ($i = 0; $i < 30; $i++) {
            // Random tanggal dalam 6 bulan terakhir
            $daysAgo = rand(0, 180);
            $transactionDate = now()->subDays($daysAgo)->setHour(rand(9, 20))->setMinute(rand(0, 59));

            // Random 1-3 item per transaksi
            $itemCount = rand(1, 3);
            $selectedMenus = $allMenus->random($itemCount);

            $totalPrice = 0;
            $items = [];

            foreach ($selectedMenus as $menu) {
                $qty = rand(1, min(2, $menu->stock));
                $subtotal = $menu->price * $qty;
                $totalPrice += $subtotal;

                $items[] = [
                    'menu_id' => $menu->id,
                    'quantity' => $qty,
                    'price_at_transaction' => $menu->price,
                    'subtotal' => $subtotal,
                ];
            }

            // Random uang bayar
            $roundUp = [0, 10000, 50000, 100000][rand(0, 3)];
            $totalPaid = $totalPrice + $roundUp;
            $totalReturn = $totalPaid - $totalPrice;

            // Kode transaksi unik
            $trxCode = 'TRX-HP-' . $transactionDate->format('Ymd') . '-' . strtoupper(substr(md5(uniqid() . $i), 0, 4));

            // Simpan transaksi
            $transaction = Transaction::create([
                'user_id' => $admin->id,
                'transaction_code' => $trxCode,
                'total_price' => $totalPrice,
                'total_paid' => $totalPaid,
                'total_return' => $totalReturn,
                'transaction_date' => $transactionDate,
            ]);

            // Simpan detail
            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price_at_transaction' => $item['price_at_transaction'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
        }

        // ============================================
        // 5. UPDATE STOK SETELAH TRANSAKSI
        // ============================================
        $soldQuantities = DB::table('transaction_details')
            ->select('menu_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_id')
            ->pluck('total_sold', 'menu_id');

        foreach ($soldQuantities as $menuId => $sold) {
            $menu = Menu::find($menuId);
            if ($menu) {
                // Cari stok awal dari array products
                $initialStock = 0;
                foreach ($products as $p) {
                    if ($p['item_name'] === $menu->item_name) {
                        $initialStock = $p['stock'];
                        break;
                    }
                }

                $newStock = max(1, $initialStock - $sold); // Minimal sisa 1 agar tetap muncul di POS
                $menu->update(['stock' => $newStock]);
            }
        }

        // ============================================
        // SELESAI - TAMPILKAN HASIL
        // ============================================
        $this->command->info('✅ SEEDING BERHASIL!');
        $this->command->info('-----------------------------------');
        $this->command->info('Users: ' . User::count());
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Products: ' . Menu::count());
        $this->command->info('Transactions: ' . Transaction::count());
        $this->command->info('Transaction Details: ' . TransactionDetail::count());
        $this->command->info('-----------------------------------');
        $this->command->info(' LOGIN:');
        $this->command->info('   Email: admin@mattstore.com');
        $this->command->info('   Password: password123');
        $this->command->info('-----------------------------------');
    }
}