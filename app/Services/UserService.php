<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param int $userID
     * @return int balance
     * @throws \Exception
     */
    public function getBalanceUser(int $userID): int
    {
        $user = $this->findUserByID($userID);
        return $user->balance;
    }

    /**
     * @param int $userID
     * @param int $amount
     * @return int
     * @throws \Exception
     */
    public function addMoneyToUserWallet(int $userID, int $amount): int
    {
        $user = $this->findUserByID($userID);
        $userBalance = $user->balance;
        $newUserBalance = $userBalance + $amount;
        $user->balance = $newUserBalance;
        $user->save();

        $transactionService = new TransactionService();
        return $transactionService->addTransactionLog($userID, $userBalance, $amount);
    }


    /**
     * @param int $userID
     * @return User
     * @throws \Exception
     */
    private function findUserByID(int $userID): User
    {
        $user = User::find($userID);
        if (!$user) {
            throw new \Exception('User Dose Not Exist');
        }
        return $user;
    }

}
