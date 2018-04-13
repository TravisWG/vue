<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use Request;
use Hacksaw\Cart\Cart;
use Auth;
use Hacksaw\Message\Models\EmergencyMessage;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        View::composer('partials.template', \App\Http\ViewComposers\TemplateComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
