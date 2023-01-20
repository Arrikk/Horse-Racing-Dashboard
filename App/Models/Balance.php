<?php
namespace App\Models;

use Core\Http\Res;
use Core\Model\Model;

class Balance extends Model
{
    public static function get_w_b($userID, $walletID)
    {
        if(!Wallet::findOne(['wallet_id' => $walletID])) return Res::status(400)->error([
            'message' => "Invalid Wallet ID",
            'walletID' => $walletID
        ]);

        $wallet = self::findOne([
            '$.left' => 'wallets AS w',
            '$.on' => 'balances.wallet_id = w.wallet_id',
            'user_id' => $userID,
            '$.and' => "balances.wallet_id = '$walletID'"
        ]);

        return $wallet;

    }

    public static function isSufficient($userID, $walletID, $amount)
    {
        $wallet = self::get($userID, $walletID) ;
        $walletBalance = $wallet->amount ?? 0;

        if($walletBalance < $amount || $walletBalance < 0) Res::status(400)::error([
            'message' => "Insufficient Balance",
            'balance' => $walletBalance,
            'amount' => $amount
        ]); 

        return $wallet;
    }

    public static function effect($userID, $walletID, $amount)
    {
        $wallet = self::get_w_b($userID, $walletID);

        if($wallet)return self::findAndUpdate([
            'user_id' => $userID,
            'and.wallet_id' => $walletID,
        ], ['amount' => $amount, 'updated_at' => CURRENT_DATE]);

        return self::dump([
            'wallet_id' => $walletID,
            'user_id' => $userID,
            'amount' => $amount,
        ]);
    }


}