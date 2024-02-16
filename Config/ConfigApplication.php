<?php

namespace Config;

use Libs\Application;
use Config\DirectorySettings;

class ConfigApplication extends  Application
{
    public function ready()
    {
        DirectorySettings::init();
    }
}