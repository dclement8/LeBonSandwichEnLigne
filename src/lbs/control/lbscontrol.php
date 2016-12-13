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
		$obj = json_decode($_POST["json"]);
		
		$commande = new \lbs\model\commande();
		
		if(isset($obj->dateretrait) && isset($obj->montant))
		{
			$commande->dateretrait = filter_var($obj->dateretrait, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$commande->etat = 1;
			$commande->montant = filter_var($obj->montant, FILTER_SANITIZE_NUMBER_FLOAT);;
			
			$factory = new \RandomLib\Factory;
			$generator = $factory->getGenerator(new \SecurityLib\Strength(\SecurityLib\Strength::MEDIUM));
			$commande->token = $generator->generateString(32, 'abcdefghijklmnopqrstuvwxyz0123456789');
			
			$commande->save();
			return (new \lbs\view\lbsview($commande->token))->render('creerCommande', $req, $resp);
		}
		else
		{
			return (new \lbs\view\lbsview(null))->render('creerCommande', $req, $resp);
		}
    }
	
	public function ajouterSandwich(Request $req, Response $resp, $args)
	{
		$obj = json_decode($_POST["json"]);
		
		if(isset($obj->sandwichs as $unSandwich))
		{
			$sandwich = new lbs\model\sandwich();
			$sandwich->taillepain = filter_var($unSandwich->taille, FILTER_SANITIZE_NUMBER_INT);
			$sandwich->typepain = filter_var($unSandwich->typepain, FILTER_SANITIZE_NUMBER_INT);
			$sandwich->id_commande = $commande->id;
			$sandwich->save();
			
			foreach($unSandwich->ingredients as $unIngredient)
			{
				$ingredient = lbs\model\ingredient::find($unIngredient);
				$ingredient->sandwichsIngredient()->attach($sandwich->id);
			}
		}
	}
}