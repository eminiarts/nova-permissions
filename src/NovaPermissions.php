<?php

namespace Eminiarts\NovaPermissions;

use Eminiarts\NovaPermissions\Nova\Permission;
use Eminiarts\NovaPermissions\Nova\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPermissions extends Tool
{
    /**
     * @var mixed
     */
    public $permissionResource = Permission::class;

    /**
     * @var mixed
     */
    public $roleResource = Role::class;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('permissions', __DIR__ . '/../dist/js/field.js');
        Nova::style('permissions', __DIR__ . '/../dist/css/field.css');

        Nova::resources([
            $this->roleResource,
            $this->permissionResource,
        ]);
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Roles & Permissions';
    }

    /**
     * @param string $permissionResource
     * @return mixed
     */
    public function permissionResource(string $permissionResource)
    {
        $this->permissionResource = $permissionResource;

        return $this;
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View
     */
    public function renderNavigation()
    {
        return view('nova-permissions::navigation');
    }

    /**
     * @param string $roleResource
     * @return mixed
     */
    public function roleResource(string $roleResource)
    {
        $this->roleResource = $roleResource;

        return $this;
    }

    public function menu(Request $request)
    {
        return MenuSection::make('Security', [
            MenuItem::resource(Role::class),
            MenuItem::resource(Permission::class),
        ])->icon('shield');
    }
}
