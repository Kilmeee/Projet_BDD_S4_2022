<?php

namespace gamepedia\controllers;

use gamepedia\models\{Jeu, Personnage};
use Slim\Http\{Request, Response};
use Slim\Container;
use Exception;

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

    public function comments(): Response
    {
        $id = filter_var($this->args['id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($id))
            return $this->response->withStatus(404, "Not found")->write("Game $id not found");
        switch ($this->request->getMethod()) {
            case 'GET':
                return $this->response->withJson(array('commentaire' => Jeu::find($id)->commentaires()->get(['id', 'titre', 'contenu', 'date_creation', 'email_utilisateur'])));
            case 'POST':
                $titre = filter_var($this->request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
                $contenu = filter_var($this->request->getParsedBodyParam('contenu'), FILTER_SANITIZE_STRING);
                if ($titre && $contenu && filter_var($this->request->getParsedBodyParam('email'), FILTER_VALIDATE_EMAIL)) {
                    try {
                        $email = filter_var($this->request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
                        $commentaire = Jeu::find($id)->commentaires()->create(['titre' => $titre, 'contenu' => $contenu, 'email_utilisateur' => $email, 'date_creation' => date('Y-m-d H:i:s')]);
                        return $this->response->withStatus(201, "Created")->withHeader('Location', $this->container['router']->pathFor('comments', ['id' => $commentaire->id]))->withJson($commentaire);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                        return $this->response->withStatus(400, "Bad request");
                    }
                } else {
                    return $this->response->withStatus(400, "Bad request");
                }
            default:
                return $this->response->withStatus(405, "Method not allowed");
        }
    }

    public function getGameCharacters(): Response
    {
        $id = filter_var($this->args['id'], FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $data = array('characters' => Jeu::find($id)->personnages()->get(['id', 'name'])->transform(function ($value) {
                return array(
                    "character" => array('id' => $value->id, 'name' => $value->name),
                    "links" => array('self' => array('href' => $this->container['router']->pathFor('characters', ['id' => $value->id])))
                );
            }));
        }
        return $this->response->withJson($data);
    }

    public function characters(): Response
    {
        $id = filter_var($this->args['id'], FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            return $this->response->withJson(Personnage::find($id));
        }
    }
}