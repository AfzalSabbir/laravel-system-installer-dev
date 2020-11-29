<?php

namespace AfzalSabbir\SystemInstaller;

use Illuminate\Support\Facades\Facade;

class SystemInstallerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'system-installer';
    }
}
