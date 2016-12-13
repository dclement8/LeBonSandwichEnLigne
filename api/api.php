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

$app->get('/commande/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->etatCommande($req, $resp, $args);
	}
)->setName('etatCommande');

$app->run();
