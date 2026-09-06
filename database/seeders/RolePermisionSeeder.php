<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Departments
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            // Offices
            'offices.view',
            'offices.create',
            'offices.update',
            'offices.delete',

            // Employees
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.delete',

            // Assets
            'assets.view',
            'assets.create',
            'assets.update',
            'assets.delete',

            // Asset Categories
            'asset_categories.view',
            'asset_categories.create',
            'asset_categories.update',
            'asset_categories.delete',

            // Asset Assignments
            'asset_assignments.view',
            'asset_assignments.create',
            'asset_assignments.update',
            'asset_assignments.delete',

            // Asset Maintenance
            'asset_maintenances.view',
            'asset_maintenances.create',
            'asset_maintenances.update',
            'asset_maintenances.delete',

            // Help Desk Tickets
            'tickets.view',
            'tickets.create',
            'tickets.update',
            'tickets.delete',
            'tickets.assign',
            'tickets.resolve',
            'tickets.close',

            // Ticket Comments
            'ticket_comments.view',
            'ticket_comments.create',
            'ticket_comments.update',
            'ticket_comments.delete',
            'ticket_comments.internal',

            // Reports
            'reports.view',
            'reports.export',

            // Audit Logs
            'audit_logs.view',

            // Settings
            'settings.view',
            'settings.update',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $ictManager = Role::firstOrCreate([
            'name' => 'ICT Manager',
            'guard_name' => 'web',
        ]);

        $ictTechnician = Role::firstOrCreate([
            'name' => 'ICT Technician',
            'guard_name' => 'web',
        ]);

        $employee = Role::firstOrCreate([
            'name' => 'Employee',
            'guard_name' => 'web',
        ]);

        $auditor = Role::firstOrCreate([
            'name' => 'Auditor',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );

        /*
        |--------------------------------------------------------------------------
        | ICT Manager
        |--------------------------------------------------------------------------
        */

        $ictManager->syncPermissions([
            'users.view',
            'users.create',
            'users.update',

            'departments.view',
            'departments.create',
            'departments.update',

            'offices.view',
            'offices.create',
            'offices.update',

            'employees.view',
            'employees.create',
            'employees.update',

            'assets.view',
            'assets.create',
            'assets.update',

            'asset_categories.view',
            'asset_categories.create',
            'asset_categories.update',

            'asset_assignments.view',
            'asset_assignments.create',
            'asset_assignments.update',

            'asset_maintenances.view',
            'asset_maintenances.create',
            'asset_maintenances.update',

            'tickets.view',
            'tickets.create',
            'tickets.update',
            'tickets.assign',
            'tickets.resolve',
            'tickets.close',

            'ticket_comments.view',
            'ticket_comments.create',
            'ticket_comments.update',
            'ticket_comments.internal',

            'reports.view',
            'reports.export',

            'audit_logs.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ICT Technician
        |--------------------------------------------------------------------------
        */

        $ictTechnician->syncPermissions([
            'users.view',

            'departments.view',
            'offices.view',
            'employees.view',

            'assets.view',
            'assets.update',

            'asset_categories.view',

            'asset_assignments.view',
            'asset_assignments.create',
            'asset_assignments.update',

            'asset_maintenances.view',
            'asset_maintenances.create',
            'asset_maintenances.update',

            'tickets.view',
            'tickets.create',
            'tickets.update',
            'tickets.assign',
            'tickets.resolve',

            'ticket_comments.view',
            'ticket_comments.create',
            'ticket_comments.update',
            'ticket_comments.internal',

            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Employee
        |--------------------------------------------------------------------------
        */

        $employee->syncPermissions([
            'tickets.view',
            'tickets.create',
            'tickets.update',

            'ticket_comments.view',
            'ticket_comments.create',

            'assets.view',

            'employees.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Auditor
        |--------------------------------------------------------------------------
        */

        $auditor->syncPermissions([
            'users.view',
            'departments.view',
            'offices.view',
            'employees.view',

            'assets.view',
            'asset_categories.view',
            'asset_assignments.view',
            'asset_maintenances.view',

            'tickets.view',
            'ticket_comments.view',

            'reports.view',
            'reports.export',

            'audit_logs.view',
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
