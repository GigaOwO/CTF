<?php
namespace CtfApp\Controllers;

use public\src\Libs\Controllers\Controller;
use public\src\Libs\Https\Response;

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