<?php
namespace Cohensive\Amp;

use Illuminate\Support\Facades\Facade;

class AmpRouteFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amprouter';
    }
}
