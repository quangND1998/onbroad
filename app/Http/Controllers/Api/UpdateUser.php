<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateUser extends Controller
{

    /**
     * @param App\Http\Requests\UpdateUserRequest $request
     * @param App\Models\User $user
     * @return UserResource 
    */
    public function __invoke(UpdateUserRequest $request , User $user)
    {
        try{
            DB::beginTransaction();

            $user->update($request->all());
            DB::commit();
            return new UserResource($user);
        }   
        catch(Exception $e){
            DB::rollBack();
            return $e;
        }
    }
}
