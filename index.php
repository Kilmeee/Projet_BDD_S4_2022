<?php

use gamepedia\db\Eloquent;
use Slim\{App, Container};
use Slim\Http\{Request, Response};
use gamepedia\controllers\APIController;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

#App et Container
$container = new Container();
$container['settings']['displayErrorDetails'] = true;
$app = new App($container);

#Redirection du traffic dans l'application
$app->group('/api', function ($app) {
    $app->group('/games', function ($app) {
        $app->get("/{id:[0-9]+}/characters[/]", function (Request $request, Response $response, array $args) {
            return (new APIController($this))->getGameCharacters($request, $response, $args);
        })->setName('gameCharacters');

        $app->any("/{id:[0-9]+}/comments[/]", function (Request $request, Response $response, array $args) {
            $c = new APIController($this);
            if ($request->isPost())
                return $c->postGameComment($request, $response, $args);
            else if ($request->isGet())
                return $c->getGameComment($request, $response, $args);
            else
                return $c->methodNotAllowed($request, $response, $args);
        })->setName('gameComments');

        $app->get("/{id:[0-9]+}[/]", function (Request $request, Response $response, array $args) {
            return (new APIController($this))->getGame($request, $response, $args);
        })->setName('game');

        $app->get("[/]", function (Request $request, Response $response, array $args) {
            return (new APIController($this))->getAllGames($request, $response, $args);
        })->setName('games');
    });
    $app->get("/characters/{id:[0-9]+}[/]", function (Request $request, Response $response, array $args) {
        return (new APIController($this))->characters($request, $response, $args);
    })->setName('characters');

    $app->get("/comments/{id:[0-9]+}[/]", function (Request $request, Response $response, array $args) {
        return (new APIController($this))->comments($request, $response, $args);
    })->setName('comment');
});

#Demmarage de l'application
try {
    $app->run();
} catch (Throwable $e) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error', true, 500);
    echo '<h1>Something went wrong!</h1>';
    print_r($e);
    exit;
}