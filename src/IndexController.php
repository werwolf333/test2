<?php

namespace Werwolf\Test2;

use Werwolf\Test2\Http\Controller;
use Werwolf\Test2\Http\Request;
use Werwolf\Test2\Http\Response;

class IndexController extends Controller
{
    public function get(Request $request): Response
    {
        session_start();
        if (empty($_SESSION['user_login'])) {
            $args = ['key' => ''];
        } else {
            $args = ['key' => $_SESSION['user_login']];
        }
        return $this->render('index.html.twig', $args);
    }
}
