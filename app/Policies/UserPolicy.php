<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        // Superadmin bisa create admin, author, user
        if ($authUser->isSuperAdmin()) {
            return true;
        }

        // Admin hanya bisa create author dan user
        if ($authUser->isAdmin()) {
            return true;
        }

        // Author dan user tidak boleh create user lain
        return false;
    }

    /**
     * Superadmin rules:
     * - Bisa edit/hapus siapa saja kecuali dirinya sendiri.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        // Tidak bisa edit dirinya sendiri
        if ($authUser->id === $targetUser->id) {
            return false;
        }

        // Superadmin bisa edit semua
        if ($authUser->isSuperAdmin()) {
            return true;
        }

        // Admin bisa edit user & author
        if ($authUser->isAdmin() && in_array($targetUser->role, ['author', 'user'])) {
            return true;
        }

        return false;
    }

    /**
     * Menentukan apakah user bisa menghapus user lain.
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        // Tidak bisa hapus dirinya sendiri
        if ($authUser->id === $targetUser->id) {
            return false;
        }

        // Superadmin bisa hapus semua kecuali dirinya
        if ($authUser->isSuperAdmin()) {
            return true;
        }

        // Admin bisa hapus user & author, tapi tidak bisa hapus sesama admin
        if ($authUser->isAdmin() && in_array($targetUser->role, ['author', 'user'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
