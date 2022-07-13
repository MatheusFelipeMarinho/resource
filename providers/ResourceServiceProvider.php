<?php

namespace Modules\resource\providers;

use Modules\resource\command;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DomainGenerate::class,
            ]);
        }
    }
}
