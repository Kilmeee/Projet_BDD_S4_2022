<?php

namespace gamepedia\controllers;

use Slim\Container;
use Slim\Http\{Request, Response};

class APIController
{

    private Container $container;
    private Request $request;
    private Response $response;

    public function __construct(Container $c, Request $request, Response $response, array $args)
    {
        $this->container = $c;
        $this->request = $request;
        $this->response = $response;
    }

    

}