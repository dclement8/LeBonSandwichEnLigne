<?php
namespace lbs\view;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class lbsview
{
	protected $data = null ;
	protected $request=null; 
	protected $args=null;
	protected $resp=null;
    
    public function __construct($data, Request $http_req, Response $resp, $args)
	{
        $this->data = $data;
		$this->request = $http_req ;
		$this->args = $args ;
		$this->resp = $resp ;
    }
	
	
    private function detailsCategorie($resp)
	{
		$json = "";
		if($this->data == "[]")
		{
			$tab = array("error" => "ressource not found : ".$this->request->getUri());
			$json = json_encode($tab);
			$resp = $resp->withStatus(404);
			$resp = $resp->withHeader('Content-Type', 'application/json');
		}
		else
		{
			$json = $this->data;
			$json = substr($json, 0, -1);
			$json = substr($json, 1);
			$resp = $resp->withStatus(200)->withHeader('Content-Type', 'application/json');
		}
		$resp->getBody()->write($json);
		return $resp;
    }
	
	public function render($selector, $resp)
	{
		switch($selector)
		{
			case "detailsCategorie":
				$this->resp = $this->detailsCategorie($resp);
				break;
		}
		
		return $this->resp;
	}
}