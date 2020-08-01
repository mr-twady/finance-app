<?php

namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function getUserDetails($userId)
    {
        $userDetails = User::find($userId);

        return 
        (   
            $userDetails? 
            response()->successResponse($userDetails, "User's details fetched successfully", 200) : 
            response()->errorResponse(null, "Attempt to fetch user's details failed", 400)
        );
    }
    
}
