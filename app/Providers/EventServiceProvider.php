<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'IdeaRobin\Events\SomeEvent' => [
            'IdeaRobin\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
