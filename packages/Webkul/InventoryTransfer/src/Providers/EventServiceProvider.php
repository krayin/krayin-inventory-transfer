<?php

namespace Webkul\InventoryTransfer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'activity.create.after' => [
            'Webkul\InventoryTransfer\Listeners\Activity@afterUpdateOrCreate',
        ],

        'activity.update.after' => [
            'Webkul\InventoryTransfer\Listeners\Activity@afterUpdateOrCreate',
        ],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('admin.layout.head.before', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('inventory_transfer::layouts.style');
        });
    }
}
