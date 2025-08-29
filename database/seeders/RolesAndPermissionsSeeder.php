<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            // Tickets
            'tickets.create','tickets.view','tickets.comment','tickets.triage',
            'tickets.assign','tickets.resolve','tickets.reopen',

            // Paramétrage
            'categories.manage','sla.manage',

            // Rapports
            'reports.view',

            // Administration
            'users.manage',          // CRUD utilisateurs (hors admins)
            'admins.manage',         // créer/éditer Admins
            'roles.manage',          // créer/éditer rôles
            'permissions.manage',    // (optionnel) gérer les permissions
            'admin.access',          // accès à /admin
        ];

        foreach ($permissions as $p)
        {
            Permission::findOrCreate($p, 'web');
        }

        // Rôles FECOFA
        $super  = Role::findOrCreate('Super-Admin', 'web');
        $admin  = Role::findOrCreate('Admin', 'web');
        $tech   = Role::findOrCreate('Technicien', 'web');
        $dem    = Role::findOrCreate('Demandeur', 'web');
        $obs    = Role::findOrCreate('Observateur', 'web');

        // ---- Permissions par rôle (hors Super-Admin qui a tout via Gate::before)
        $admin->syncPermissions([
            'admin.access','users.manage','categories.manage','sla.manage',
            'reports.view','tickets.view','tickets.comment','tickets.triage','tickets.assign','tickets.resolve','tickets.reopen',
            // 👉 Ajoute 'admins.manage','roles.manage' si tu veux que l'Admin gère aussi les Admins et rôles
        ]);

        $tech->syncPermissions([
            'tickets.view','tickets.comment','tickets.triage','tickets.assign','tickets.resolve','tickets.reopen','reports.view'
        ]);

        $dem->syncPermissions([
            'tickets.create','tickets.view','tickets.comment','tickets.reopen'
        ]);

        $obs->syncPermissions(['reports.view']);

        // ---- Super-Admin par défaut (via variables d'env si dispos)
        $email = env('SUPER_ADMIN_EMAIL', 'superadmin@fecofa.cd');
        $pass  = env('SUPER_ADMIN_PASSWORD', 'ChangeMoi#2025');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin FECOFA',
                'password' => Hash::make($pass),
            ]
        );
        $user->syncRoles(['Super-Admin']);


        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
