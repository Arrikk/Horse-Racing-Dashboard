<?php

namespace App\Controllers\Pages;

use Core\Controller;
use Core\Http\Res;
use Core\View;

class Login extends Controller
{

    public function index()
    {
        View::page('auth/login.html', [
            'title' => 'Admin Login',
        ]);
    }


    public function _forgot()
    {
        // View::render('auth/forgot.html', ['title' => 'Forgot Password']);
    }
}
