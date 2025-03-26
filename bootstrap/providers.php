<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    NotificationChannels\WebPush\WebPushServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\TenancyServiceProvider::class,
];
