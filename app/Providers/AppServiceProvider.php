<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\NavigationHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ナビゲーションヘルパーをBladeで使用可能にする
        Blade::directive('isActive', function ($expression) {
            return "<?php echo App\Helpers\NavigationHelper::isActive($expression) ? 'active' : ''; ?>";
        });

        Blade::directive('isActivePattern', function ($expression) {
            return "<?php echo App\Helpers\NavigationHelper::isActivePattern($expression) ? 'active' : ''; ?>";
        });
    }
}
