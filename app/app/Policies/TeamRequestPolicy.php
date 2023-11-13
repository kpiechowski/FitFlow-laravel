<?php

namespace App\Policies;

use App\Models\TeamRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeamRequest $teamRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeamRequest $teamRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeamRequest $teamRequest): bool
    {
        //
        return $user->id === $teamRequest->team->leader_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TeamRequest $teamRequest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TeamRequest $teamRequest): bool
    {
        //
    }

    public function isAuthorized(User $user, TeamRequest $teamRequest){
        // dd($teamRequest);
        return $user->id === $teamRequest->team->leader_id;
    }
}
