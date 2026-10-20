<?php

namespace App\Providers;

use App\Repositories\Contracts\TripRepositoryInterface;
use App\Repositories\Eloquent\TripRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TripRepositoryInterface::class => TripRepository::class,
    ];
}
