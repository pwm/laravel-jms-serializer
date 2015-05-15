<?php namespace Pwm\LaravelJMSSerializer;

use Illuminate\Support\Facades\Facade;

class LaravelJMSSerializerFacade extends Facade {

    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'serializer';
    }
} 