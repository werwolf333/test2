<?php

namespace Werwolf\Test2;

use LDAP\Result;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Werwolf\Test2\Http\Request;

class App
{
    public function run(): void{
        //echo $_SERVER['REQUEST_URI'];
        $request = Request::fromGlobals();
        $router = new Router;
        $response = $router->route($request);
        foreach($response->getHeaders() as $headerName => $header){
            header($headerName.': '.$header);
        }
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }
}
