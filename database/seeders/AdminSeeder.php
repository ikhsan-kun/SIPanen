<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat atau update admin - aman dijalankan berkali-kali
        User::updateOrCreate(
            ['email' => 'admin@ekiindo.com'],
            [
                'name'     => 'Admin CV. Ekiindo',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'phone'    => '08123456789',
            ]
        );

        $this->command->info('✅ Admin berhasil dibuat/diperbarui.');
        $this->command->info('   Email   : admin@ekiindo.com');
        $this->command->info('   Password: admin123');
    }
}
