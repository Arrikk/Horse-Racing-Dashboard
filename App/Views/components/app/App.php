<?php

namespace App\Views\components\app;

use Core\Component;
use Core\Http\Res;
use Core\View;

class App extends Component
{
    // public function _html($title = '')
    // {
    //     View::component('app/html', ['title' => $title]);
    // }

    // public function _topbar()
    // {
    //     View::component('app/topbar');
    // }

    public function _body($body, $menu = null, $page = null, $other = null)
    {
        $page;
        $authority = $menu;
        echo '<div class="nk-content nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="nk-content-body">';
                        require_once $body;
        echo '      </div>
                </div>
            </div>';
    }

    public function _footer()
    {
        View::component('app/footer');
    }

    public function _script($script = '')
    {
        if (is_readable($script)) {
            require $script;
        }
    }
}
