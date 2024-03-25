<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserDetail extends Controller
{
    public function __invoke(User $user)
    {
        return new UserResource($user);
    }
}
