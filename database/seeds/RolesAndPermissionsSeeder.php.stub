<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'users',
            'roles',
            'permissions',
            // 'teams', 
            // ... // List all your Models you want to have Permissions for.
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['group' => $item, 'name' => 'view ' . $item]);
            Permission::create(['group' => $item, 'name' => 'view own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'restore ' . $item]);
            Permission::create(['group' => $item, 'name' => 'forceDelete ' . $item]);
        });

        // Create a Super-Admin Role and assign all Permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        // $user = App\User::whereEmail('your@email.com')->first(); // Change this to your email.
        // $user->assignRole('super-admin');
    }
}
