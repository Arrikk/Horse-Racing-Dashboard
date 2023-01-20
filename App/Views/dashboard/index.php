<?php

use Core\Component;
use Core\View;

Component::render(
    // View::component('dashboard/msg'),
    View::component('dashboard/head'),
    View::component('dashboard/overview'),
    View::component('dashboard/recent'),
);