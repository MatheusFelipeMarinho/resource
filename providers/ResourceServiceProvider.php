<?php

namespace Modules\resource\providers;

use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../command' => app_path('Console/Commands'),
        ], 'DomainGenerate');
    }
}
