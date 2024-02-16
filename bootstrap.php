<?php

require 'vendor/autoload.php';
require_once 'Config/ProjectSettings.php';


use Libs\Project;
use Config\ProjectSettings;

if (ProjectSettings::IS_DEBUG) {
    ini_set('display_errors', 1);
}

foreach (ProjectSettings::APPLICATIONS as $application) {
    $app = new $application();
    $app->ready();
}

$project = Project::instance();