<?php

namespace Modules\Resource\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Resource\Command\DomainGenerate;
use Modules\Resource\Command\GenerateAbstracts;

class ResourceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DomainGenerate::class,
                GenerateAbstracts::class
            ]);
        }
    }
}
