<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ViewServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    OwenIt\Auditing\AuditingServiceProvider::class,
    SocialiteProviders\Manager\ServiceProvider::class,
];
