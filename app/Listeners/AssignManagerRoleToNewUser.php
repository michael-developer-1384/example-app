<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Role;

class AssignManagerRoleToNewUser
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $managerRole = Role::where('name', 'Manager')->first();

        if ($managerRole) {
            $event->user->roles()->attach($managerRole);
        }
    }
}
