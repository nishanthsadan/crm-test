<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Core\Providers\CoreServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Dashboard\Providers\DashboardServiceProvider::class,
    Modules\Leads\Providers\LeadsServiceProvider::class,
    Modules\Contacts\Providers\ContactsServiceProvider::class,
    Modules\Accounts\Providers\AccountsServiceProvider::class,
    Modules\Deals\Providers\DealsServiceProvider::class,
    Modules\Activities\Providers\ActivitiesServiceProvider::class,
    Modules\Reports\Providers\ReportsServiceProvider::class,
    Modules\Settings\Providers\SettingsServiceProvider::class,
];
