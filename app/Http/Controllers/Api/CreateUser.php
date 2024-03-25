<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreateUser extends Controller
{

    /**
     * @param App\Http\Requests\StoreUserRequest $request
     * @return UserResource 
    */
    public function __invoke(StoreUserRequest $request){
        try {
            DB::beginTransaction();
            $data = $request->all();
            $user = User::create($data);
            DB::commit();
            return new UserResource($user);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }
}
