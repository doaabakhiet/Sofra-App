<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'city-list',
            'city-create',
            'city-edit',
            'city-delete',
            'classification-list',
            'classification-create',
            'classification-edit',
            'classification-delete',
            'contact-list',
            'contact-create',
            'contact-edit',
            'contact-delete',
            'neighborhood-list',
            'neighborhood-create',
            'neighborhood-edit',
            'neighborhood-delete',
            'offer-list',
            'offer-create',
            'offer-edit',
            'offer-delete',
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'review-list',
            'review-create',
            'review-edit',
            'review-delete',
            'setting-list',
            'setting-create',
            'setting-edit',
            'setting-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'restaurant-list',
            'restaurant-create',
            'restaurant-edit',
            'restaurant-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'account-list',
            'account-create',
            'account-edit',
            'account-delete',
            'feespaid-list',
            'feespaid-create',
            'feespaid-edit',
            'feespaid-delete',
            ];
            foreach ($permissions as $permission) {
            ModelsPermission::create(['name' => $permission]);
            }
    }
}
