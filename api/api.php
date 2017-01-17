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
 * @apiGroup Categories
 * @apiName detailsCategorie
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id  accès à une ressource catégorie
 *
 * @apiDescription Accès à une ressource de type catégorie permet d'accéder à la représentation de la ressource categorie désignée. Retourne une représentation json de la ressource.
 *
 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.
 *
 * @apiParam {Number} id Identifiant de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 * @apiSuccess (Succès : 200) {Link} all Lien vers la de toutes les catégories
 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *            "id"  : 4 ,
 *            "nom" : "crudités",
 *            "description" : "nos salades et crudités fraiches et bio."
 *        },
 *        links : {
 *            "all" : { "href" : "/categories" },
 *            "ingredients" : { "href" : "/categories/4/ingredients" }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) error Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "ressource not found"
 *     }
 */
$app->get('/categories/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->detailsCategorie($req, $resp, $args);
	}
)->setName('detailsCategorie');

/**
 * @apiGroup Categories
 * @apiName toutesCategories
 * @apiVersion 0.1.0
 *
 * @api {get} /categories  accès à toutes les ressources catégories
 *
 * @apiDescription Accès à toutes les ressources de type catégorie. Retourne une représentation json.
 *
 *
  * @apiSuccess (Succès : 200) {Array} categories Toutes les catégories
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        "categories" : [
 *			{
 *            	"id"  : 4 ,
 *            	"nom" : "crudités",
 *            	"description" : "nos salades et crudités fraiches et bio."
 *			},
 *			{
 *				"id"  : 5 ,
 *            	"nom" : "Sauces",
 *            	"description" : "Toutes les sauces du monde !"
 *			}
 *        ]
 *     }
 */
$app->get('/categories',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->toutesCategories($req, $resp, $args);
	}
)->setName('toutesCategories');

/**
 * @apiGroup Ingredients
 * @apiName detailsIngredient
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id  accès à une ressource ingrédient
 *
 * @apiDescription Accès à une ressource de type ingrédient permet d'accéder à la représentation de la ressource ingrédient désignée. Retourne une représentation json de la ressource.
 *
 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.
 *
 * @apiParam {Number} id Identifiant de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 * @apiSuccess (Succès : 200) {Link} all Lien vers la de toutes les catégories
 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *            "id"  : 4 ,
 *            "nom" : "crudités",
 *            "description" : "nos salades et crudités fraiches et bio."
 *        },
 *        links : {
 *            "all" : { "href" : "/categories" },
 *            "ingredients" : { "href" : "/categories/4/ingredients" }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) error Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "ressource not found"
 *     }
 */
$app->get('/ingredients/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->detailsIngredient($req, $resp, $args);
	}
)->setName('detailsIngredient');

/**
 * @apiGroup Categories
 * @apiName detailsIngredient
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id  accès à une ressource ingrédient
 *
 * @apiDescription Accès à une ressource de type ingrédient permet d'accéder à la représentation de la ressource ingrédient désignée. Retourne une représentation json de la ressource.
 *
 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.
 *
 * @apiParam {Number} id Identifiant de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 * @apiSuccess (Succès : 200) {Link} all Lien vers la liste de toutes les catégories
 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *            "id"  : 4 ,
 *            "nom" : "crudités",
 *            "description" : "nos salades et crudités fraiches et bio."
 *        },
 *        links : {
 *            "all" : { "href" : "/categories" },
 *            "ingredients" : { "href" : "/categories/4/ingredients" }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) error Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "ressource not found"
 *     }
 */
$app->get('/categories/{id}/ingredients',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->ingredientsCategorie($req, $resp, $args);
	}
)->setName('ingredientsCategorie');

/**
 * @apiGroup Ingredients
 * @apiName categorieIngredient
 * @apiVersion 0.1.0
 *
 * @api {get} /ingredients/id/categorie  accès à une ressource catégorie d'un ingrédient
 *
 * @apiDescription Accès à une ressource de type catégorie d'un ingrédient particulier. Retourne une représentation json de la ressource.
 *
 * Le résultat inclut un lien pour accéder aux détails de l'ingrédient
 *
 * @apiParam {Number} id Identifiant de l'ingredient
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 * @apiSuccess (Succès : 200) {Link} details Lien vers les détails de l'ingrédient
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *			[
 *            "id"  : 1 ,
 *            "nom" : "salades",
 *            "description" : "Nos bonnes salades, fraichement livr\u00e9es par nos producteurs bios et locaux"
 *			]
 *        },
 *        links : {
 *            "details" : { "href" : "/ingredients/3" }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) error Ingrédient inexistant
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "ressource not found"
 *     }
 */
$app->get('/ingredients/{id}/categorie',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->categorieIngredient($req, $resp, $args);
	}
)->setName('categorieIngredient');

/**
 * @apiGroup Commandes
 * @apiName creerCommande
 * @apiVersion 0.1.0
 *
 * @api {post} /commandes  créer une ressource commande
 *
 * @apiDescription Créer une ressource commande. Retourne un token servant à identifier l'utilisateur ayant créé la commande ainsi que l'identifiant de la commande.
 *
 * Le résultat inclut un lien pour accéder aux détails de la commande créee
 *
 * @apiParam {String} json JSON des données servant à la création de la commande (Exemple : { "dateretrait" : "2000-01-01" , "montant" : 10 })
 *
 *
 * @apiSuccess (Succès : 201) {String} token Token d'identification de l'utilisateur ayant créé la commande
 * @apiSuccess (Succès : 201) {Number} id Identifiant de la commande
 * @apiSuccess (Succès : 201) {Link} view Lien vers les détails de la commande qui a été créee
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        commande : {
 *            "token"  : "xal0810z9u6dz7xowtkyt5yl1p3sfny3" ,
 *            "id" : 1
 *        },
 *        links : {
 *            "view" : { "href" : "/commandes/1" }
 *        }
 *     }
 *
 * @apiError (Erreur : 400) error Données manquantes ou incorrectes pour créer la commande.
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 400 Bad Request
 *
 *     {
 *       "error" : "données manquantes ou incorrectes pour la création de la commande : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes"
 *     }
 */
$app->post('/commandes',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->creerCommande($req, $resp, $args);
	}
)->setName('creerCommande');

$app->post('/commandes/{id}/sandwichs',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->ajouterSandwich($req, $resp, $args);
	}
)->setName('ajouterSandwich');

$app->post('/commandes/{id}/{date}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->dateCommande($req, $resp, $args);
	}
)->setName('dateCommande');

$app->get('/commandes/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->etatCommande($req, $resp, $args);
	}
)->setName('etatCommande');

$app->post('/commandes/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->payerCommande($req, $resp, $args);
	}
)->setName('payerCommande');

$app->delete('/sandwichs/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->supprimerSandwich($req, $resp, $args);
	}
)->setName('supprimerSandwich');

$app->post('/sandwichs/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->modifierSandwich($req, $resp, $args);
	}
)->setName('modifierSandwich');

$app->run();
