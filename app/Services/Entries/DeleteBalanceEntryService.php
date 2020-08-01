<?php

namespace App\Services\Entries;

use App\Services\User\UpdateUserBalanceService;
use App\User;
use App\BalanceEntry;

class DeleteBalanceEntryService
{

    private $updateUserBalance;
    private $model;

    public function __construct(UpdateUserBalanceService $updateUserBalance, User $user)
    {
        $this->updateUserBalance = $updateUserBalance;
        $this->model = $user;
    }

    public function handle($balanceEntryId)
    {       
        $balanceEntry = BalanceEntry::find($balanceEntryId);
        if(!$balanceEntry) return response()->errorResponse(null, "Attempt to delete balance entry failed", 400);

        $entryBalance = $balanceEntry->amount;
        $deleteBalanceEntry = $balanceEntry->delete();

        if($deleteBalanceEntry)
        {
            $userBalance = $this->updateUserBalance->handle($entryBalance, $operatorDecider = 0, $this->model);
            return response()->successResponse(['balance'=>$userBalance], "Balance entry deleted successfully", 200);
        }
        
        return response()->errorResponse(null, "Could not delete balance entry", 400);
    }

}
