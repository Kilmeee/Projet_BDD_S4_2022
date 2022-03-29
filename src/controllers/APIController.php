<?php

namespace gamepedia\controllers;

use gamepedia\models\Jeu;
use Slim\Container;
use Slim\Http\{Request, Response};

class APIController
{

    private Container $container;
    private Request $request;
    private Response $response;
    private array $args;

    public function __construct(Container $c, Request $request, Response $response, array $args)
    {
        $this->container = $c;
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }

    public function getGame(): Response
    {
        $id = filter_var($this->args['id'], FILTER_SANITIZE_NUMBER_INT);
        $game = Jeu::find($id, ["id", "name", "alias", "deck", "description", "original_release_date"]);
        if ($game) {
            return $this->response->withJson(array("links" => array(
                "comments" => $this->container['router']->pathFor('gameComments', ['id' => $id]),
                "characters" => $this->container['router']->pathFor('gameCharacters', ['id' => $id]),
            ), "game" => $game));
        } else {
            return $this->response->withStatus(404, "Not found")->write("Game $id not found");
        }
    }

    public function getAllGames(): Response
    {
        $id = filter_var($this->request->getQueryParam('page'), FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $paginator = Jeu::simplePaginate(200, ["id", "name", "alias", "deck"], "page", $id);
            $data = [];
            $data['links']['prev']['href'] = $this->request->getUri()->getPath() . $paginator->previousPageUrl();
            $data['links']['next']['href'] = $this->request->getUri()->getPath() . $paginator->nextPageUrl();
            $data['games'] = $paginator->getCollection()->transform(function ($value) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $this->request->getUri()->getPath() . "/" . $value->id))
                );
            });
        } else {
            $data = array('games' => Jeu::select(["id", "name", "alias", "deck"])->limit(200)->get()->transform(function ($value) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $this->request->getUri()->getPath() . "/" . $value->id))
                );
            }));
        }
        return $this->response->withJson($data);
    }

    public function getComments(): Response
    {
        $id = filter_var($this->args['id'], FILTER_SANITIZE_NUMBER_INT);
        if($id) {
            return $this->response->withJson(array('commentaire' => Jeu::find($id)->commentaires()->get(['id', 'titre', 'contenu', 'date_creation', 'email_utilisateur'])));
        } else {
            return $this->response->withStatus(404, "Game $id not found");
        }
    }
}