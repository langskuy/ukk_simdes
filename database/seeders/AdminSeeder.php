<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Desa',
                'password' => bcrypt('admin123'),
                'role' => 'admin', // jika tabel user ada kolom role
            ]
        );
    }
}
