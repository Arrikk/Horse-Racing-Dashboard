<?php

use Core\Router\Router as Route;

Route::get('', 'login@index@pages');
Route::get('dashboard', 'dashboard@index@pages');
Route::get('buy-game-points', 'swap@index@pages');


Route::post('api/connect', 'login@metamask@api');
Route::get('api/wallets', 'wallets@load@api');
Route::get('wallets', 'wallets@get@api');
Route::get('api/transactions', 'transactions@load@api');
Route::get('api/game/{type:[\w]+}', 'games@start@api');