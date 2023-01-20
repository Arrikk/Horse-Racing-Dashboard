<?php

namespace App\Controllers\Api;

use App\Helpers\Auth;
use Core\Controller;
use Core\Http\Res;

class Login extends Controller
{
    public function metamask($data)
    {
        $token = Secure($data->token ?? '');
        $this->required(['token' => $token]);
        $login = Auth::loginWithMetamask($token);
        Res::json($login);
    }
}
