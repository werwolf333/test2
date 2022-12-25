<?php

namespace Werwolf\Test2;

use Werwolf\Test2\Http\Controller;
use Werwolf\Test2\Http\Request;
use Werwolf\Test2\Http\Response;

class LogoutController extends Controller
{
    public function get(Request $request): Response
    {
        session_start();
        unset($_SESSION['user_login']);
        session_destroy();
        return $this->redirect('/login');
    }
}

