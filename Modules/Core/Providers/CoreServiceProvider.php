<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/config.php', 'core');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        // Register blade directives
        Blade::directive('moduleEnabled', function ($module) {
            return "<?php if(module_enabled($module)): ?>";
        });

        Blade::directive('endModuleEnabled', function () {
            return "<?php endif; ?>";
        });
    }
}
