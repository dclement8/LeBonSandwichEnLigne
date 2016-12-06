<?php
// Autoloaders
require_once("conf/autoload.php");
require_once("vendor/autoload.php");

// Connexion à la BDD
$connexion = new AppInit();
$connexion->bootEloquent("conf/config.ini");

// Retour en JSON
if(isset($_GET["id"]))
{
	$json = model\categorie::where('id', $_GET["id"])->get()->toJson();
	
	header("Content-Type: application/json");
	echo $json;
}
else
{
	if((isset($_POST["nom"])) && (isset($_POST["description"])))
	{
		$cat = new model\categorie();
		$cat->nom = $_POST["nom"];
		$cat->description = $_POST["description"];
		$cat->save();
		
		http_response_code(201);
	}
	else
	{
		$res = model\categorie::select('id', 'nom')->get();
		$tab = array("nb" => $res->count(), "categories" => $res);
		$json = json_encode($tab);
		
		header("Content-Type: application/json");
		echo $json;
	}
}