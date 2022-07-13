<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Paginator::useBootstrap();
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $menu = $event->menu;
            $menu->add(
                [
                    'text'  => 'แดชบอร์ด',
                    'url' => '/',
                    'icon'  => 'fas fa-fw fa-border-all',
                ],
                [
                    'text'  => 'รายการ',
                    'active' => ['program/*'],
                    'url' => '/program',
                    'icon'  => 'fas fa-fw fa-globe',
                ],/* 
                [
                    'text'  => 'ลีก',
                    'active' => ['league/*'],
                    'url' => '/league',
                    'icon'  => 'fas fa-fw fa-users',
                ], */
                [
                    'text' => 'ตารางการแข่ง',
                    'active' => ['schedule/*'],
                    'url' => '/schedule',
                    'icon' => 'fas fa-fw fa-stopwatch'
                ]
            );
            // $menu->add([
            //     'text'  => 'Site',
            //     'url' => '/site',
            //     'icon'  => 'fas fa-fw fa-sitemap',
            // ]);

            // $menu->add([
            //     'text'  => 'Channel',
            //     'url' => '/channel',
            //     'icon'  => "fas fa-fw fa-list-ul",
            // ]);
            // $menu->add([
            //     'text'  => 'Live',
            //     'url' => '/live',
            //     'icon'  => 'fas fa-fw fa-broadcast-tower',
            // ]);
        });
    }
}
