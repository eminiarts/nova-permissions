# Laravel Nova Grouped Permissions
A Laravel Nova Tool that allows you to group your Permissions into Groups and attach it to Users. It uses Spatie's laravel-permission.

1. [Installation](#Installation)
2. [Permissions with Groups](#permissions-with-groups)
    * [Detail View](#detail-view)
    * [Edit View](#edit-view)
    * [Database Seeding](#database-seeding)
    * [Create a Model Policy](#create-a-model-policy)
    * [Super Admin](#super-admin)
3. [Customization](#customization)
    * [Use your own Resources](#use-your-own-resources)
4. [Credits](#credits)

![image](https://user-images.githubusercontent.com/3426944/50086531-ae0dbb80-01fd-11e9-835f-f65bba2c0a7b.png)


## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require eminiarts/nova-permissions
```

Publish the Migration with the following command:

```bash
php artisan vendor:publish --provider="Eminiarts\NovaPermissions\ToolServiceProvider" --tag="migrations"
```

This migration has a `group` field in order to allow groups.

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        \Eminiarts\NovaPermissions\NovaPermissions(),
    ];
}
```

Finally, add `MorphToMany` fields to you `app/Nova/User` resource:

```php
// ...
use Laravel\Nova\Fields\MorphToMany;

public function fields(Request $request)
{
    return [
        // ...
        MorphToMany::make('Roles', 'roles', \Eminiarts\NovaPermissions\Role::class),
        MorphToMany::make('Permissions', 'permissions', \Eminiarts\NovaPermissions\Permission::class),
    ];
}
```

A new menu item called **Permissions & Roles** will appear in your Nova app after installing this package.

## Permissions with Groups

### Detail View

![image](https://user-images.githubusercontent.com/3426944/50088581-b1a44100-0203-11e9-8ae8-c21cc0b02393.png)

### Edit View

![image](https://user-images.githubusercontent.com/3426944/50088682-0051db00-0204-11e9-8201-1ac4b57f0631.png)


The Checkboxes Field expects an array with **group, option, label**. If you want to show all Permissions on your Role Resource, you can use the following options:

```php
// in App/Nova/Role;

use Eminiarts\FieldCheckboxes\Checkboxes;

public function fields()
{
    return [
        // ...
        Checkboxes::make(__('Permissions'), 'prepared_permissions')->withGroups()->options(SpatiePermission::all()->map(function ($permission, $key) {
                return [
                    'group'  => __(ucfirst($permission->group)),
                    'option' => $permission->name,
                    'label'  => __($permission->name),
                ];
            })->groupBy('group')->toArray())
        ,
    ];
}
```

### Database Seeding

This is just an example on how you could seed your Database with Roles and Permissions. Create a new `RolesAndPermissionsSeeder.php` in `database/seeds`:

```php
<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

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
            'invoices',
            'clients',
            'contacts',
            'payments',
            'teams',
            'users',
            'roles',
            // ... your own models/permission you want to crate
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

        // create a Super-Admin Role and assign all permissions to it
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        $user = App\User::whereEmail('your@email.com')->first();
        $user->assignRole('super-admin');
    }
}
```

### Create a Model Policy

You can extend `Eminiarts\NovaPermissions\Policies\Policy` and have a very clean Model Policy that works with Nova.

For Example: Create a new Contact Policy with `php artisan make:policy ContactPolicy` with the following code:

```php
<?php
namespace App\Policies;

use Eminiarts\NovaPermissions\Policies\Policy;

class ContactPolicy extends Policy
{
    /**
     * The Permission key the Policy corresponds to.
     *
     * @var string
     */
    public static $key = 'contacts';
}
```
It should now work as exptected. Just create a Role, modify its Permissions and the Policy should take care of the rest.
> **Note**: Only extend the Policy if you have created your Permissions according to our Seeding Example. Otherwise, make sure to have `view contacts, view own contacts, manage contacts, manage own contacts, restore contacts,  forceDelete contacts` as Permissions in your Table in order to extend our Policy.

> `view own contacts` is superior to `view contacts` and allows the User to only view his own Contacts.

> `manage own contacts` is superior to `manage contacts` and allows the User to only manage his own Contacts.

### Super Admin

A Super Admin can do everything. If you extend our Policy, make sure to add a `isSuperAdmin()` Function to your `App\User` Model:

```php
<?php
namespace App;

class User {
    /**
     * Determines if the User is a Super admin
     * @return null
    */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
```

> You can modify this function as you please.

## Customization

### Use your own Resources

If you want to use your own resource classes, you can define them when you register the tool:

```php
// in app/Providers/NovaServiceProvider.php

// ...

use App\Nova\Role;
use App\Nova\Permission;

public function tools()
{
    return [
        // ...
        \Eminiarts\NovaPermissions\NovaPermissionTool::make()
            ->roleResource(Role::class)
            ->permissionResource(Permission::class),
    ];
}
```

## Credits

This Package is inspired by [vyuldashev/nova-permission](https://novapackages.com/packages/vyuldashev/nova-permission) and [silvanite/novatoolpermissions](https://novapackages.com/packages/silvanite/novatoolpermissions). I wanted to have a combination of both. Thanks to both authors. Also, a huge thanks goes to Spatie [spatie/laravel-permission](https://github.com/spatie/laravel-permission) for their amazing work!
