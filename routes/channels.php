<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id)
{
    return (int)$user->id === (int)$id;
});

Broadcast::channel('lobby', static function (User $user)
{
    return [
        'user_name' => $user->user_name,
        'email'        => $user->email,
        'uuid'         => $user->email,
        'avatar'       => $user->avatar,
    ];
});
