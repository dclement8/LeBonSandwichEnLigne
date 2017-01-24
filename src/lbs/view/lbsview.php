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

	private function getStatus() {
		if(array_key_exists('status', $this->data)) {
			if(is_numeric($this->data['status'])) {
				$status = $this->data['status'];
				unset($this->data['status']);
				return $status;
			}
		}
		return 400;
	}

    private function detailsCategorie($req, $resp, $args)
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
			$json = '{ "categorie" : '.$json.', "links" : { "all" : { "href" : "/categories" } , "ingredients" : { "href" : "/categories/'.$args['id'].'/ingredients" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function toutesCategories($req, $resp, $args)
	{
		$json = '{ "categories" : '.$this->data.' }';
		$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		$resp->getBody()->write($json);
		return $resp;
	}

	private function detailsIngredient($req, $resp, $args)
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
			$json = '{ "ingredient" : '.$json.' , "links" : { "categorie" : { "href" : "/ingredients/'.$args['id'].'/categorie" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function ingredientsCategorie($req, $resp, $args)
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
			$json = '{ "ingredients" : '.$json.' , "links" : { "all" : { "href" : "/categories" } , "details" : { "href" : "/categories/'.$args['id'].'" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function categorieIngredient($req, $resp, $args)
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
			$json = '{ "categorie" : '.$json.' , "links" : { "details" : { "href" : "/ingredients/'.$args['id'].'" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function creerCommande($req, $resp, $args)
	{
		if($this->data != null)
		{
			$json = '{ "commande" : { "token" : "'.$this->data->token.'" , "id" : '.$this->data->id.' } , "links" : { "view" : { "href" : "/commandes/'.$this->data->id.'" } } }';
			$resp = $resp->withStatus(201)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "error" : "données manquantes ou incorrectes pour la création de la commande : '.$req->getUri().'" }';
			$resp = $resp->withStatus(400)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function ajouterSandwich($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$json = json_encode($this->data);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "sandwich" : '.$this->data->id.' , "links" : { "details" : { "href" : "/commandes/'.$this->data->id.'" } , "delete" : { "href" : "/sandwichs/'.$this->data->id.'" } } }';
			$resp = $resp->withStatus(201)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
	}

	private function dateCommande($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = '{ "commande" : '.$json.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function supprimerSandwich($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "commande" : '.$this->data.' , "links" : { "view" : { "href" : "/commandes/'.$this->data.'" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function modifierSandwich($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "sandwich" : '.$this->data->id.' , "links" : { "details" : { "href" : "/commandes/'.$_GET['token'].'" } , "delete" : { "href" : "/sandwichs/'.$this->data->id.'" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function payerCommande($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "commande" : '.$this->data.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function etatCommande($req, $resp, $args)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "commande" : '.$this->data.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function creerCarte($req, $resp, $args) {
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "id" : '.$this->data->id.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
	}

	private function lireCarte($req, $resp, $args) {
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "id" : '.$this->data->id.', "token" : "'.$this->data->token.'", "credit" : '.$this->data->credit.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
	}

	private function payerCarte($req, $resp, $args) {
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = '{ "commande" : '.$this->data.'}';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
	}

	public function render($selector, $req, $resp, $args)
	{
		switch($selector)
		{
			case "detailsCategorie":
				$this->resp = $this->detailsCategorie($req, $resp, $args);
				break;
			case "toutesCategories":
				$this->resp = $this->toutesCategories($req, $resp, $args);
				break;
			case "detailsIngredient":
				$this->resp = $this->detailsIngredient($req, $resp, $args);
				break;
			case "ingredientsCategorie":
				$this->resp = $this->ingredientsCategorie($req, $resp, $args);
				break;
			case "categorieIngredient":
				$this->resp = $this->categorieIngredient($req, $resp, $args);
				break;
			case "creerCommande":
				$this->resp = $this->creerCommande($req, $resp, $args);
				break;
			case "ajouterSandwich":
				$this->resp = $this->ajouterSandwich($req, $resp, $args);
				break;
			case "supprimerSandwich":
				$this->resp = $this->supprimerSandwich($req, $resp, $args);
				break;
			case "modifierSandwich":
				$this->resp = $this->modifierSandwich($req, $resp, $args);
				break;
			case "dateCommande":
				$this->resp = $this->dateCommande($req, $resp, $args);
				break;
			case "payerCommande":
				$this->resp = $this->payerCommande($req, $resp, $args);
				break;
			case "etatCommande":
				$this->resp = $this->etatCommande($req, $resp, $args);
				break;
			case "creerCarte":
				$this->resp = $this->creerCarte($req, $resp, $args);
				break;
			case "lireCarte":
				$this->resp = $this->lireCarte($req, $resp, $args);
				break;
			case "payerCarte":
				$this->resp = $this->payerCarte($req, $resp, $args);
				break;
		}

		return $this->resp;
	}
}
