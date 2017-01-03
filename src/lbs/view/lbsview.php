<?php
namespace lbs\view;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class lbsview
{
	protected $data = null ;
    
    public function __construct($data)
	{
        $this->data = $data;
    }
	
	
    private function detailsCategorie($req, $resp)
	{
		$json = "";
		if($this->data == "[]")
		{
			$tab = array("error" => "ressource not found : ".$req->getUri());
			$json = json_encode($tab);
			$resp = $resp->withStatus(404);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = substr($json, 0, -1);
			$json = substr($json, 1);
			$json = '{ "categorie" : '.$json.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function toutesCategories($req, $resp)
	{
		$json = '{ "categories" : '.$this->data.'}';
		$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		$resp->getBody()->write($json);
		return $resp;
	}
	
	private function detailsIngredient($req, $resp)
	{
		$json = "";
		if($this->data == "[]")
		{
			$tab = array("error" => "ressource not found : ".$req->getUri());
			$json = json_encode($tab);
			$resp = $resp->withStatus(404);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = substr($json, 0, -1);
			$json = substr($json, 1);
			$json = '{ "ingredient" : '.$json.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function ingredientsCategorie($req, $resp)
	{
		$json = "";
		if($this->data == "[]")
		{
			$tab = array("error" => "ressource not found : ".$req->getUri());
			$json = json_encode($tab);
			$resp = $resp->withStatus(404);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = '{ "ingredients" : '.$json.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function categorieIngredient($req, $resp)
	{
		$json = "";
		if($this->data == "[]")
		{
			$tab = array("error" => "ressource not found : ".$req->getUri());
			$json = json_encode($tab);
			$resp = $resp->withStatus(404);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = '{ "categorie" : '.$json.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function creerCommande($req, $resp)
	{
		if($this->data == null)
		{
			$json = '{ "token" : "'.$this->data.'" }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "error" : "données manquantes pour la création de la commande" }';
			$resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function ajouterSandwich($req, $resp)
	{
		if(is_array($this->data))
		{
			$json = json_encode($this->data);
			$resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "sandwich" : '.$this->data->id.' }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	private function supprimerSandwich($req, $resp)
	{
		if(is_array($this->data))
		{
			$json = json_encode($this->data);
			$resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "commande" : '.$this->data.' }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	public function render($selector, $req, $resp)
	{
		switch($selector)
		{
			case "detailsCategorie":
				$this->resp = $this->detailsCategorie($req, $resp);
				break;
			case "toutesCategories":
				$this->resp = $this->toutesCategories($req, $resp);
				break;
			case "detailsIngredient":
				$this->resp = $this->detailsIngredient($req, $resp);
				break;
			case "ingredientsCategorie":
				$this->resp = $this->ingredientsCategorie($req, $resp);
				break;
			case "categorieIngredient":
				$this->resp = $this->categorieIngredient($req, $resp);
				break;
			case "creerCommande":
				$this->resp = $this->creerCommande($req, $resp);
				break;
			case "ajouterSandwich":
				$this->resp = $this->ajouterSandwich($req, $resp);
				break;
			case "supprimerSandwich":
				$this->resp = $this->supprimerSandwich($req, $resp);
				break;
		}
		
		return $this->resp;
	}
}