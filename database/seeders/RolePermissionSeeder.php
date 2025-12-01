<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role
        $roleAdmin = Role::create(['name' => 'admin']);
        // $roleKasir = Role::create(['name' => 'kasir']);

        // 2. Buat Permission (Opsional, contoh untuk POS)
        // Permission::create(['name' => 'lihat laporan']);
        // Permission::create(['name' => 'transaksi']);

        // 3. Assign Permission ke Role (Opsional)
        // $roleAdmin->givePermissionTo('lihat laporan');
        // $roleKasir->givePermissionTo('transaksi');

        // 4. Buat User Admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123')
        ]);
        $admin->assignRole($roleAdmin); // Assign role admin

        // // 5. Buat User Kasir
        // $kasir = User::create([
        //     'name' => 'Staff Kasir',
        //     'email' => 'kasir@pos.com',
        //     'password' => bcrypt('password123')
        // ]);
        // $kasir->assignRole($roleKasir); // Assign role kasir
    }
}
