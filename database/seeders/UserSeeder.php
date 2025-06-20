<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gudang.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
    
        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'gudang@gudang.com',
            'password' => Hash::make('gudang123'),
            'role' => 'gudang'
        ]);
    }
}
