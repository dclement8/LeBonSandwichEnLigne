<?php
namespace lbs\control;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \lbs\AppInit;

// Connexion à la BDD
$connexion = new AppInit();
$connexion->bootEloquent("../conf/config.ini");

class lbscontrolprive
{
    protected $c=null; 
    
    public function __construct($c)
	{
        $this->c = $c;
    }
	
	public function toutesCommandes(Request $req, Response $resp, $args)
	{
		$limit = null;
		$offset = null;
		$etat = null;
		$date = null;
		
		if(isset($_GET["limit"]))
		{
			$limit = filter_var($_GET["limit"], FILTER_SANITIZE_NUMBER_INT);
		}
		if(isset($_GET["offset"]))
		{
			$offset = filter_var($_GET["offset"], FILTER_SANITIZE_NUMBER_INT);
		}
		if(isset($_GET["etat"]))
		{
			$etat = filter_var($_GET["etat"], FILTER_SANITIZE_NUMBER_INT);
		}
		if(isset($_GET["date"]))
		{
			$date = filter_var($_GET["date"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
		$commandes = null;
		if(isset($_GET["etat"]))
		{
			$commandes = \lbs\model\commande::where('etat', '=', $etat)->orderBy('dateretrait');
		}
		if(isset($_GET["date"]))
		{
			$commandes = \lbs\model\commande::where('dateretrait', '=', $date)->orderBy('dateretrait');
		}
		
		if($commandes == null)
		{
			$commandes = \lbs\model\commande::orderBy('dateretrait');
		}
		
		if(isset($_GET["offset"]))
		{
			$commandes = $commandes->skip($offset);
		}
		if(isset($_GET["limit"]))
		{
			$commandes = $commandes->take($limit);
		}
		
		$commandes = $commandes->get();
		
		$tab = array($commandes->toJson(), $limit);
		
		return (new \lbs\view\lbsviewprive($tab))->render('toutesCommandes', $req, $resp, $args);
    }
	
    public function detailsCommande(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$json = \lbs\model\commande::where('id', $id)->get()->toJson();
		return (new \lbs\view\lbsviewprive($json))->render('detailsCommande', $req, $resp, $args);
    }
	
	public function changementEtat(Request $req, Response $resp, $args)
	{
		// Envoi de l'état en JSON
		
		// Exemple :
		// { "etat" : 2 }
		
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		$obj = json_decode($req->getBody());
		
		if(\lbs\model\sandwich::where('id', $id)->get()->toJson() != "[]")
		{
			$commande = \lbs\model\commande::find($id);
			if(($obj->etat < 6) && ($obj->etat > 0))
			{
				if($commande->etat > $obj->etat)
				{
					$arr = array('error' => 'on ne peut pas rétrograder l\'état d\'une commande : '.$req->getUri());
					$resp = $resp->withStatus(400);
					return (new \lbs\view\lbsviewprive($arr))->render('changementEtat', $req, $resp, $args);
				}
				else
				{
					$commande->etat = $obj->etat
					$commande->save();
					return (new \lbs\view\lbsviewprive($commande))->render('changementEtat', $req, $resp, $args);
				}
			}
			else
			{
				$arr = array('error' => 'état incorrect : '.$req->getUri());
				$resp = $resp->withStatus(400);
				return (new \lbs\view\lbsviewprive($arr))->render('changementEtat', $req, $resp, $args);
			}
		}
		else
		{
			$arr = array('error' => 'commande introuvable : '.$req->getUri());
				$resp = $resp->withStatus(404);
				return (new \lbs\view\lbsviewprive($arr))->render('changementEtat', $req, $resp, $args);
		}
    }
}