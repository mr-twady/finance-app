<?php

namespace App\Services\Entries;

use App\Services\User\UpdateUserBalanceService;
use App\User;
use App\BalanceEntry;

class UpdateBalanceEntryService
{

    private $updateUserBalance;
    private $model;

    public function __construct(UpdateUserBalanceService $updateUserBalance, User $user)
    {
        $this->updateUserBalance = $updateUserBalance;
        $this->model = $user;
    }

    public function handle($request, $balanceEntryId)
    {       
        $requestData = $request->all();
        $requestData['created_at'] = $requestData['date'];
        unset($requestData['date']);
        
        $balanceEntry = BalanceEntry::find($balanceEntryId);
        if(!$balanceEntry) return response()->errorResponse(null, "Attempt to update balance entry failed", 400);
        $balanceEntryOldAmount = $balanceEntry->amount;
        $balanceEntry->fill($requestData)->save();  

        if($balanceEntry->getChanges())
        {
            $amountDifference = $requestData['amount'] - $balanceEntryOldAmount;
            // dd($amountDifference,  $requestData['amount'], $balanceEntryOldAmount);
            $userBalance = $this->updateUserBalance->handle( $amountDifference, $operatorDecider = 1, $this->model);
            return response()->successResponse(['balance'=>$userBalance], "Balance entry updated successfully", 200);
        }

        return response()->errorResponse(null, "No changes were made", 400);
    }

}
