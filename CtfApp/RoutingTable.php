<?php
namespace CtfApp;

use CtfApp\Controllers\CtfController;

class RoutingTable extends \Libs\Routing\RoutingTable
{
    protected array $urlPatterns = [
        ['str:name', 'GET', CtfController::class, 'index'],
        ['detail/int:id', 'GET', CtfController::class, 'detail'],
    ];
}