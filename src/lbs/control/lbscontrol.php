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
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$id2 = filter_var($args['id2'], FILTER_SANITIZE_NUMBER_INT);
		$json = "[]";
		if(\lbs\model\commande::where('id', $id)->get()->toJson() != "[]")
		{
			$commande = \lbs\model\commande::select('etat')->where('id', $id)-get();
			$etatCommande = "";
			foreach ($commande as $etat)
			{
				$etatCommande = $etat->etat;
			}

			if(($etatCommande == 1) || ($etatCommande == 2))
			{
				if(\lbs\model\sandwich::where('id', $id2)->get()->toJson() != "[]")
				{
					$leSandwich = \lbs\model\sandwich::find($id2);
					$leSandwich->id_commande = $id;
					$leSandwich->save();

					return (new \lbs\view\lbsview($leSandwich))->render('ajouterSandwich', $req, $resp);
				}
				else
				{
					$arr = array('error' => 'sandwich introuvable');
					return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp);
				}
			}
			else
			{
				$arr = array('error' => 'impossible de modifier la commande');
				return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp);
			}
		}
		else
		{
			$arr = array('error' => 'commande introuvable');
			return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp);
		}
	}

	public function dateCommande(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		// Date dans un format accepté par la fonction strtotime(), par exemple aaaa-mm-dd
		$date = date_parse($args['date']);

		$commande = \lbs\model\commande::find($id);
		if($commande === false)
			return (new \lbs\view\lbsview('[]'))->render('dateCommande', $req, $resp);
		if($date === false)
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);
		if(!checkdate($date['month'], $date['day'], $date['year']))
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);
		// On compare avec le timestamp d'aujourd'hui à minuit
		if(mktime(0, 0, 0, $date['month'], $date['day'], $date['year']) < mktime(0, 0, 0, date('m'), date('d'), date('Y')))
			return (new \lbs\view\lbsview(false))->render('dateCommande', $req, $resp);

		$commande->dateretrait = $date['year'].'-'.$date['month'].'-'.$date['day'];
		if($commande->save()) {
			$json = $commande->toJson();
			return (new \lbs\view\lbsview($json))->render('dateCommande', $req, $resp);
		}
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

				return (new \lbs\view\lbsview($idCommande))->render('supprimerSandwich', $req, $resp);
			}
			else
			{
				$arr = array('error' => 'impossible de modifier la commande');
				return (new \lbs\view\lbsview($arr))->render('supprimerSandwich', $req, $resp);
			}
		}
		else
		{
			$arr = array('error' => 'sandwich introuvable');
			return (new \lbs\view\lbsview($arr))->render('supprimerSandwich', $req, $resp);
		}
	}
}
