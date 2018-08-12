<?php
use cnuer\Auth\Cnu\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\ConfigureLocales;

return function (Dispatcher $events) {
    $events->subscribe(Listener\AddClientAssets::class);
    $events->subscribe(Listener\AddCnuAuthRoute::class);
    $events->subscribe(Listener\AddCnuUserGroup::class);
    $events->listen(ConfigureLocales::class, function (ConfigureLocales $event) {
        $event->loadLanguagePackFrom(__DIR__);
    });
};