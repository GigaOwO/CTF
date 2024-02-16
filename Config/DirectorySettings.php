<?php
namespace Config;

class DirectorySettings
{
    public static string $APPLICATION_ROOT_DIR;
    public static string $TEMPLATES_ROOT_DIR;

    public static function init()
    {
        self::$APPLICATION_ROOT_DIR = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;
        self::$TEMPLATES_ROOT_DIR = self::$APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR;
    }
}