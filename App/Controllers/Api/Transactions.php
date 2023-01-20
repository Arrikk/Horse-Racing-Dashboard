<?php
namespace App\Controllers\Api;

use App\Controllers\Auth\Authenticated;
use App\Models\User;
use Core\Http\Res;

class Transactions extends Authenticated
{
    public function _load()
    {
        $transactions = $this->user->transactions();
        Res::json($transactions);
    }
}