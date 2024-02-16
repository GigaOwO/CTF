<?php
namespace CtfApp\Controllers;

use Libs\Controllers\Controller;
use Libs\Https\Response;

class CtfController extends Controller
{
    public function index(array $params): Response
    {
        $data = ['name' => $params['name']];
        return $this->render('ctf/index', $data);
    }

    public function detail(array $params): Response
    {
        $data = ['id' => $params['id'], 'title' => 'Detail', 'status' => 'OK'];
        return $this->render('ctf/detail', $data);
    }
}