<?php
session_start();
// Autoloaders
require_once("./vendor/autoload.php");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$configuration = [
	'settings' => [ 
		'displayErrorDetails' => true ,
		'tmpl_dir' => './templates'
	],
	'view' => function($c) {
		return new \Slim\Views\Twig(
			$c['settings']['tmpl_dir'],
			['debug' => true, 
				'cache' => $c['settings']['tmpl_dir']
			]
		);
	}
];
$c = new\Slim\Container($configuration);
$app = new \Slim\App($c);

$app->get('/',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->accueil($req, $resp, $args);
	}
)->setName('accueil');

$app->post('/connexion',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->connexion($req, $resp, $args);
	}
)->setName('connexion');

$app->get('/connexion',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->accueil($req, $resp, $args);
	}
)->setName('connexion');

$app->post('/ingredients',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->ingredients($req, $resp, $args);
	}
)->setName('connexion');

$app->get('/ingredients',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->accueil($req, $resp, $args);
	}
)->setName('connexion');

$app->post('/taille',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->taille($req, $resp, $args);
	}
)->setName('connexion');

$app->get('/taille',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\backendcontrol($this))->accueil($req, $resp, $args);
	}
)->setName('connexion');

$app->run();