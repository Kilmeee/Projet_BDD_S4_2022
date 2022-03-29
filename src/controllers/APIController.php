<?php

namespace gamepedia\controllers;

use gamepedia\models\{Commentaire, Jeu, Personnage};
use Slim\Http\{Request, Response};
use Slim\Container;
use Exception;

class APIController
{

    private Container $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    public function getGame(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $game = Jeu::find($id, ["id", "name", "alias", "deck", "description", "original_release_date"]);
        if ($game) {
            return $response->withJson(array("links" => array(
                "comments" => $this->container['router']->pathFor('gameComments', ['id' => $id]),
                "characters" => $this->container['router']->pathFor('gameCharacters', ['id' => $id]),
            ), "game" => $game));
        } else {
            return $response->withStatus(404, "Not found")->withJson(array("error" => "Game not found"));
        }
    }

    public function getAllGames(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($request->getQueryParam('page'), FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $paginator = Jeu::simplePaginate(200, ["id", "name", "alias", "deck"], "page", $id);
            $data = [];
            $data['links']['prev']['href'] = $request->getUri()->getPath() . $paginator->previousPageUrl();
            $data['links']['next']['href'] = $request->getUri()->getPath() . $paginator->nextPageUrl();
            $data['games'] = $paginator->getCollection()->transform(function ($value) use ($request) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $request->getUri()->getPath() . "/" . $value->id))
                );
            });
        } else {
            $data = array('games' => Jeu::select(["id", "name", "alias", "deck"])->limit(200)->get()->transform(function ($value) use ($request) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $request->getUri()->getPath() . "/" . $value->id))
                );
            }));
        }
        return $response->withJson($data);
    }

    public function comments(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($id))
            return $response->withStatus(404, "Not found")->withJson(array("error" => "Game not found"));
        switch ($request->getMethod()) {
            case 'GET':
                return $response->withJson(array('commentaire' => Jeu::find($id)->commentaires()->get(['id', 'titre', 'contenu', 'date_creation', 'email_utilisateur'])));
            case 'POST':
                $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
                $contenu = filter_var($request->getParsedBodyParam('contenu'), FILTER_SANITIZE_STRING);
                if ($titre && $contenu && filter_var($request->getParsedBodyParam('email'), FILTER_VALIDATE_EMAIL)) {
                    try {
                        $email = filter_var($request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
                        $commentaire = Jeu::find($id)->commentaires()->create(['titre' => $titre, 'contenu' => $contenu, 'email_utilisateur' => $email, 'date_creation' => date('Y-m-d H:i:s')]);
                        return $response->withStatus(201, "Created")->withHeader('Location', $this->container['router']->pathFor('comments', ['id' => $commentaire->id]))->withJson($commentaire);
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                        return $response->withStatus(400, "Bad request");
                    }
                } else {
                    return $response->withStatus(400, "Bad request");
                }
            default:
                return $response->withStatus(405, "Method not allowed");
        }
    }

    public function getGameCharacters(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $game = Jeu::find($id);
        if ($game) {
            $data = array('characters' => $game->personnages()->get(['id', 'name'])->transform(function ($value) {
                return array(
                    "character" => array('id' => $value->id, 'name' => $value->name),
                    "links" => array('self' => array('href' => $this->container['router']->pathFor('characters', ['id' => $value->id])))
                );
            }));
            return $response->withJson($data);
        } else {
            return $response->withStatus(404, "Not found")->withJson(array('error' => "Game $id not found"));
        }
    }

    public function characters(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $char = Personnage::find($id);
        if ($char) {
            return $response->withJson($char);
        } else {
            return $response->withStatus(404)->withJson(array('error' => "Character $id not found"));
        }
    }

    public function comment(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $comment = Commentaire::find($id);
        if ($comment) {
            return $response->withJson($comment);
        } else {
            return $response->withStatus(404)->withJson(array('error' => "Comment $id not found"));
        }
    }
}