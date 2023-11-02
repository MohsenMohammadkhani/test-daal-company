<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function tearDown(): void
    {
        DB::table('users')->truncate();
        DB::table('transactions')->truncate();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_balance_user()
    {
        $balance = 1000;
        $this->makeNewUser($balance);
        $userService = new UserService();

        $this->assertEquals($userService->getBalanceUser(1), $balance);
    }

    public function test_check_user_is_exist()
    {
        $this->expectException(\Exception::class);
        $balance = 1000;
        $userService = new UserService();
        $this->assertEquals($userService->getBalanceUser(1), $balance);
    }

    public function test_add_money_to_user_wallet()
    {
        $balance = 100;
        $userID = 1;
        $amount = 100;
        $newBalance = $balance + $amount;
        $this->makeNewUser($balance);

        $userService = new UserService();
        $referenceID = $userService->addMoneyToUserWallet($userID, $amount);

        $this->assertEquals(User::find($userID)->balance, $newBalance);
        $this->assertEquals($referenceID, 1);
    }

    private function makeNewUser($balance)
    {
        User::create([
            "name" => "mohsen",
            "balance" => $balance,
        ]);
    }

    private function makeNewTransactions($userID, $amount, $balance)
    {
        Transaction::create([
            "user_id" => $userID,
            "balance_now" => $balance + $amount,
            "balance_before" => $balance,
            "amount" => $amount,
            "created_at" => new \DateTime("now"),
        ]);
    }
}
