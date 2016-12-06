<?php
namespace lbs\control;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \lbs\AppInit;

// Connexion à la BDD
$connexion = new AppInit();
$connexion->bootEloquent("../conf/config.ini");

class lbscontrol
{
    protected $c=null; 
    
    public function __construct($c)
	{
        $this->c = $c;
    }
	
	
    public function detailsCategorie(Request $req, Response $resp, $args)
	{
		$id = $args['id'];
		$json = \lbs\model\categorie::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json, $req, $resp, $args))->render('detailsCategorie', $resp);
    }
}