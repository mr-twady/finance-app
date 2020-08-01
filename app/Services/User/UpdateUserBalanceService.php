<?php

namespace App\Services\User;

class UpdateUserBalanceService
{

    /** 
     * $operatorDecider can be 0 or 1
     * Upon a delete request, value 0 will be sent as $operatorDecider which implies a subtraction operation
     * Upon an addition/update request, value 1 will be sent as $operatorDecider which implies an addition operation
     * 
     */
    public function handle(float $amount, bool $operatorDecider, object $model)
    {   
        $userId = $model::getDefaultUserId();
        $user = $model::find($userId);
        $user->balance = ($operatorDecider==1)? $user->balance + ($amount) : $user->balance - ($amount);
        $updateBalance = $user->save();  

        return $user->balance;
    }

}
