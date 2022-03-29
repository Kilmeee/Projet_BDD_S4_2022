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

    /**
     * @api {get} /game/:id Request game information
     * @apiName GetGame
     * @apiGroup Game
     *
     * @apiParam {Number} id Game's unique ID.
     *
     * @apiSuccess {Object} links object containing links to other resources
     * @apiSuccess {Link} links.comments link to comments
     * @apiSuccess {Link} links.characters link to characters
     * @apiSuccess {Object} game object containing game's informations
     * @apiSuccess {Number} game.id id of the game
     * @apiSuccess {String} game.name name of the game
     * @apiSuccess {String} game.alias alias of the game
     * @apiSuccess {String} game.description description of the game
     * @apiSuccess {String} game.deck deck of the game
     * @apiSuccess {Date} game.original_release_date first release date of the game
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "links": {
     *          "comments": { "href": "/api/games/1/comments/" },
     *          "characters": { "href": "/api/games/1/characters/" }
     *      },
     *      "game": {
     *          "id": 1,
     *          "name": "Desert Strike: Return to the Gulf",
     *          "alias": "Desert Strike Advance",
     *          "deck": "A top-down isometric helicopter shoot 'em up originally for the Sega Genesis, which was later ported to a variety of platforms. It is best known for its open-ended mission design and was followed by several sequels.",
     *          "description": "<h2>Overview</h2><p style=\"\">Desert Strike: Return to the Gulf is an isometric helicopter shoot 'em up from Electronic Arts. The player is a fighter pilot who must take down mission-critical targets across a number of maps. The player is free to pursue these missions in any order, and must also keep an eye on the fuel, damage, and ammo gauges.</p><p style=\"\">Desert Strike is the first of the prolific <a href=\"/strike-series/3025-143\" data-ref-id=\"3025-143\">Strike</a> series, and was followed with <a href=\"/jungle-strike/3030-2180\" data-ref-id=\"3030-2180\">Jungle Strike</a> and <a href=\"/urban-strike/3030-9336\" data-ref-id=\"3030-9336\">Urban Strike</a> on the Genesis. Two more games, <a href=\"/soviet-strike/3030-2422\" data-ref-id=\"3030-2422\">Soviet Strike</a> and <a href=\"/nuclear-strike/3030-11731\" data-ref-id=\"3030-11731\">Nuclear Strike</a>, were released later for 32-bit systems.</p><h2>Story</h2><p style=\"\">A year after the Gulf War, General Ibn Kilbaba takes over a small <a href=\"/unnamed-middle-eastern-location/3035-179\" data-ref-id=\"3035-179\">Arab emirate</a> and plans to start World War III. Using an <a href=\"/ah-64-apache/3055-2463\" data-ref-id=\"3055-2463\">AH-64 Apache</a>, the player must open the way for ground troops and finally take on the \"Madman\" himself.</p><h2>Gameplay</h2><p style=\"\">The game is played from an isometric perspective in open levels that allow free movement in all directions by scrolling the screen with the movement of the helicopter. Each level consists of many varying objectives that range anywhere from destroying enemy bases and vehicles to capturing enemy troops or rescuing friendly ones. While bases and vehicles are simply destroyed, both friendly and enemy troops must be taken back to base for extraction. The AH-64 Apache has limited cargo space, so multiple trips to and from the base may be necessary. These objectives aren't always linear, and can often be tackled in whatever order the player chooses. This combination of free movement and non-linear structure separated Desert Strike from many of the other contemporary shooters.</p><p style=\"\">There are three weapons of varying strength and usefulness available to the AH-64 Apache: machine guns, hydra missiles, and hellfire missiles, which increase in strength respectively. Each of these weapons has a limited number of ammo which can only be replenished by picking up ammo crates on the mission or by resupplying back at the base. Similarly, the AH-64 Apache only has a limited amount of fuel that will drain slowly over the course of each level. If the fuel runs out, the helicopter crashes and the player loses a life. Refueling works exactly the same as restocking ammo.</p><p style=\"\">Lives are lost when either the AH-64 Apache takes too much damage and is destroyed, or when it runs out of fuel. After three lives have been lost, the game is over. Due to the nature of the game's freedom, each level requires a certain amount of planning and strategy in order to complete all of the objectives while still having enough fuel, ammo, and health to survive.</p><h2>Ports</h2><p style=\"\">Due to its popularity on the <a href=\"/sega-genesis/3055-4659\" data-ref-id=\"3055-4659\">Sega Genesis</a> in 1992, the game was then ported to the <a href=\"/amiga/3045-1\" data-ref-id=\"3045-1\">Amiga</a>, <a href=\"/sega-master-system/3045-8\" data-ref-id=\"3045-8\">Master System</a>, and <a href=\"/snes/3045-9\" data-ref-id=\"3045-9\">SNES</a> in the same year. Two years later in 1994, it was released on the <a href=\"/pc/3045-94\" data-ref-id=\"3045-94\">PC</a>. It was also ported to most handheld systems such as the <a href=\"/lynx/3045-7\" data-ref-id=\"3045-7\">Lynx</a> in 1993, <a href=\"/game-gear/3045-5\" data-ref-id=\"3045-5\">Game Gear</a> in 1994, <a href=\"/game-boy/3045-3\" data-ref-id=\"3045-3\">Game Boy</a> in 1995, <a href=\"/game-boy-advance/3045-4\" data-ref-id=\"3045-4\">Game Boy Advance</a> in 2002, and finally the <a href=\"/psp/3045-18\" data-ref-id=\"3045-18\">PSP</a> in 2006 as part of <a href=\"/ea-replay/3030-10965\" data-ref-id=\"3030-10965\">EA Replay</a>.</p>",
     *          "original_release_date": null
     *      }
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Game not found"
     *     }
     */
    public function getGame(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $game = Jeu::find($id, ["id", "name", "alias", "deck", "description", "original_release_date"]);
        if ($game) {
            return $response->withJson(array("links" => array(
                "comments" => array('href' => $this->container['router']->pathFor('gameComments', ['id' => $id])),
                "characters" => array('href' => $this->container['router']->pathFor('gameCharacters', ['id' => $id])),
            ), "game" => $game));
        } else {
            return $response->withStatus(404)->withJson(array("error" => "Game not found"));
        }
    }

    /**
     * @api {get} /games[/?page=p] Request all games informations
     * @apiName GetGames
     * @apiGroup Game
     *
     * @apiQuery {Number} [page=1] Page number, default is 1
     *
     * @apiSuccess {Object[]} games array containing all games informations
     * @apiSuccess {Object} games.game
     * @apiSuccess {Number} games.game.id id of the game
     * @apiSuccess {String} games.game.name name of the game
     * @apiSuccess {String} games.game.alias alias of the game
     * @apiSuccess {String} games.game.deck deck of the game
     * @apiSuccess {Object} games.links
     * @apiSuccess {Link} games.links.self link to the game, for detailled informations
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "games": [
     *          {
     *              "game": {
     *                  "id": 1,
     *                  "name": "Desert Strike: Return to the Gulf",
     *                  "alias": "Desert Strike Advance",
     *                  "deck": "A top-down isometric helicopter shoot 'em up originally for the Sega Genesis, which was later ported to a variety of platforms. It is best known for its open-ended mission design and was followed by several sequels."
     *              },
     *              "links": {
     *                  "self": { "href": "/api/games/1/" }
     *              }
     *           },
     *      ]
     *  }
     *
     * @apiSuccessExample {json} Success-Response: (With pagination)
     *  HTTP/1.1 200 OK
     *  {
     *      "links": {
     *          "prev": { "href": "/api/games/?page=3" },
     *          "next": { "href": "/api/games/?page=5" }
     *      },
     *      "games": [
     *          {
     *              "game": {
     *                  "id": 601,
     *                  "name": "Gauntlet II",
     *                  "alias": "Gauntlet 2",
     *                  "deck": "This 1986 sequel added more enemies with better AI, new treasures, harder levels, and the ability for each player to choose the character they wanted."
     *              },
     *              "links": {
     *                  "self": { "href": "/api/games/601/" }
     *              }
     *           },
     *      ]
     *  }
     */
    public function getAllGames(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($request->getQueryParam('page'), FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $paginator = Jeu::simplePaginate(200, ["id", "name", "alias", "deck"], "page", $id);
            $data = [];
            $data['links']['prev']['href'] = $this->container['router']->pathFor('games', queryParams: ['page' => substr($paginator->previousPageUrl(), strrpos($paginator->previousPageUrl(), '=') + 1)]);
            $data['links']['next']['href'] = $this->container['router']->pathFor('games', queryParams: ['page' => substr($paginator->nextPageUrl(), strrpos($paginator->nextPageUrl(), '=') + 1)]);
            $data['games'] = $paginator->getCollection()->transform(function ($value) use ($request) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $this->container['router']->pathFor('game', ['id' => $value->id])))
                );
            });
        } else {
            $data = array('games' => Jeu::select(["id", "name", "alias", "deck"])->limit(200)->get()->transform(function ($value) use ($request) {
                return array(
                    "game" => $value,
                    "links" => array('self' => array('href' => $this->container['router']->pathFor('game', ['id' => $value->id])))
                );
            }));
        }
        return $response->withJson($data);
    }

    /**
     * @api {get} /game/:id/comments[/] Request game comments
     * @apiName GetComments
     * @apiGroup Game
     *
     * @apiParam {Number} id Game's unique ID.
     *
     * @apiSuccess {Object[]} comments array of comments
     * @apiSuccess {Number} comments.id id of the comment
     * @apiSuccess {String} comments.titre title of the comment
     * @apiSuccess {String} comments.contenu content of the comment
     * @apiSuccess {Date} comments.date_creation date of the comment
     * @apiSuccess {String} comments.email_utilisateur email of the user who wrote the comment
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "comments": [
     *          {
     *              "id": 1175,
     *              "titre": null,
     *              "contenu": "Iste rem at ducimus earum.",
     *              "date_creation": null,
     *              "email_utilisateur": "Vallet.Thierry8@gmail.com"
     *          }
     *     ]
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Game not found"
     *     }
     *
     *
     */
    public function getGameComment(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($id))
            return $response->withStatus(404)->withJson(array("error" => "Game not found"));
        return $response->withJson(array('comments' => Jeu::find($id)->commentaires()->get(['id', 'titre', 'contenu', 'date_creation', 'email_utilisateur'])));
    }

    /** @api {post} /game/:id/comments[/] Send a comment
     * @apiName PostComment
     * @apiGroup Game
     *
     * @apiParam {Number} id Game's unique ID.
     *
     * @apiBody {String} titre title of the comment
     * @apiBody {String} contenu content of the comment
     * @apiBody {String} email email of the user who wrote the comment
     *
     * @apiSuccess {Number} id if of the comment
     * @apiSuccess {Number} id_game id of the game
     * @apiSuccess {String} titre title of the comment
     * @apiSuccess {String} contenu content of the comment
     * @apiSuccess {Date} date_creation date of the comment
     * @apiSuccess {String} email_utilisateur email of the user who wrote the comment
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 Created
     *  {
     *      "titre": "Super",
     *      "contenu": "J'adore ce jeu",
     *      "email_utilisateur": "aadam@albert.fr",
     *      "date_creation": "2022-03-29 19:19:43",
     *      "id_game": 20,
     *      "id": 40615
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *          "error": "Bad request, invalid email or missing parameters"
     *     }
     */
    public function postGameComment(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($id))
            return $response->withStatus(404)->withJson(array("error" => "Game not found"));
        $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
        $contenu = filter_var($request->getParsedBodyParam('contenu'), FILTER_SANITIZE_STRING);
        if ($titre && $contenu && filter_var($request->getParsedBodyParam('email'), FILTER_VALIDATE_EMAIL)) {
            try {
                $email = filter_var($request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
                $commentaire = Jeu::find($id)->commentaires()->create(['titre' => $titre, 'contenu' => $contenu, 'email_utilisateur' => $email, 'date_creation' => date('Y-m-d H:i:s')]);
                return $response->withStatus(201)->withHeader('Location', $this->container['router']->pathFor('comment', ['id' => $commentaire->id]))->withJson($commentaire);
            } catch (Exception) {
                return $response->withStatus(400)->withJson(array("error" => "Bad request, invalid email or missing parameters"));
            }
        } else {
            return $response->withStatus(400)->withJson(array("error" => "Bad request, invalid email or missing parameters"));
        }
    }

    /**
     * @api {get} /game/:id/characters[/] Request game characters
     * @apiName GetCharacters
     * @apiGroup Game
     *
     * @apiParam {Number} id Game's unique ID.
     *
     * @apiSuccess {Object[]} characters array of characters
     * @apiSuccess {Object} characters.character
     * @apiSuccess {String} characters.character.id id of the character
     * @apiSuccess {String} characters.character.name name of the character
     * @apiSuccess {Object} characters.link
     * @apiSuccess {Link} characters.link.self link to the character
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "characters": [
     *          {
     *              "character": {
     *                  "id": 11644,
     *                  "name": "Marion",
     *              },
     *              "links": {
     *                  "self": { "href": "/api/characters/11644/" }
     *              }
     *          }
     *     ]
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Game not found"
     *     }
     *
     *
     */
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
            return $response->withStatus(404)->withJson(array('error' => "Game not found"));
        }
    }

    /**
     * @api {get} /characters/:id Request character information
     * @apiName GetCharacter
     * @apiGroup Characters
     *
     * @apiParam {Number} id Character's unique ID.
     *
     * @apiSuccess {Number} id id of the character
     * @apiSuccess {String} name name of the character
     * @apiSuccess {String} real_name real name of the character
     * @apiSuccess {String} last_name last name of the character
     * @apiSuccess {String} alias alias of the character
     * @apiSuccess {Date} birthday birthday date of the character
     * @apiSuccess {Number} gender gender of the character (1 male, 2 female, 0 not defined, 3 other)
     * @apiSuccess {String} deck deck of the character
     * @apiSuccess {String} description description of the character
     * @apiSuccess {Number} first_appeared_in_game_id first game in which the character appeared
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "id": 11644,
     *      "name": "Marion",
     *      "real_name": null,
     *      "last_name": null,
     *      "alias": null,
     *      "birthday": null,
     *      "gender": 2,
     *      "deck": "A heroine candidate, Marion is an outgoing girl who's training to become a doctor and a witch. However, her treatments don't always go as planned\n\n\n",
     *      "description": null,
     *      "first_appeared_in_game_id": 36772,
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Character not found"
     *     }
     *
     *
     */
    public function characters(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $char = Personnage::find($id, ['id', 'name', 'real_name', 'last_name', 'alias', 'birthday', 'gender', 'deck', 'description', 'first_appeared_in_game_id']);
        if ($char) {
            return $response->withJson($char);
        } else {
            return $response->withStatus(404)->withJson(array('error' => "Character not found"));
        }
    }

    /**
     * @api {get} /comments/:id Request comment information
     * @apiName GetComment
     * @apiGroup Comments
     *
     * @apiParam {Number} id Comment's unique ID.
     *
     * @apiSuccess {Number} id id of the comment
     * @apiSuccess {String} titre title of the comment
     * @apiSuccess {String} contenu content of the comment
     * @apiSuccess {Date} date_creation date of creation of the comment
     * @apiSuccess {String} email_utilisateur email of the user who posted the comment
     * @apiSuccess {Number} id_game id of the game of the comment
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "id": 11644,
     *      "titre": null,
     *      "contenu": "Est quas omnis aut ut eos.",
     *      "date_creation": null,
     *      "email_utilisateur": "Le Gall8.Tristan1@gmail6.com",
     *      "id_game": 12544
     *  }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "Comment not found"
     *     }
     *
     *
     */
    public function comments(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $comment = Commentaire::find($id, ['id', 'titre', 'contenu', 'date_creation', 'email_utilisateur', 'id_game']);
        if ($comment) {
            return $response->withJson($comment);
        } else {
            return $response->withStatus(404)->withJson(array('error' => "Comment not found"));
        }
    }

    public function methodNotAllowed(Request $request, Response $response, array $args): Response
    {
        return $response->withStatus(405)->withJson(array("error" => "Method not allowed"));
    }
}