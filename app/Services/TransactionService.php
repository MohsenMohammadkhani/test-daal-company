<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionService
{

    /**
     * @param int $userID
     * @param int $userBalance
     * @param int $amount
     * @return int
     */
    public function addTransactionLog(int $userID, int $userBalance, int $amount): int
    {
        $newTransaction = Transaction::create([
            "user_id" => $userID,
            "balance_now" => $userBalance + $amount,
            "balance_before" => $userBalance,
            "amount" => $amount,
            "created_at" => new \DateTime("now"),
        ]);

        return $newTransaction->id;
    }

    /**
     * @param $specifyDay
     * @return int
     */
    public function getTotalAmountAllTransactionsInSpecifyDay($specifyDay): int
    {
        $transactions = Transaction::whereBetween('created_at', [$specifyDay, Carbon::parse($specifyDay)->addDay()])->get();
        $transactions = $transactions->all();
        $totalAmount = 0;
        foreach ($transactions as $transaction) {
            $totalAmount += $transaction->amount;
        }
        return $totalAmount;
    }
}
