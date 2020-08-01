<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BalanceEntryRepositoryInterface;
use App\Http\Requests\AddBalanceEntryRequest;
use App\Http\Requests\ImportBalanceEntryRequest;
use App\Services\Entries\AddBalanceEntryService;
use App\Services\Entries\UpdateBalanceEntryService;
use App\Services\Entries\DeleteBalanceEntryService;
use App\Services\Entries\ImportBalanceEntryService;

use App\User;

class BalanceEntryController extends Controller
{

    private $balanceEntryRepository;

    public function __construct(BalanceEntryRepositoryInterface $balanceEntryRepository)
    {
        $this->balanceEntryRepository = $balanceEntryRepository;
    }

    public function index()
    {
        $userId = User::getDefaultUserId(); // returns 1 as default user ID
        return $this->balanceEntryRepository->getAllEntries($userId);
    }

    public function store(AddBalanceEntryRequest $addBalanceEntryRequest, AddBalanceEntryService $addBalanceEntry)
    {
        return $addBalanceEntry->handle($addBalanceEntryRequest);
    }

    public function update(AddBalanceEntryRequest $addBalanceEntryRequest, UpdateBalanceEntryService $updateBalanceEntry, $balanceEntryId)
    {
        $balanceEntryId = filter_var($balanceEntryId, FILTER_SANITIZE_NUMBER_INT);
        return $updateBalanceEntry->handle($addBalanceEntryRequest, $balanceEntryId);
    }

    public function delete(DeleteBalanceEntryService $deleteBalanceEntry, $balanceEntryId)
    {
        $balanceEntryId = filter_var($balanceEntryId, FILTER_SANITIZE_NUMBER_INT);
        return $deleteBalanceEntry->handle($balanceEntryId);
    }

    public function import(ImportBalanceEntryRequest $importBalanceEntryRequest, ImportBalanceEntryService $importBalanceEntry)
    {  
        return $importBalanceEntry->handle($importBalanceEntryRequest);
    }

}
