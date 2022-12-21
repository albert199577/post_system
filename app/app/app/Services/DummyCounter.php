<?php

namespace App\Services;

use App\Contracts\CounterContract;

class DummyCounter implements CounterContract
{
    public function __construct()
    {

    }

    public function increment(string $key, array $tags = null): int
    {
        dd('dddddd');
        return 0;
    }
}