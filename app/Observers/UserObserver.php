<?php

namespace App\Observers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * @param User $user
     */
    public function saved(User $user)
    {
        Cache::put("user.{$user->id}", $user, now()->addMinutes(60));
    }
    /**
     * @param User $user
     */
    public function deleted(User $user)
    {
        Cache::forget("user.{$user->id}");
    }
    /**
     * @param User $user
     */
    public function restored(User $user)
    {
        Cache::put("user.{$user->id}", $user, now()->addMinutes(60));
    }
    /**
     * @param User $user
     */
    public function retrieved(User $user)
    {
        Cache::add("user.{$user->id}", $user, now()->addMinutes(60));
    }
}
