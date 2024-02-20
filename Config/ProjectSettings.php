<?php
namespace Config;

class ProjectSettings
{
    public const IS_DEBUG = true;
    public const APPLICATIONS = [
        'Config\ConfigApplication',
        'CtfApp\CtfApplication'
    ];

    public const ROUTING_TABLE_CLASSES = [
        ['/^\/?ctf(\/|)/','CtfApp\RoutingTable']
    ];

    public const NOT_FOUND_CONTROLLER = 'public\src\Libs\Controllers\NotFoundController';
}