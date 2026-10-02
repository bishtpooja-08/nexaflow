<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Leads', 'slug' => 'lead.view'],
            ['name' => 'Create Leads', 'slug' => 'lead.create'],
            ['name' => 'Update Leads', 'slug' => 'lead.update'],
            ['name' => 'Delete Leads', 'slug' => 'lead.delete'],
            ['name' => 'Assign Leads', 'slug' => 'lead.assign'],
            ['name' => 'Manage Users', 'slug' => 'user.manage'],
            ['name' => 'View Tasks', 'slug' => 'task.view'],
            ['name' => 'Create Tasks', 'slug' => 'task.create'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
