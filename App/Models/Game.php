<?php

namespace App\Models;

use Core\Http\Res;
use Core\Model\Model;

class Game extends Model
{

    public static function start(array $data)
    {
        extract((array) $data);
        $wallet = Balance::isSufficient($userID, $walletID, $amount);
        $walletBalance = ($wallet->amount - $amount);
        if ($wallet) :
            Balance::effect($userID, $walletID, $walletBalance);
            return Transaction::dump([
                'type' => 'debit',
                'description' => "Played Game with $amount Game Coins",
                'amount' => $amount,
                'balance_after' => $walletBalance,
                'user_id' => $userID,
                'wallet_id' => self::wallet($walletID)->wallet_symbol,
            ]);
        endif;
    }

    public static function finish(array $data)
    {
        $balance = new Balance;
        extract((array) $data);
        $wallet = $balance->get_w_b($userID, $walletID);
        $walletBalance =  ($wallet->amount ?? 0 + $amount);
        $balance->effect($userID, $walletID, $walletBalance);
        return Transaction::dump([
            'type' => 'credit',
            'description' => "Earned $walletBalance Game Coins",
            'amount' => $amount,
            'balance_after' => $walletBalance,
            'user_id' => $userID,
            'wallet_id' => self::wallet($walletID)->wallet_symbol,
        ]);
    }

    public static function wallet($walletID)
    {
        return Wallet::findOne(['wallet_id' => $walletID]);
    }
}
