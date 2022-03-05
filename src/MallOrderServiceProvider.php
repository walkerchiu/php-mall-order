<?php

namespace WalkerChiu\MallOrder;

use Illuminate\Support\ServiceProvider;

class MallOrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
           __DIR__ .'/config/mall-order.php' => config_path('wk-mall-order.php'),
        ], 'config');

        // Publish migration files
        $from = __DIR__ .'/database/migrations/';
        $to   = database_path('migrations') .'/';
        $this->publishes([
            $from .'create_wk_mall_order_table.php'
                => $to .date('Y_m_d_His', time()) .'_create_wk_mall_order_table.php'
        ], 'migrations');

        $this->loadTranslationsFrom(__DIR__.'/translations', 'php-mall-order');
        $this->publishes([
            __DIR__.'/translations' => resource_path('lang/vendor/php-mall-order'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                config('wk-mall-order.command.cleaner')
            ]);
        }

        config('wk-core.class.mall-order.order')::observe(config('wk-core.class.mall-order.orderObserver'));
        config('wk-core.class.mall-order.review')::observe(config('wk-core.class.mall-order.reviewObserver'));
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    private function bladeDirectives()
    {
    }

    /**
     * Merges user's and package's configs.
     *
     * @return void
     */
    private function mergeConfig()
    {
        if (!config()->has('wk-mall-order')) {
            $this->mergeConfigFrom(
                __DIR__ .'/config/mall-order.php', 'wk-mall-order'
            );
        }

        $this->mergeConfigFrom(
            __DIR__ .'/config/mall-order.php', 'mall-order'
        );
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param String  $path
     * @param String  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        if (
            !(
                $this->app instanceof CachesConfiguration
                && $this->app->configurationIsCached()
            )
        ) {
            $config = $this->app->make('config');
            $content = $config->get($key, []);

            $config->set($key, array_merge(
                require $path, $content
            ));
        }
    }
}
