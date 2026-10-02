<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::where('slug', 'abc-technologies')->firstOrFail();

        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Sales Manager',
                'slug' => 'sales-manager',
            ],
            [
                'name' => 'Sales Agent',
                'slug' => 'sales-agent',
            ]

        ];

        foreach($roles as $role){
            Role::updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'slug' => $role['slug'],
                ],
                [
                    'name' => $role['name'],
                ]
            );
        }
    }
}
