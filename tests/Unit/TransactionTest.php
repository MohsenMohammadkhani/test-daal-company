<?php

namespace Tests\Unit;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;
use App\Services\TransactionService;

class TransactionTest extends TestCase
{
    protected function tearDown(): void
    {
        DB::table('transactions')->truncate();
    }

    private function makeNewTransactions($userID, $amount, $balance, $date)
    {
        Transaction::create([
            "user_id" => $userID,
            "balance_now" => $balance + $amount,
            "balance_before" => $balance,
            "amount" => $amount,
            "created_at" => $date
        ]);
    }

    public function test_get_total_amount_all_transactions_in_specify_day()
    {
        $nowDate = date("Y-m-d");

        $this->makeNewTransactions(1, 200, 300, $nowDate);
        $this->makeNewTransactions(1, 400, 500, $nowDate);

        $this->makeNewTransactions(1, 700, 900, Carbon::parse($nowDate)->addDays(2));

        $transactionService = new TransactionService();
        $totalAmount = $transactionService->getTotalAmountAllTransactionsInSpecifyDay($nowDate);

        $this->assertEquals($totalAmount, 200 + 400);
    }

}
