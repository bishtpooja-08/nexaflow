<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get the tenant
        $tenant = Tenant::where('slug', 'abc-technologies')->firstOrFail();

        // Get tenant roles
        $adminRole = Role::where('tenant_id', $tenant->id)
            ->where('slug', 'admin')
            ->firstOrFail();

        $managerRole = Role::where('tenant_id', $tenant->id)
            ->where('slug', 'sales-manager')
            ->firstOrFail();

        $agentRole = Role::where('tenant_id', $tenant->id)
            ->where('slug', 'sales-agent')
            ->firstOrFail();

        // Platform Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@nexaflow.test'],
            [
                'name' => 'Pooja',
                'password' => Hash::make('Pooja@123'),
                'tenant_id' => null,
                'user_type' => 'platform',
            ]
        );

        // Tenant Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@abc.test'],
            [
                'name' => 'Rahul',
                'password' => Hash::make('Rahul@123'),
                'tenant_id' => $tenant->id,
                'user_type' => 'tenant',
            ]
        );

        // Sales Manager
        $manager = User::updateOrCreate(
            ['email' => 'manager@abc.test'],
            [
                'name' => 'Amit',
                'password' => Hash::make('User@123'),
                'tenant_id' => $tenant->id,
                'user_type' => 'tenant',
            ]
        );

        // Sales Agent
        $agent = User::updateOrCreate(
            ['email' => 'agent@abc.test'],
            [
                'name' => 'Neha',
                'password' => Hash::make('Neha@123'),
                'tenant_id' => $tenant->id,
                'user_type' => 'tenant',
            ]
        );

        // Assign roles
        $admin->roles()->sync([$adminRole->id]);
        $manager->roles()->sync([$managerRole->id]);
        $agent->roles()->sync([$agentRole->id]);
    }
}
