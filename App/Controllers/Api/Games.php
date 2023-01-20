<?php
namespace App\Controllers\Api;

use App\Controllers\Auth\Authenticated;
use App\Models\Game;
use App\Models\User;
use Core\Http\Res;

class Games extends Authenticated
{
    private $types = ['start', 'finish'];
    private $defaultPoint = 2;

    public function _start($data)
    {
        $type = $this->route_params['type'];
        $point = $this->validType($type, $data);

        $user = $this->user;
        $game = Game::$type([
            'userID' => $user->id,
            'walletID' => 'df-coin',
            'amount' => $point == null ? $this->defaultPoint : $point
        ]);
        Res::json($game);
    }

    public function validType($type, $data)
    {
        if(!in_array($type, $this->types))
        Res::status(400)::error([
            'message' => "Invalid Type",
            'game_types' => $this->types,
            'type' => $type
        ]);

        if($type == 'finish'):
            $point = $data->game_point ?? '';
            $this->requires([
                'game_point' => $point." || amount"
            ]);
            return $point;
        endif;
    }
}