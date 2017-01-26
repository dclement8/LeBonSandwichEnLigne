<?php
namespace lbs\view;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class lbsviewprive
{
	protected $data = null ;
    
    public function __construct($data)
	{
        $this->data = $data;
    }

	private function toutesCommandes($req, $resp)
	{
		// Vérifier offset
		$links = "";
		if($this->data[1] != null)
		{
			$previous = $this->data[1] - $this->data[1];
			if($this->data[1] == 0)
			{
				$previous = $this->data[1];
			}
			$next = $this->data[1];
			
			$links = ' , "previous" : { "href" : "/commandes?limit='.$this->data[1].'&offset='.$previous.'" } , "next" : { "href" : "/commandes?limit='.$this->data[1].'&offset='.$next.'" }';
		}
		
		$json = '{ "commandes" : '.$this->data[0].' , "links" : { "all" : { "href" : "/commandes" } '.$links.' }';
		$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		$resp->getBody()->write($json);
		return $resp;
	}

	private function detailsCommande($req, $resp, $args)
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
			$json = '{ "commande" : '.$json.', "links" : { "all" : { "href" : "/commandes" } , "sandwichs" : { "href" : "/commandes/'.$args['id'].'/sandwich" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }

	private function changementEtat($req, $resp)
	{
		if(is_array($this->data))
		{
			$status = $this->getStatus();
			$json = json_encode($this->data);
			$resp = $resp->withStatus($status)->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$obj = $this->data;
			$json = '{ "etat" : '.$obj->etat.' , "links" : { "details" : { "href" : "/commandes/'.$obj->id.'" } } }';
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
	}

	public function render($selector, $req, $resp, $args)
	{
		switch($selector)
		{
			case "toutesCommandes":
				$this->resp = $this->toutesCommandes($req, $resp, $args);
				break;
			case "detailsCommande":
				$this->resp = $this->detailsCommande($req, $resp, $args);
				break;
			case "changementEtat":
				$this->resp = $this->changementEtat($req, $resp, $args);
				break;
		}
		

		return $this->resp;
	}
}