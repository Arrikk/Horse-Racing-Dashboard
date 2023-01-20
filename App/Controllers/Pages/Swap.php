<?php
namespace App\Controllers\Pages;

use App\Controllers\Auth\Authenticated;
use Core\View;

class Swap extends Authenticated
{
    public function index()
    {
        View::draw('swap/index');
    }
}