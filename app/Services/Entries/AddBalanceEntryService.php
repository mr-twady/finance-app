<?php

namespace App\Services\Entries;

use App\Services\User\UpdateUserBalanceService;
use App\User;
use App\BalanceEntry;

class AddBalanceEntryService
{

    private $updateUserBalance;
    private $model;

    public function __construct(UpdateUserBalanceService $updateUserBalance, User $user)
    {
        $this->updateUserBalance = $updateUserBalance;
        $this->model = $user;
    }

    public function handle($request)
    {
        $userId = User::getDefaultUserId();
        $data = ['user_id' => $userId,  'label' => $request->label, 'amount' => $request->amount, 'created_at' => $request->date];
        $saveBalanceEntry = BalanceEntry::create($data);
        
        if($saveBalanceEntry)
        {
            $userBalance = $this->updateUserBalance->handle($data['amount'], $operatorDecider = 1, $this->model);
            return response()->successResponse(['balance'=>$userBalance], "Balance entry added successfully", 200);
        }
        
        return response()->errorResponse(null, "Attempt to add balance entry failed", 400);
    }

}
