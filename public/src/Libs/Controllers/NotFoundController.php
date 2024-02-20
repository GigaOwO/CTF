<?php
namespace public\src\Libs\Controllers;

use public\src\Libs\Https\Response;
use public\src\Libs\Https\Status;

class NotFoundController extends Controller
{
    public function __construct(
        private string $message = 'Page not found.'
    ) {
        parent::__construct();
    }

    public function index($params)
    {
        return new Response($this->message, Status::HTTP_404_NOT_FOUND);
    }
}