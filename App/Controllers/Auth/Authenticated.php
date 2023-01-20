<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Token;
use Core\Controller;
use Core\Http\Res;

/**
 * Authenticated Controller
 */

class Authenticated extends Controller
{
    public $user;

    protected function before()
    {
        parent::before();
        $header = apache_request_headers();
        if (isset($header['Authorization'])) :

            $token = explode(' ', $header['Authorization']);
            $token = $token[1];
            if ($token = Token::mkToken('dec', $token)) :
                $user = json_decode($token);
                if (time() > $user->expires) :
                    Res::status(400)->error(['token' => "Token Expired"]);
                endif;
            else :
                Res::status(400)->error(["token" => "Invalid Token"]);
            endif;
        else :
            Res::status(401)->error(["token" => "No Token"]);
        endif;


        if (isset($user->id)){
            $this->user = User::findOne(['id' => $user->id]);
            if(!$this->user) Res::status(404)->error([
                'message' => "User not found",
                'token' => $user
            ]);
        }
    }
}
