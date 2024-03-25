<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteUser extends Controller
{

    /**
     * @param App\Models\User $user
     */

    
    public function __invoke(User $user)
    {
        
        $user->delete();
        return new UserResource($user);
    }
}
