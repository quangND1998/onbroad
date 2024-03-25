<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FetchUsers extends Controller
{
    public function __invoke()
    {
         return UserResource::collection(User::all());
    }
}
