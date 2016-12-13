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
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\categorie::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('detailsCategorie', $req, $resp);
    }

	public function toutesCategories(Request $req, Response $resp, $args)
	{
		$json = \lbs\model\categorie::get()->toJson();
		return (new \lbs\view\lbsview($json))->render('toutesCategories', $req, $resp);
    }

	public function detailsIngredient(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\ingredient::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('detailsIngredient', $req, $resp);
    }

	public function ingredientsCategorie(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\ingredient::where('cat_id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('ingredientsCategorie', $req, $resp);
    }

	public function categorieIngredient(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = "[]";
		if(\lbs\model\ingredient::where('id', $id)->get()->toJson() != "[]")
		{
			$json = \lbs\model\ingredient::find($id)->categorieIngredient()->get()->toJson();
		}
		return (new \lbs\view\lbsview($json))->render('categorieIngredient', $req, $resp);
    }

	public function creerCommande(Request $req, Response $resp, $args)
	{

		return (new \lbs\view\lbsview($json))->render('creerCommande', $req, $resp);
    }

	public function etatCommande(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\commande::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('etatCommande', $req, $resp);
    }

	public function dateCommande(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$date = date_parse($args['date']);

		$commande = \lbs\model\commande::find($id);
		if($commande === false)
			return (new \lbs\view\lbsview('[]'))->render('dateCommande', $req, $resp);
		if($date === false)
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);
		if(!checkdate($date['month'], $date['day'], $date['year']))
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);
		if(mktime(0, 0, 0, $date['month'], $date['day'], $date['year']) < time())
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);

		$commande->dateretrait = $date['year'].'-'.$date['month'].'-'.$date['day'];
		if($commande->save()) {
			$json = $commande->toJson();
			return (new \lbs\view\lbsview($json))->render('dateCommande', $req, $resp);
		}
    }
}
