<?php

namespace App\Repositories;

use App\BalanceEntry;
use App\Repositories\Interfaces\BalanceEntryRepositoryInterface;

use DB;

class BalanceEntryRepository implements BalanceEntryRepositoryInterface
{

    public function getAllEntries($userId)
    {
        $entries = $this->getGroupedEntries($userId);

        return 
        (   
            $entries['has_result']? 
            response()->successResponse($entries, "User's balance entries fetched successfully", 200) : 
            response()->errorResponse(null, $entries['message'], 400)
        );
    }

    private function getGroupedEntries($userId)
    {
        $queryResult = DB::select("SELECT CAST(created_at AS DATE) AS days_date, SUM(amount) AS days_total from balance_entries WHERE user_id='$userId' AND deleted_at IS NULL GROUP BY CAST(created_at AS DATE) ORDER BY days_date DESC ");

        if($queryResult)
        {
            $groupedEntries = [];
            $i = 0;
            foreach($queryResult as $qry)
            {
                $daysDate = $qry->days_date;
                $daysTotal = $qry->days_total;
                $shortFriendlyDate = $this->makeDateHumanFriendly($daysDate);
                $daysDateBegins = $daysDate." 00:00:00";
                $daysDateEnds = $daysDate." 23:59:59";
                $daysEntries = BalanceEntry::where('user_id',$userId)->whereBetween('created_at',[$daysDateBegins, $daysDateEnds])->orderBy('created_at','desc')->get();
                $groupedEntries[$i] = ['short_friendly_date'=>$shortFriendlyDate, 'total'=>$daysTotal, 'entries'=>$daysEntries] ;
                $i++;
            }
            return ['has_result'=>true, 'data'=>$groupedEntries];
        }

        return ['has_result'=>false, 'message'=>'No balance entry record for this user'];
    }

    private function makeDateHumanFriendly($daysDate)
    {
        if($daysDate == date('Y-m-d'))
            $shortFriendlyDate = 'Today';
        elseif($daysDate == date('Y-m-d', strtotime('yesterday')))
            $shortFriendlyDate = 'Yesterday';
        else
            $shortFriendlyDate = date("D, d M", strtotime($daysDate));

        return $shortFriendlyDate;
    } 
    
}
