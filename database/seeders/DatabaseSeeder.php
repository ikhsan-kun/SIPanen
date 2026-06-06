<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentConfirmation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin CV. Ekiindo',
            'email' => 'admin@ekiindo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Raya Tegal No. 10',
            'city' => 'Tegal',
            'province' => 'Jawa Tengah',
            'postal_code' => '52113',
            'company_name' => 'CV. Ekiindo Tegal'
        ]);

        // 2. Create Customers
        $customer1 = User::create([
            'name' => 'Ikhsan Gilang',
            'email' => 'ikhsan@gmail.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '08987654321',
            'address' => 'Jl. Pemuda No. 45',
            'city' => 'Tegal',
            'province' => 'Jawa Tengah',
            'postal_code' => '52123',
            'company_name' => 'Sawit Jaya Mandiri'
        ]);

        $customer2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '087712345678',
            'address' => 'Jl. Jenderal Sudirman No. 89',
            'city' => 'Pekanbaru',
            'province' => 'Riau',
            'postal_code' => '28123',
            'company_name' => 'PT. Sawit Makmur'
        ]);

        // 3. Create Products
        $p1 = Product::create([
            'name' => 'Egrek Sawit Premium E-77',
            'slug' => 'egrek-sawit-premium-e-77',
            'category' => 'egrek',
            'description' => 'Egrek Premium E-77 diproduksi dengan material baja karbon kualitas tinggi dan proses penempaan khusus. Sangat tajam, awet, dan langsung siap pakai tanpa perlu diasah kembali.',
            'specifications' => "- Bahan: Baja Karbon Jerman\n- Panjang: 65 cm\n- Ketebalan: 4 mm\n- Berat: 1.2 kg\n- Siap pakai tanpa asah",
            'price' => 285000,
            'stock' => 50,
            'unit' => 'pcs',
            'weight' => '1.2 kg',
            'material' => 'Baja Karbon Jerman',
            'is_active' => true
        ]);

        $p2 = Product::create([
            'name' => 'Egrek Standar E-55',
            'slug' => 'egrek-standar-e-55',
            'category' => 'egrek',
            'description' => 'Egrek Sawit Standar E-55 sangat cocok untuk kebun rakyat. Ekonomis dan memiliki daya tahan yang baik untuk penggunaan sehari-hari.',
            'specifications' => "- Bahan: Baja Per/Baja Pegas\n- Panjang: 60 cm\n- Ketebalan: 3.5 mm\n- Berat: 1.0 kg",
            'price' => 175000,
            'stock' => 75,
            'unit' => 'pcs',
            'weight' => '1.0 kg',
            'material' => 'Baja Per',
            'is_active' => true
        ]);

        $p3 = Product::create([
            'name' => 'Dodos Sawit Lebar 12cm',
            'slug' => 'dodos-sawit-lebar-12cm',
            'category' => 'dodos',
            'description' => 'Dodos Sawit dengan lebar mata pisau 12cm, sangat cocok untuk memanen buah sawit pada pohon yang berumur sedang.',
            'specifications' => "- Lebar: 12 cm\n- Panjang total: 35 cm\n- Bahan: Baja Tempaan Lokal\n- Berat: 1.5 kg",
            'price' => 120000,
            'stock' => 40,
            'unit' => 'pcs',
            'weight' => '1.5 kg',
            'material' => 'Baja Tempaan Lokal',
            'is_active' => true
        ]);

        $p4 = Product::create([
            'name' => 'Dodos Sawit Lebar 14cm',
            'slug' => 'dodos-sawit-lebar-14cm',
            'category' => 'dodos',
            'description' => 'Dodos Sawit dengan lebar mata pisau 14cm. Sempurna untuk kelapa sawit usia dewasa dengan tangkai pelepah yang tebal.',
            'specifications' => "- Lebar: 14 cm\n- Panjang total: 38 cm\n- Bahan: Baja Tempaan Lokal Super\n- Berat: 1.8 kg",
            'price' => 135000,
            'stock' => 4, // Low stock simulation
            'unit' => 'pcs',
            'weight' => '1.8 kg',
            'material' => 'Baja Tempaan Lokal Super',
            'is_active' => true
        ]);

        $p5 = Product::create([
            'name' => 'Gagang Teleskopik Aluminium 6 Meter',
            'slug' => 'gagang-teleskopik-aluminium-6-meter',
            'category' => 'telescopic_pole',
            'description' => 'Gagang teleskopik aluminium berkualitas tinggi yang bisa dipanjangkan hingga 6 meter. Ringan namun sangat kokoh saat digunakan.',
            'specifications' => "- Bahan: Aluminium Alloy T6\n- Panjang Min: 3 Meter\n- Panjang Max: 6 Meter\n- Jumlah Seksi: 2 Seksi\n- Berat: 2.5 kg",
            'price' => 380000,
            'stock' => 20,
            'unit' => 'pcs',
            'weight' => '2.5 kg',
            'material' => 'Aluminium Alloy T6',
            'is_active' => true
        ]);

        $p6 = Product::create([
            'name' => 'Gagang Teleskopik Aluminium 8 Meter',
            'slug' => 'gagang-teleskopik-aluminium-8-meter',
            'category' => 'telescopic_pole',
            'description' => 'Gagang teleskopik premium dengan jangkauan maksimal hingga 8 meter. Terbuat dari aluminium alloy tebal untuk menjamin keselamatan dan performa panen.',
            'specifications' => "- Bahan: Aluminium Alloy T6 Premium\n- Panjang Min: 4 Meter\n- Panjang Max: 8 Meter\n- Jumlah Seksi: 3 Seksi\n- Berat: 3.8 kg",
            'price' => 550000,
            'stock' => 15,
            'unit' => 'pcs',
            'weight' => '3.8 kg',
            'material' => 'Aluminium Alloy T6 Premium',
            'is_active' => true
        ]);

        // 4. Create Simulated Orders & Payments

        // Order 1: Selesai & Paid
        $o1 = Order::create([
            'order_number' => 'EKI-SUCCESS-260607',
            'user_id' => $customer1->id,
            'subtotal' => 970000,
            'shipping_cost' => 0,
            'total_amount' => 970000,
            'status' => 'selesai',
            'payment_status' => 'paid',
            'payment_method' => 'transfer',
            'recipient_name' => 'Ikhsan Gilang',
            'recipient_phone' => '08987654321',
            'shipping_address' => 'Jl. Pemuda No. 45, Tegal',
            'shipping_city' => 'Tegal',
            'shipping_province' => 'Jawa Tengah',
            'shipping_postal_code' => '52123',
            'paid_at' => now()->subDays(2),
            'completed_at' => now()->subDay(),
            'created_at' => now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $o1->id,
            'product_id' => $p1->id, // Egrek Premium E-77
            'quantity' => 2,
            'price' => 285000,
            'subtotal' => 570000
        ]);

        OrderItem::create([
            'order_id' => $o1->id,
            'product_id' => $p5->id, // Gagang Teleskopik 6m
            'quantity' => 1,
            'price' => 380000,
            'subtotal' => 380000
        ]);

        PaymentConfirmation::create([
            'order_id' => $o1->id,
            'bank_name' => 'BCA',
            'account_name' => 'Ikhsan Gilang',
            'account_number' => '011223344',
            'amount_paid' => 970000,
            'transfer_proof' => 'payment_proofs/default.jpg', // Dummy path
            'transfer_date' => now()->subDays(2),
            'status' => 'approved',
            'admin_notes' => 'Pembayaran sesuai nominal dan telah diterima di rekening BCA.'
        ]);

        // Order 2: Pending Confirmation (Needs Admin Approval)
        $o2 = Order::create([
            'order_number' => 'EKI-PENDING-260607',
            'user_id' => $customer2->id,
            'subtotal' => 310000,
            'shipping_cost' => 0,
            'total_amount' => 310000,
            'status' => 'pending',
            'payment_status' => 'pending_confirmation',
            'payment_method' => 'transfer',
            'recipient_name' => 'Budi Santoso',
            'recipient_phone' => '087712345678',
            'shipping_address' => 'Jl. Jenderal Sudirman No. 89, Pekanbaru',
            'shipping_city' => 'Pekanbaru',
            'shipping_province' => 'Riau',
            'shipping_postal_code' => '28123',
            'created_at' => now()->subHours(5),
        ]);

        OrderItem::create([
            'order_id' => $o2->id,
            'product_id' => $p2->id, // Egrek Standar E-55
            'quantity' => 1,
            'price' => 175000,
            'subtotal' => 175000
        ]);

        OrderItem::create([
            'order_id' => $o2->id,
            'product_id' => $p4->id, // Dodos 14cm
            'quantity' => 1,
            'price' => 135000,
            'subtotal' => 135000
        ]);

        PaymentConfirmation::create([
            'order_id' => $o2->id,
            'bank_name' => 'Mandiri',
            'account_name' => 'Budi Santoso',
            'account_number' => '1234567890123',
            'amount_paid' => 310000,
            'transfer_proof' => 'payment_proofs/default.jpg', // Dummy path
            'transfer_date' => now()->subHours(4),
            'status' => 'pending'
        ]);

        // Order 3: Unpaid / Pending
        $o3 = Order::create([
            'order_number' => 'EKI-UNPAID-260607',
            'user_id' => $customer1->id,
            'subtotal' => 550000,
            'shipping_cost' => 0,
            'total_amount' => 550000,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => 'transfer',
            'recipient_name' => 'Ikhsan Gilang',
            'recipient_phone' => '08987654321',
            'shipping_address' => 'Jl. Pemuda No. 45, Tegal',
            'shipping_city' => 'Tegal',
            'shipping_province' => 'Jawa Tengah',
            'shipping_postal_code' => '52123',
            'created_at' => now()->subHours(1),
        ]);

        OrderItem::create([
            'order_id' => $o3->id,
            'product_id' => $p6->id, // Gagang Teleskopik 8m
            'quantity' => 1,
            'price' => 550000,
            'subtotal' => 550000
        ]);
    }
}
