<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
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
            'name' => 'Agrek Sawit Premium',
            'slug' => 'agrek-sawit-premium',
            'category' => 'egrek',
            'description' => 'Agrek (Egrek) panen kelapa sawit premium terbuat dari baja tempaan impor berkualitas tinggi. Memiliki ketajaman prima yang tahan lama, langsung siap digunakan untuk memangkas pelepah kelapa sawit pada pokok pohon tinggi secara presisi.',
            'specifications' => "- Bahan: Baja Karbon Tinggi Tempaan\n- Panjang Mata: 65 cm\n- Ketebalan: 4 mm\n- Kelengkapan: Siap Pakai tanpa Asah",
            'price' => 170000,
            'stock' => 50,
            'unit' => 'pcs',
            'weight' => '1.2 kg',
            'material' => 'Baja Karbon Tinggi',
            'image' => 'produk/agrek.jpeg',
            'is_active' => true
        ]);

        $p2 = Product::create([
            'name' => 'Dodos Sawit Spesial',
            'slug' => 'dodos-sawit-spesial',
            'category' => 'dodos',
            'description' => 'Dodos sawit khusus yang didesain untuk panen kelapa sawit pokok rendah hingga sedang. Memiliki ketajaman luar biasa pada mata pahatnya untuk memotong tangkai buah sawit dengan satu kali dorongan mantap.',
            'specifications' => "- Lebar Mata: 12 cm\n- Panjang total: 35 cm\n- Bahan: Baja Per Sepuhan\n- Kegunaan: Pokok sawit rendah/sedang",
            'price' => 80000,
            'stock' => 75,
            'unit' => 'pcs',
            'weight' => '1.4 kg',
            'material' => 'Baja Per Sepuhan',
            'image' => 'produk/dodos.jpeg',
            'is_active' => true
        ]);

        $p3 = Product::create([
            'name' => 'Kapak Pembelah Sawit',
            'slug' => 'kapak-pembelah-sawit',
            'category' => 'dodos',
            'description' => 'Kapak besi baja tebal serbaguna yang kuat dan kokoh untuk membelah kayu, membersihkan pelepah keras, maupun memotong akar kelapa sawit secara efisien di lapangan.',
            'specifications' => "- Berat Kepala Kapak: 1.1 kg\n- Bahan: Baja Karbon Tempaan\n- Desain: Gagang anti slip nyaman digenggam",
            'price' => 110000,
            'stock' => 40,
            'unit' => 'pcs',
            'weight' => '1.5 kg',
            'material' => 'Baja Tempaan Karbon',
            'image' => 'produk/kapak.jpeg',
            'is_active' => true
        ]);

        $p4 = Product::create([
            'name' => 'Parang Tebas Perkebunan',
            'slug' => 'parang-tebas-perkebunan',
            'category' => 'egrek',
            'description' => 'Parang tebas panjang perkebunan sawit untuk membersihkan semak belukar, memotong rumput liar di sekitar piringan pohon sawit, serta merapikan ranting pelepah yang mengganggu alur panen.',
            'specifications' => "- Panjang Bilah: 45 cm\n- Tebal Bilah: 3 mm\n- Bahan: Plat Baja Per\n- Handle: Kayu Keras Kuat Nyaman",
            'price' => 95000,
            'stock' => 4, // Low stock simulation
            'unit' => 'pcs',
            'weight' => '0.8 kg',
            'material' => 'Plat Baja Per',
            'image' => 'produk/parang.jpeg',
            'is_active' => true
        ]);

        $p5 = Product::create([
            'name' => 'Gancu Sawit Stainless',
            'slug' => 'gancu-sawit-stainless',
            'category' => 'dodos',
            'description' => 'Gancu sawit ergonomis untuk membantu proses pengangkutan, penataan, dan loading buah kelapa sawit (TBS) ke atas truk pengangkut atau gerobak sorong dengan lebih ringan dan cepat.',
            'specifications' => "- Bahan: Stainless Steel / Besi Ulir Tebal\n- Model: Single Hook\n- Panjang: 40 cm\n- Handle: Balutan karet anti licin",
            'price' => 76000,
            'stock' => 20,
            'unit' => 'pcs',
            'weight' => '0.6 kg',
            'material' => 'Stainless Steel',
            'image' => 'produk/gancu.jpeg',
            'is_active' => true
        ]);

        $p6 = Product::create([
            'name' => 'Tombak Panen Egrek',
            'slug' => 'tombak-panen-egrek',
            'category' => 'egrek',
            'description' => 'Tombak panen kelapa sawit yang kokoh dengan ujung runcing dan tajam untuk menusuk buah sawit pokok tinggi maupun menarik tandan buah sawit yang tersangkut di dahan pohon.',
            'specifications' => "- Ujung: Runcing & Bergerigi Penarik\n- Bahan: Baja Tempa Pilihan\n- Sambungan: Drat Pipa Fleksibel",
            'price' => 85000,
            'stock' => 15,
            'unit' => 'pcs',
            'weight' => '1.1 kg',
            'material' => 'Baja Tempa Pilihan',
            'image' => 'produk/tombak.jpeg',
            'is_active' => true
        ]);

        $p7 = Product::create([
            'name' => 'Cangkul Garuk Perkebunan',
            'slug' => 'cangkul-garuk-perkebunan',
            'category' => 'dodos',
            'description' => 'Cangkul garuk multi-fungsi dengan mata garpu baja tebal untuk membersihkan piringan kelapa sawit, menggemburkan tanah di sekitar tanaman, serta membersihkan tumpukan sampah pelepah daun sawit.',
            'specifications' => "- Jumlah Gigi Garuk: 4 Mata Gigi Baja\n- Lebar: 20 cm\n- Panjang Total Kepala: 25 cm\n- Finishing: Cat coating anti karat",
            'price' => 90000,
            'stock' => 30,
            'unit' => 'pcs',
            'weight' => '1.3 kg',
            'material' => 'Baja Plat Tebal',
            'image' => 'produk/cangkul garuk.jpeg',
            'is_active' => true
        ]);

        $p8 = Product::create([
            'name' => 'Gerobak Sorong Artco',
            'slug' => 'gerobak-sorong-artco',
            'category' => 'telescopic_pole', // dipetakan sementara agar masuk kategori logistik/alat bantu
            'description' => 'Gerobak sorong besi baja tebal kualitas premium yang sangat handal digunakan untuk melangsir atau mengangkut tandan buah segar kelapa sawit dari kebun menuju tempat pengumpulan buah (TPB).',
            'specifications' => "- Kapasitas Angkut: 150 kg\n- Ban: Ban Hidup Karet Tebal\n- Bak: Besi Press Anti Karat\n- Warna: Merah Standar Industri",
            'price' => 460000,
            'stock' => 10,
            'unit' => 'pcs',
            'weight' => '12.0 kg',
            'material' => 'Besi Press Baja',
            'image' => "produk/gerobak.jpeg", // Tanpa gambar default
            'is_active' => true
        ]);

        // 4. Create Simulated Orders & Payments

        // Order 1: Selesai & Paid
        // Item: p1 (Agrek, Qty: 2 @ 170.000 = 340.000) & p5 (Gancu, Qty: 1 @ 76.000 = 76.000)
        // Subtotal: 340.000 + 76.000 = 416.000
        $o1 = Order::create([
            'order_number' => 'EKI-SUCCESS-260607',
            'user_id' => $customer1->id,
            'subtotal' => 416000,
            'shipping_cost' => 0,
            'total_amount' => 416000,
            'status' => 'selesai',
            'payment_status' => 'paid',
            'payment_method'       => 'midtrans',
            'midtrans_order_id'    => 'EKI-SUCCESS-260607',
            'recipient_name'       => 'Ikhsan Gilang',
            'recipient_phone'      => '08987654321',
            'shipping_address'     => 'Jl. Pemuda No. 45, Tegal',
            'shipping_city'        => 'Tegal',
            'shipping_province'    => 'Jawa Tengah',
            'shipping_postal_code' => '52123',
            'paid_at'              => now()->subDays(2),
            'completed_at'         => now()->subDay(),
            'created_at'           => now()->subDays(3),
        ]);

        OrderItem::create(['order_id' => $o1->id, 'product_id' => $p1->id, 'quantity' => 2, 'price' => 170000, 'subtotal' => 340000]);
        OrderItem::create(['order_id' => $o1->id, 'product_id' => $p5->id, 'quantity' => 1, 'price' => 76000,  'subtotal' => 76000]);

        // Order 2: Pending Confirmation (Needs Admin Approval)
        $o2 = Order::create([
            'order_number' => 'EKI-PENDING-260607',
            'user_id' => $customer2->id,
            'subtotal' => 175000,
            'shipping_cost' => 0,
            'total_amount' => 175000,
            'status' => 'pending',
            'payment_status' => 'pending_confirmation',
            'payment_method'       => 'midtrans',
            'midtrans_order_id'    => 'EKI-PENDING-260607',
            'recipient_name'       => 'Budi Santoso',
            'recipient_phone'      => '087712345678',
            'shipping_address'     => 'Jl. Jenderal Sudirman No. 89, Pekanbaru',
            'shipping_city'        => 'Pekanbaru',
            'shipping_province'    => 'Riau',
            'shipping_postal_code' => '28123',
            'created_at'           => now()->subHours(5),
        ]);

        OrderItem::create(['order_id' => $o2->id, 'product_id' => $p2->id, 'quantity' => 1, 'price' => 80000, 'subtotal' => 80000]);
        OrderItem::create(['order_id' => $o2->id, 'product_id' => $p4->id, 'quantity' => 1, 'price' => 95000, 'subtotal' => 95000]);

        // Order 3: Unpaid / Pending
        $o3 = Order::create([
            'order_number' => 'EKI-UNPAID-260607',
            'user_id' => $customer1->id,
            'subtotal' => 85000,
            'shipping_cost' => 0,
            'total_amount' => 85000,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method'       => 'midtrans',
            'midtrans_order_id'    => 'EKI-UNPAID-260607',
            'recipient_name'       => 'Ikhsan Gilang',
            'recipient_phone'      => '08987654321',
            'shipping_address'     => 'Jl. Pemuda No. 45, Tegal',
            'shipping_city'        => 'Tegal',
            'shipping_province'    => 'Jawa Tengah',
            'shipping_postal_code' => '52123',
            'created_at'           => now()->subHours(1),
        ]);

        OrderItem::create(['order_id' => $o3->id, 'product_id' => $p6->id, 'quantity' => 1, 'price' => 85000, 'subtotal' => 85000]);

        // Order 4: Paid but not shipped (Sedang Dikemas)
        $o4 = Order::create([
            'order_number' => 'EKI-PACKING-260607',
            'user_id' => $customer1->id,
            'subtotal' => 330000,
            'shipping_cost' => 0,
            'total_amount' => 330000,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method'       => 'midtrans',
            'midtrans_order_id'    => 'EKI-PACKING-260607',
            'recipient_name'       => 'Ikhsan Gilang',
            'recipient_phone'      => '08987654321',
            'shipping_address'     => 'Jl. Pemuda No. 45, Tegal',
            'shipping_city'        => 'Tegal',
            'shipping_province'    => 'Jawa Tengah',
            'shipping_postal_code' => '52123',
            'created_at' => now()->subHour(),
        ]);

        OrderItem::create([
            'order_id' => $o4->id,
            'product_id' => $p3->id,
            'quantity' => 3,
            'price' => 110000,
            'subtotal' => 330000
        ]);
    }
}
