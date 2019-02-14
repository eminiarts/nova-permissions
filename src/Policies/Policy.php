<?php
namespace Eminiarts\NovaPermissions\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(['manage ' . static::$key, 'manage own ' . static::$key]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function delete(User $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo('manage own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return $user->hasPermissionTo('manage ' . static::$key);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo('manage own ' . static::$key) && $user->hasPermissionTo('forceDelete ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return $user->hasPermissionTo('forceDelete ' . static::$key);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo('manage own ' . static::$key) && $user->hasPermissionTo('restore ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return $user->hasPermissionTo('restore ' . static::$key);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo('manage own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return $user->hasPermissionTo('manage ' . static::$key);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user, $model)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->hasPermissionTo('view own ' . static::$key)) {
            return $user->id == $model->user_id;
        }

        return $user->hasPermissionTo('view ' . static::$key);
    }

    /**
     * @param User $user
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view ' . static::$key);
    }
}
