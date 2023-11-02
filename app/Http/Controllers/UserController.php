<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequestAddMoneyToUserWallet;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function addMoneyToUserWallet(UserRequestAddMoneyToUserWallet $request)
    {
        try {
            $request->validated();
            $userID = $request->input('user_id');
            $amount = $request->input('amount');
            $transactionID = $this->userService->addMoneyToUserWallet($userID, $amount);
            return $this->showResponse([
                'reference_id' => $transactionID,
            ], 201);
        } catch (\Exception $error) {
            $this->showException(
                [
                    'success' => false,
                    'message' => $error->getMessage(),
                ]
                , 422);
        }
    }

    public function getBalanceUser(Request $request)
    {
        try {
            $this->checkUserIDOnParam($request);
            $userID = $request->route('userID');
            $userBalance = $this->userService->getBalanceUser($userID);
            return $this->showResponse([
                'balance' => $userBalance,
            ], 200);
        } catch (\Exception $error) {
            $this->showException(
                [
                    'success' => false,
                    'message' => $error->getMessage(),
                ]
                , 422);
        }
    }

    private function checkUserIDOnParam(Request $request)
    {
        if ($request->has('userID')) {
            throw new  \Exception('userID is not exist on url');
        }

        if (!is_numeric($request->route('userID'))) {
            throw new  \Exception('userID is invalid');
        }

    }
}
