<?php
namespace CtfApp\Controllers;

use Libs\Controllers\Controller;
use Libs\Https\Response;

class CtfController extends Controller
{
    public function index(array $params): Response
    {
        return $this->render('ctf/index');
    }

    public function detail(array $params): Response
    {
        $data = ['title' => 'Detail', 'status' => 'OK'];
        return $this->render('ctf/detail', $data);
    }
}