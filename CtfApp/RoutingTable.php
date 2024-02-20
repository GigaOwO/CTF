<?php
namespace CtfApp;

use CtfApp\Controllers\CtfController;

class RoutingTable extends \Libs\Routing\RoutingTable
{
    protected array $urlPatterns = [
        ['', 'GET', CtfController::class, 'index'],
        ['detail', 'GET', CtfController::class, 'detail'],
    ];
}