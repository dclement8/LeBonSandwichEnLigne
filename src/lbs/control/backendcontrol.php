<?php
namespace lbs\control;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \lbs\AppInit;

// Connexion à la BDD
$connexion = new AppInit();
$connexion->bootEloquent("./conf/config.ini");

class backendcontrol
{
    protected $c=null;

    public function __construct($c)
	{
        $this->c = $c;
    }

	
	public function gestion(Request $req, Response $resp, $args)
	{
		// Tableau de bord
		$commandes = \lbs\model\commande::where('dateretrait', '=', 'CURRENT_DATE()')->get();
		
		// Ingrédients
		$ingredients = \lbs\model\ingredient::orderBy('nom')->get();
		
		// Tailles de sandwich
		$tailles = \lbs\model\taille::orderBy('nom')->get();
		
		$data = array($commandes, $ingredients, $tailles);
		return (new \lbs\view\backendview($data))->render('gestion', $req, $resp, $args);
	}

    public function accueil(Request $req, Response $resp, $args)
	{
		if(isset($_SESSION["login"]))
		{
			return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
		}
		else
		{
			return (new \lbs\view\backendview(null))->render('authentification', $req, $resp, $args);
		}
    }
	
	public function connexion(Request $req, Response $resp, $args)
	{
		if(isset($_POST["connect"]))
		{
			if((isset($_POST["login"])) && (isset($_POST["motdepasse"])))
			{
				if($_POST["login"] == 'admin')
				{
					if($_POST["motdepasse"] == '174086')
					{
						$_SESSION["login"] = 'admin';
						return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
					}
					else
					{
						$_SESSION["message"] = "Mot de passe incorrect";
						return (new \lbs\view\backendview(null))->render('authentification', $req, $resp, $args);
					}
				}
				else
				{
					$_SESSION["message"] = "Login incorrect";
					return (new \lbs\view\backendview(null))->render('authentification', $req, $resp, $args);
				}
			}
			else
			{
				return (new \lbs\view\backendview(null))->render('authentification', $req, $resp, $args);
			}
		}
		else
		{
			return (new \lbs\view\backendview(null))->render('authentification', $req, $resp, $args);
		}
	}
	
	public function ingredients(Request $req, Response $resp, $args)
	{
		if(isset($_POST["ajouter"]))
		{
			$ingredient = new \lbs\model\ingredient();
			$ingredient->nom = filter_var($_POST["newNom"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$ingredient->description = filter_var($_POST["newDescription"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$ingredient->fournisseur = filter_var($_POST["newFournisseur"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$ingredient->cat_id = filter_var($_POST["newCategorie"], FILTER_SANITIZE_NUMBER_INT);
			$ingredient->save();
			
			$_SESSION["message"] = "Ingrédient ajouté";
			return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
		}
		else
		{
			if(isset($_POST["supprimer"]))
			{
				for($i = 0; $i < count($_POST["coche"]); $i++)
				{
					\lbs\model\ingredient::find($_POST["coche"][$i])->sandwichsIngredient()->detach();
					\lbs\model\ingredient::destroy($_POST["coche"][$i]);
				}
				
				$_SESSION["message"] = "Ingrédients supprimés";
				return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
			}
			else
			{
				return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
			}
		}
	}
	
	public function taille(Request $req, Response $resp, $args)
	{
		if(isset($_POST["ajouter"]))
		{
			$taille = new \lbs\model\taille();
			$taille->nom = filter_var($_POST["newNom"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$taille->description = filter_var($_POST["newDescription"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$taille->prix = filter_var($_POST["newPrix"], FILTER_SANITIZE_NUMBER_FLOAT);
			$taille->save();
			
			$_SESSION["message"] = "Taille ajoutée";
			return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
		}
		else
		{
			if(isset($_POST["supprimer"]))
			{
				for($i = 0; $i < count($_POST["coche2"]); $i++)
				{
					$sandwichs = \lbs\model\taille::find($_POST["coche2"][$i])->sandwich()->get();
					foreach($sandwichs as $unSandwich)
					{
						$unSandwich->taillepain = null;
						$unSandwich->save();
					}
					\lbs\model\taille::destroy($_POST["coche2"][$i]);
				}
				
				$_SESSION["message"] = "Tailles supprimées";
				return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
			}
			else
			{
				return (new \lbs\control\backendcontrol($this))->gestion($req, $resp, $args);
			}
		}
	}
}
