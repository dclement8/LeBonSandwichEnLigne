<?php
namespace lbs\view;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class backendview
{
	protected $data = null ;

    public function __construct($data)
	{
        $this->data = $data;
    }

	private function getStatus() {
		if(array_key_exists('status', $this->data)) {
			unset($this->data['status']);
			return $this->data['status'];
		}
		return 400;
	}
	
	private function header($req, $resp, $args)
	{
		$html = "
			<!DOCTYPE html>
			<html lang='fr'>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1'>
					<title>Backend de gestion - LeBonSandwich</title>
					<script src='jquery.min.js'></script>
					<script src='script.js'></script>
					<link rel='stylesheet' type='text/css' href='style.css'/>
				</head>
				<body>
					<header>
						<h1>
							Backend de gestion LeBonSandwich
						</h1>
					</header>
					
		";
		if(isset($_SESSION["message"]))
		{
			$html .= "<div id='message'>".filter_var($_SESSION["message"], FILTER_SANITIZE_FULL_SPECIAL_CHARS)."</div>";
			unset($_SESSION["message"]);
		}
		$html .= "
					
					<div id='content'>
		";
		
		return $html;
	}
	
	private function footer($req, $resp, $args)
	{
		$html = "
					</div>
					<footer>
						2017 - LBS
					</footer>
				</body>
			</html>
		";
		
		return $html;
	}
	
	// ------------------------------------------
	
    private function ingredients($req, $resp, $args)
	{
		$html = "
			<div id='ingredients'>
			<h2>Liste des ingrédients</h2>
				<form method='post' action='ingredients' style='display:inline-block'>
					<b>
						Ajouter un ingrédient : 
					</b>
					<input type='text' name='newNom' placeholder='Nom' required /> 
					<input type='text' name='newDescription' placeholder='Description' required /> 
					<input type='text' name='newFournisseur' placeholder='Fournisseur' required /> 
					<select name='newCategorie' required >";
		
		$categories = \lbs\model\categorie::orderBy('nom')->get();
		foreach($categories as $uneCategorie)
		{
			$html .= "<option value='".$uneCategorie->id."'>".$uneCategorie->nom."</option>";
		}
		
		$html .= "
					</select>
					<button type='submit' name='ajouter'>Ajouter l'ingrédient</button>
				</form>
				<br/><br/>
				<form method='post' action='ingredients'>
					<button type='submit' name='supprimer'>Supprimer les ingrédients sélectionnés</button>
					<table>
						<tr>
							<th>
								<input type='checkbox' id='cochertout' name='cochertout' value='all' style='display:inline;' onclick='cocher()' />
							</th>
							<th>
								Nom
							</th>
							<th>
								Description
							</th>
							<th>
								Fournisseur
							</th>
							<th>
								Catégorie
							</th>
						</tr>";
		
		foreach($this->data[1] as $unIngredient)
		{
			$html .= "
				<tr>
					<td>
						<input type='checkbox' name='coche[]' id='case' value='".$unIngredient->id."' style='display:inline;' />
					</td>
					<td>
						".$unIngredient->nom."
					</td>
					<td>
						".$unIngredient->description."
					</td>
					<td>
						".$unIngredient->fournisseur."
					</td>
					<td>
						".$unIngredient->categorieIngredient()->get()[0]->nom."
					</td>
				</tr>
			";
		}
		
		$html .= "</table>
				<button type='submit' name='supprimer'>Supprimer les ingrédients sélectionnés</button>
			</form>
			</div>
		";
		
		return $html;
    }
	
	private function authentification($req, $resp, $args)
	{
		$html = "
			<div id='connexion'>
				<form method='post' action='connexion'>
					<h2>Authentification</h2>
					<input type='text' name='login' placeholder='Login' required />
					<br/>
					<input type='password' name='motdepasse' placeholder='Mot de passe' required />
					<br/>
					<br/>
					<button type='submit' name='connect'>Connexion</button>
				</form>
			</div>
		";
		
		return $html;
    }
	
	private function tableaubord($req, $resp, $args)
	{
		$html = "
			<div id='tableaubord'>
				<h2>Tableau de bord</h2>
				<p>
					<b>
						Nombre de commandes effectuées aujourd'hui : 
					</b>
					".$this->data[0]->count()."
				</p>
				<p>
					<b>
						Chiffre d'affaires de la journée : 
					</b>";
				
		$somme = 0;
		foreach($this->data[0] as $uneCommande)
		{
			$somme += $uneCommande->montant;
		}
		$html .= $somme;
					
		$html .= " €
				</p>
			</div>
		";
		
		return $html;
    }
	
	private function tailles($req, $resp, $args)
	{
		$html = "
			<div id='tailles'>
				<h2>Tailles de sandwich</h2>
				<form method='post' action='taille' style='display:inline-block'>
					<b>
						Ajouter une taille : 
					</b>
					<input type='text' name='newNom' placeholder='Nom' required /> 
					<input type='text' name='newDescription' placeholder='Description' required /> 
					<input type='text' name='newPrix' placeholder='Prix' required /> 
					<button type='submit' name='ajouter'>Ajouter la taille</button>
				</form>
				<br/><br/>
				<form method='post' action='taille'>
					<button type='submit' name='supprimer'>Supprimer les tailles sélectionnés</button>
					<table>
						<tr>
							<th>
								<input type='checkbox' id='cochertout2' name='cochertout2' value='all' style='display:inline;' onclick='cocher2()' />
							</th>
							<th>
								Nom
							</th>
							<th>
								Description
							</th>
							<th>
								Prix
							</th>
						</tr>";
		
		foreach($this->data[2] as $uneTaille)
		{
			$html .= "
				<tr>
					<td>
						<input type='checkbox' name='coche2[]' id='case' value='".$uneTaille->id."' style='display:inline;' />
					</td>
					<td>
						".$uneTaille->nom."
					</td>
					<td>
						".$uneTaille->description."
					</td>
					<td>
						".$uneTaille->prix."
					</td>
				</tr>
			";
		}
		
		$html .= "</table>
				<button type='submit' name='supprimer'>Supprimer les tailles sélectionnés</button>
			</form>
			</div>
		";
		
		return $html;
    }
	
	private function gestion($req, $resp, $args)
	{
		$html = $this->tableaubord($req, $resp, $args);
		$html .= $this->ingredients($req, $resp, $args);
		$html .= $this->tailles($req, $resp, $args);
		
		return $html;
	}

	public function render($selector, $req, $resp, $args)
	{
		$html = $this->header($req, $resp, $args);
		
		switch($selector)
		{
			case "gestion":
				$html .= $this->gestion($req, $resp, $args);
				break;
			case "authentification":
				$html .= $this->authentification($req, $resp, $args);
				break;
		}
		
		$html .= $this->footer($req, $resp, $args);
		
		$resp->getBody()->write($html);
		return $resp;
	}
}
