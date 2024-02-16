<?php
namespace Libs\Controllers;

use Libs\Https\Response;
use Libs\Https\Status;

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