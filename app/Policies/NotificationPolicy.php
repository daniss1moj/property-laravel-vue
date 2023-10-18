<?php

namespace App\Policies;

use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DatabaseNotification $notification): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DatabaseNotification $notification): bool
    {
        return $user->id === $notification->notifiable_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DatabaseNotification $notification): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DatabaseNotification $notification): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DatabaseNotification $notification): bool
    {
        return true;
    }
}