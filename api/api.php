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
)->setName('afficherCategorie');

$app->run();