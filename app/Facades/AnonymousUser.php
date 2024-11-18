<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AnonymousUser extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return static::class;
    }
}
