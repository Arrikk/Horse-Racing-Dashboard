<?php
namespace App\Helpers;
class Setting
{
    public static function App()
    {
        return (object) [
            'name' => "Horse Game Dashboard",
            'description' => "Crypto Wallet Management Application, Developed by Bruiz",
            'logo' => '/Public/images/favicon.png',
            'slug' => '',
            'keywords' => 'PHP, Bruiz, Dashboard, 8.0, Horse, Game, Application, Developer, Racing, Wallet',
            'author' => "Adeyemi Opeyemi",
            'title' => 'Horse Game Dashboard',
            'url' => '/'
        ];
    }
}