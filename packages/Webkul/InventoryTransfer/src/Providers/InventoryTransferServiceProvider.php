<?php

namespace Webkul\InventoryTransfer\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class InventoryTransferServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/breadcrumbs.php');

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'inventory_transfer');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'inventory_transfer');

        Relation::morphMap([
            'inventory_transfers' => 'Webkul\InventoryTransfer\Models\InventoryTransfer',
        ]);

        $this->app->register(EventServiceProvider::class);

        $this->publishes([
            __DIR__.'/../../publishable/build' => public_path('inventory-transfer/build'),
            __DIR__.'/../Resources/views/components/attributes/view/date.blade.php' => resource_path('views/vendor/admin/components/attributes/view/date.blade.php'),
            __DIR__.'/../Resources/views/components/attributes/view/text.blade.php' => resource_path('views/vendor/admin/components/attributes/view/text.blade.php'),
        ], 'public');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/Config/acl.php', 'acl');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/menu.php', 'menu.admin');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/attribute_entity_types.php', 'attribute_entity_types');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/workflows.php', 'workflows.trigger_entities');
    }
}
