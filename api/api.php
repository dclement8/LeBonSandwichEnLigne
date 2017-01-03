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
 * @apiSuccess (Succès : 200) {Link}   links-ingredients lien vers la liste d'ingrédients de la catégorie
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
 *            "ingredients" : { "href" : "/categories/4/ingredients }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) CategorieNotFound Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "Catégorie inexistante"
 *     }
 */
$app->get('/categories/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->detailsCategorie($req, $resp, $args);
	}
)->setName('detailsCategorie');

$app->get('/categories',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->toutesCategories($req, $resp, $args);
	}
)->setName('toutesCategories');

$app->get('/ingredients/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->detailsIngredient($req, $resp, $args);
	}
)->setName('detailsIngredient');

$app->get('/categories/{id}/ingredients',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->ingredientsCategorie($req, $resp, $args);
	}
)->setName('ingredientsCategorie');

$app->get('/ingredients/{id}/categorie',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->categorieIngredient($req, $resp, $args);
	}
)->setName('categorieIngredient');

$app->post('/commandes',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->creerCommande($req, $resp, $args);
	}
)->setName('creerCommande');

$app->post('/commandes/{token}/sandwich/{id2}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->ajouterSandwich($req, $resp, $args);
	}
)->setName('ajouterSandwich');

$app->post('/commande/{id}/{date}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->dateCommande($req, $resp, $args);
	}
)->setName('dateCommande');

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
