<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\DB;

class UserDeleteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        if (isset($event->user) && $event->user instanceof User) {
            $user = $event->user;
            $userDetails = $user->details()->first();
            DB::transaction(function () use ($user, $userDetails) {
                if ($userDetails) {
                    UserDetails::destroy($userDetails->id);
                }
                User::destroy($user->id);
            });
        }
    }
}
