<?php

namespace Ikbal\WisePayment\Facades;

use Illuminate\Support\Facades\Facade;

class Wise extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wise';
    }
}