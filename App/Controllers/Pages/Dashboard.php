<?php
namespace App\Controllers\Pages;

use App\Controllers\Auth\Authenticated;
use Core\View;

class Dashboard extends Authenticated
{
    public function index()
    {
        View::draw('dashboard/index');
    }
}