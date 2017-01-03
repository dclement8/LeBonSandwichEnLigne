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
		return (new \lbs\view\lbsview($json))->render('detailsCategorie', $req, $resp, $args);
    }
	
	public function toutesCategories(Request $req, Response $resp, $args)
	{
		$json = \lbs\model\categorie::get()->toJson();
		return (new \lbs\view\lbsview($json))->render('toutesCategories', $req, $resp, $args);
    }
	
	public function detailsIngredient(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\ingredient::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('detailsIngredient', $req, $resp, $args);
    }
	
	public function ingredientsCategorie(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\ingredient::where('cat_id', $id)->get()->toJson();
		return (new \lbs\view\lbsview($json))->render('ingredientsCategorie', $req, $resp, $args);
    }
	
	public function categorieIngredient(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = "[]";
		if(\lbs\model\ingredient::where('id', $id)->get()->toJson() != "[]")
		{
			$json = \lbs\model\ingredient::find($id)->categorieIngredient()->get()->toJson();
		}
		return (new \lbs\view\lbsview($json))->render('categorieIngredient', $req, $resp, $args);
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
			return (new \lbs\view\lbsview($commande->token))->render('creerCommande', $req, $resp, $args);
		}
		else
		{
			return (new \lbs\view\lbsview(null))->render('creerCommande', $req, $resp, $args);
		}
    }
	
	public function ajouterSandwich(Request $req, Response $resp, $args)
	{
		// Créer le sandwich de A à Z
		// Les données sont envoyées en POST en JSON
		
		var_dump($_POST);
		
		//$dataSandwich = json_decode($_POST);
		
		/*
		$token = filter_var($args['token'], FILTER_SANITIZE_STRING);
		$json = "[]";
		if(\lbs\model\commande::where('token', $token)->get()->toJson() != "[]")
		{
			$commande = \lbs\model\commande::select('etat')->where('token', $token)-get();
			$etatCommande = "";
			foreach ($commande as $etat)
			{
				$etatCommande = $etat->etat;
			}
			
			if(($etatCommande == 1) || ($etatCommande == 2))
			{
				$leSandwich = new \lbs\model\sandwich();
				
				$leSandwich->id_commande = $token;
				$leSandwich->save();
				
				return (new \lbs\view\lbsview($leSandwich))->render('ajouterSandwich', $req, $resp, $args);
			}
			else
			{
				$arr = array('error' => 'impossible de modifier la commande : '.$req->getUri());
				return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);
			}
		}
		else
		{
			$arr = array('error' => 'commande introuvable : '.$req->getUri());
			return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);
		}*/
	}
	
	public function supprimerSandwich(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = "[]";
		if(\lbs\model\sandwich::where('id', $id)->get()->toJson() != "[]")
		{
			$reqCommande = \lbs\model\sandwich::select('id_commande')->where('id', $id)-get();
			$idCommande = "";
			foreach ($reqCommande as $idCom)
			{
				$idCommande = $idCom->id_commande;
			}
			
			$commande = \lbs\model\commande::select('etat')->where('id', $idCommande)-get();
			$etatCommande = "";
			foreach ($commande as $etat)
			{
				$etatCommande = $etat->etat;
			}
			
			if(($etatCommande == 1) || ($etatCommande == 2))
			{
				\lbs\model\sandwich::destroy($id);
					
				return (new \lbs\view\lbsview($idCommande))->render('supprimerSandwich', $req, $resp, $args);
			}
			else
			{
				$arr = array('error' => 'impossible de modifier la commande : '.$req->getUri());
				return (new \lbs\view\lbsview($arr))->render('supprimerSandwich', $req, $resp, $args);
			}
		}
		else
		{
			$arr = array('error' => 'sandwich introuvable : '.$req->getUri());
			return (new \lbs\view\lbsview($arr))->render('supprimerSandwich', $req, $resp, $args);
		}
	}
}