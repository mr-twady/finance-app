<?php

namespace App\Services\Entries;

use App\Services\User\UpdateUserBalanceService;
use App\User;
use App\BalanceEntry;

class ImportBalanceEntryService
{

    public function handle($request)
    {       
        // // update entry 
        // $balanceEntryId = $request->balance_entry_id;  
        // $balanceEntry = BalanceEntry::find($balanceEntryId);
        // // $currentBalance = $balanceEntry->amount;
        // // $deleteBalanceEntry = $balanceEntry->delete();

        // // 'user_id', 'label', 'amount', 'created_at'
        
        // // then update balance
        // $userId = User::getDefaultUserId();
        // $user = User::find($userId);
        // $user->balance = $user->balance + ($currentBalance);
        // $updateBalance = $user->save();
        
        // return 
        // (   
        //     $deleteBalanceEntry && $updateBalance ? 
        //     response()->successResponse(null, "Balance entry deleted successfully", 200) : 
        //     response()->errorResponse(null, "Attempt to delete balance entry failed", 400)
        // );
    }

}
