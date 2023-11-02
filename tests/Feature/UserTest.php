<?php

namespace Tests\Feature;

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

    public function test_get_balance_user()
    {
        $userID = 1;
        $balance = 1000;
        $this->makeNewUser($balance);
        $response = $this->withHeaders([
            "Content-Type" => "application/json"
        ])->getJson("/api/v1/user/$userID/get-balance");
        $response->assertStatus(200);
        $this->assertEquals($response->original['balance'], $balance);
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
        $userBalance = 100;
        $userID = 1;
        $amount = 100;
        $this->makeNewUser($userBalance);

        $response = $this->withHeaders([
            "Content-Type" => "application/json"
        ])->postJson("/api/v1/user/add-money",
            [
                "amount" => $amount,
                "user_id" => $userID
            ]);
        $response->assertStatus(201);
//        $this->assertEquals($response->original['reference_id'], 1);

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
