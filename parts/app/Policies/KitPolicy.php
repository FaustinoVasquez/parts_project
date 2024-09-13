<?php

namespace App\Policies;

use App\Models\User;
use App\Models\kit;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;

class KitPolicy
{
    use HandlesAuthorization;

    public function before(User $user ,$hability)
    {
        if ($user->isAdmin()){
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
//        return  $user->role =='admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\kit  $kit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, kit $kit)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\kit  $kit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, kit $kit)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\kit  $kit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, kit $kit)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\kit  $kit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, kit $kit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\kit  $kit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, kit $kit)
    {
        //
    }
}
