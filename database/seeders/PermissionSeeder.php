<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $all = ['view-products', 'create-products', 'edit-products', 'delete-products', 'view-activity-log'];

        foreach ($all as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        Role::firstOrCreate(['name' => 'admin'])->syncPermissions($all);

        Role::firstOrCreate(['name' => 'user'])
            ->syncPermissions(['view-products']);
    }
}
