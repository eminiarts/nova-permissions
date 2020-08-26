<?php
namespace Eminiarts\NovaPermissions;

use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * Find or create permission by its name and group (and optionally guardName).
     *
     * @param string $name
     * @param string $group
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Permission
     */
    public static function findOrCreateWithGroup(string $name, string $group, $guardName = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermissions(['name' => $name, 'group' => $group, 'guard_name' => $guardName])->first();

        if (! $permission) {
            return static::query()->create(['name' => $name, 'group' => $group, 'guard_name' => $guardName]);
        }

        return $permission;
    }
}
