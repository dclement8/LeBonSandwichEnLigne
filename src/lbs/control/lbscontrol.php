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

	public function suppCommande(Request $req, Response $resp, $args)
	{

		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		if($req = \lbs\model\commande::where('id', $id)->get()->toJson() !="[]"){

			foreach($req as $q) {
				if($q->etat == 1) {
					\lbs\model\commande::destroy($id);
					return (new \lbs\view\lbsview("200"))->render('suppCommande', $req, $resp);
				} else {
					return (new \lbs\view\lbsview("403"))->render('suppCommande', $req, $resp);				
				}
			}
		} else {
			return (new \lbs\view\lbsview("404"))->render('suppCommande', $req, $resp);
		}
	


		
	}
	
}