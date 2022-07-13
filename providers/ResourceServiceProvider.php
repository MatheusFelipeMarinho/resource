<?php

namespace Modules\resource\providers;

use Illuminate\Support\ServiceProvider;
use Modules\resource\command\DomainGenerate;

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
