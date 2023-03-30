<?php
namespace Database\Seeders\Packages\Shops;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class MarinarShopsSeeder extends Seeder {

    public function run() {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::upsert([
            ['guard_name' => 'admin', 'name' => 'shops.view'],
            ['guard_name' => 'admin', 'name' => 'shop.create'],
            ['guard_name' => 'admin', 'name' => 'shop.update'],
            ['guard_name' => 'admin', 'name' => 'shop.delete'],
        ], ['guard_name','name']);
    }
}
