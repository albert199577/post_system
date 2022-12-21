<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * A Facade do contract
 * @method static int increment (string $key, array $tags = null)
 */

class CounterFacades extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Contracts\CounterContract';
    }
}