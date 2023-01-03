<?php

namespace Werwolf\Test2;

use Werwolf\Test2\Http\Request;
use Werwolf\Test2\Http\Response;

class Router
{
    public function route(Request $request): Response
    {
        if ($request->getUri() == '/registration') {
            $controller = new RegistrationController();
        } elseif ($request->getUri() == '/login') {
            $controller = new LoginController();
        } elseif ($request->getUri() == '/') {
            $controller = new IndexController();
        } elseif ($request->getUri() == '/logout') {
            $controller = new LogoutController();
        } else {
            $response = new Response(404, 'мимо :)');
            return $response;
        }
        if ($request->getMethod() == 'POST') {
            $response = $controller->post($request);
        } else {
            $response = $controller->get($request);
        }
        return $response;
    }
}
