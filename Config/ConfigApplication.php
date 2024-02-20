<?php

namespace Config;

use public\src\Libs\Application;

class ConfigApplication extends  Application
{
    public function ready()
    {
        DirectorySettings::init();
    }
}