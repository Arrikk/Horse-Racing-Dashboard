<?php

namespace App\Controllers\Api;

use App\Controllers\Auth\Authenticated;
use App\Models\Balance;
use App\Models\User;
use App\Models\Wallet;
use Core\Http\Res;

class Wallets extends Authenticated
{
    /**
     * 
     */
    public function _load()
    {
        $inWallets = $this->wallets();

        $walletBalance = $this->user->wallets();

        /**
         * Loop through the wallets list from Wallet
         * use the the wallet array object gotten from wallet balance
         * model to filter and get the balance of wallet
         * @param array $inWallet Wallets
         * @param array $walletBalance wallet balance
         */
        $wallet_ref = array_map(function ($wallet) use ($walletBalance) {
            /**
             * From inside the wallet Filter the wallets with their id
             * Map and return wallet balance matching wallet ID of wallet model
             */
            $walletBalance = array_filter($walletBalance,  function ($balance) use ($wallet) {
                return ($balance->wallet_id ?? '') == $wallet->wallet_id;
            }, ARRAY_FILTER_USE_BOTH);
            // append wallet balance to wallet object
            // since walle is an array and can only be found once in an iteration
            // $walletBalance returns an array with index0 as the initial found one
            $wallet->balance = $walletBalance[0]->amount ?? 0;
            return $wallet;
        }, $inWallets);

        Res::json($wallet_ref);
    }

    public function get()
    {
        Res::json(Balance::get_w_b(2, 'df-coin'));
    }

    public function wallets()
    {
        return Wallet::find();
    }
}
