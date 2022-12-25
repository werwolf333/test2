<?php

namespace Werwolf\Test2\Http;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    public function get(Request $request): Response
    {
        return new Response();
    }

    public function post(Request $request): Response
    {
        return new Response();
    }
    public function render(string $templateName, array $context=[]): Response
    {
        $loader = new FilesystemLoader(dirname(dirname(__DIR__)).'/templates');
        $twig = new Environment($loader, [
            'cache' => dirname(dirname(__DIR__)).'/var/cache/twig'
        ]);
        return new Response(200, $twig->render($templateName, $context));
    }

    public function redirect(string $location): Response
    {
        return new Response(302, '', [
            'Location'=> $location
        ]);
    }

    public function json($data): Response
    {
        return new Response(200, json_encode($data), [
            'Content-Type' => 'application/json'
        ]);
    }
}