<?php
// Autoloaders
require_once("../vendor/autoload.php");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$configuration = [
	'settings' => [
		'displayErrorDetails' => true ]
];
$c = new\Slim\Container($configuration);
$app = new \Slim\App($c);

/**
 * @apiGroup Commandes
 * @apiName toutesCommandes
 * @apiVersion 0.1.0
 *
 * @api {get} /commandes  accès à des ressources commandes
 *
 * @apiDescription Retourne un tableau contenant une représentation json de chaque commande.
 *
 * @apiParam {Number} limit Nombre d'éléments à afficher
 * @apiParam {Number} offset Pagination
 * @apiParam {Number} etat Filtrage sur l'état
 * @apiParam {String} date Filtrage sur la date de retrait (format yyyy-mm-dd)
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la commande
 * @apiSuccess (Succès : 200) {Date} dateretrait Date de retrait de la commande
 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande
 * @apiSuccess (Succès : 200) {String} token Token de la commande
 * @apiSuccess (Succès : 200) {String} montant Montant de la commande
 * @apiSuccess (Succès : 200) {Link} all Lien pour afficher toutes les commandes
 * @apiSuccess (Succès : 200) {Link} previous Lien pour afficher les commandes précédentes
 * @apiSuccess (Succès : 200) {Link} next Lien pour afficher les commandes suivantes
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *	{
 *		"commandes" :
 *		[
 *			{
 *				"id": 1,
 *				"dateretrait": "2017-01-04",
 *				"etat": 1,
 *				"token": 1546425,
 *				"montant": 0
 *			},
 *			{
 *				"id": 2,
 *				"dateretrait": "2017-01-24",
 *				"etat": 1,
 *				"token": "174086",
 *				"montant": 0
 *			}
 *		],
 *		"links" :
 *		{
 *	 		"all" : { "href" : "/commandes" },
 *			"previous" : { "href" : "/commandes?limit=20&offset=0" },
 *			"next" : { "href" : "/commandes?limit=20&offset=20" }
 *		}
 *	}
 *
 */
$app->get('/commandes',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrolprive($this))->toutesCommandes($req, $resp, $args);
	}
)->setName('toutesCommandes');

/**
 * @apiGroup Commandes
 * @apiName detailsCommande
 * @apiVersion 0.1.0
 *
 * @api {get} /commandes/id  retourne le détail d'une commande
 *
 * @apiDescription Retourne une représentation json de la commande et les liens pour visualiser la commande ou toutes les commandes.
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la commande
 * @apiSuccess (Succès : 200) {Date} dateretrait Date de retrait
 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande (1=créée, 2=payée, 3=en cours, 4=prête, 5=livrée)
 * @apiSuccess (Succès : 200) {String} token Token de la commande
 * @apiSuccess (Succès : 200) {Number} montant Montant de la commande
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *	{
 *		"commande": {
 *			"id": 2,
 *			"dateretrait": "2017-01-24",
 *			"etat": 1,
 *			"token": "174086",
 *			"montant": 0
 *		},
 *		"links": {
 *			"all": {
 *				"href": "/commandes"
 *			},
 *			"sandwichs": {
 *				"href": "/commandes/2/sandwich"
 *			}
 *		}
 *	}
 *
 * @apiError (Erreur : 404) RessourceNotFound Commande inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "ressource not found : http://localhost/lbsprive/api/commandes/10"
 *     }
 *
 */
$app->get('/commandes/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrolprive($this))->detailsCommande($req, $resp, $args);
	}
)->setName('detailsCommande');

/**
 * @apiGroup Commandes
 * @apiName changementEtat
 * @apiVersion 0.1.0
 *
 * @api {post} /commandes/id  change l'état d'une commande
 *
 * @apiDescription Retourne une représentation json de l'état de la commande et le lien pour visualiser la commande.
 *
 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande
 * @apiSuccess (Succès : 200) {Link} details Lien pour afficher les détails de la commande
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *	{
 *		"etat": { 2 },
 *		"links": {
 *			"details": {
 *				"href": "/commandes/2"
 *			}
 *		}
 *	}
 *
 * @apiError (Erreur : 404) error Commande inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "commande introuvable : http://localhost/lbsprive/api/commandes/10"
 *     }
 *
 * @apiError (Erreur : 400) error Etat incorrect
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *
 *     {
 *       "error" : "état incorrect: http://localhost/lbsprive/api/commandes/10"
 *     }
 *
 * @apiError (Erreur : 400) error Etat incorrect
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *
 *     {
 *       "error" : "on ne peut pas rétrograder l'état d'une commande: http://localhost/lbsprive/api/commandes/10"
 *     }
 */
$app->post('/commandes/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrolprive($this))->changementEtat($req, $resp, $args);
	}
)->setName('changementEtat');

$app->run();