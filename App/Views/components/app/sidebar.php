<?php

use App\Helpers\Menu;

$menus = Menu::myMenu();
?>

<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/dashboard" class="logo-link nk-sidebar-logo">
                <!-- <img class="logo-light logo-img" src="/Public/images/logo.png" srcset="/Public/images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="/Public/images/logo-dark.png" srcset="/Public/images/logo-dark2x.png 2x" alt="logo-dark"> -->
                <!-- <span class="nio-version">Coinrimp</span> -->
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-widget d-none d-xl-block">
                    <!-- <div class="user-account-info between-center">
                        <div class="user-account-main">
                            <h6 class="overline-title-alt">Available Balance</h6>
                            <div class="user-balance">2.014095 <small class="currency currency-btc">BTC</small></div>
                            <div class="user-balance-alt">18,934.84 <span class="currency currency-btc">BTC</span></div>
                        </div>
                        <a href="#" class="btn btn-white btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a>
                    </div> -->
                </div>
                <div class="nk-sidebar-menu">
                    <!-- Menu -->
                    <ul class="nk-menu">
                        <li class="nk-menu-heading">
                            <h6 class="overline-title">Menu</h6>
                        </li>
                        <?php foreach ($menus as $menu => $value) : ?>
                            <li class="nk-menu-item">
                                <a href="<?= $value['link'] ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="<?= $value['icon'] ?>"></em></span>
                                    <span class="nk-menu-text"><?= $menu ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul><!-- .nk-menu -->
                </div>
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
