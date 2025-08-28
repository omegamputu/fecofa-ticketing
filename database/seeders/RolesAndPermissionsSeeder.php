<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage (facultatif)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions principales
        $permissions = [
            'tickets.create',
            'tickets.view',
            'tickets.comment',
            'tickets.assign',
            'tickets.triage',
            'tickets.resolve',
            'tickets.reopen',
            'reports.view',
            'categories.manage',
            'sla.manage',
            'users.manage',
            'admin.access', // accès à /admin
        ];

        foreach ($permissions as $p)
        {
            Permission::findOrCreate($p);
        }

         // Rôles FECOFA
        $admin       = Role::findOrCreate('Admin');
        $technicien  = Role::findOrCreate('Technicien');
        $demandeur   = Role::findOrCreate('Demandeur');
        $observateur = Role::findOrCreate('Observateur');

        // Attribution rules
        $admin->givePermissionTo($permissions);

        $technicien->givePermissionTo([
            'tickets.view','tickets.comment','tickets.triage','tickets.assign','tickets.resolve','tickets.reopen','reports.view'
        ]);

        $demandeur->givePermissionTo([
            'tickets.create','tickets.view','tickets.comment','tickets.reopen'
        ]);

        $observateur->givePermissionTo(['reports.view']);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
