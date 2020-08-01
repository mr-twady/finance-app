<?php

namespace App\Repositories\Interfaces;

interface BalanceEntryRepositoryInterface
{
    public function getAllEntries($userId);
}
