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

		// Les données sont envoyées en POST en JSON



		// Exemple :

		// { "dateretrait" : "01/01/2000" , "montant" : 10 }



		$obj = json_decode($_POST["json"]);

		$dateRetrait = filter_var($obj->dateretrait, FILTER_SANITIZE_FULL_SPECIAL_CHARS);



		$commande = new \lbs\model\commande();



		if(isset($obj->dateretrait) && isset($obj->montant))

		{

			if((\DateTime::createFromFormat("Y-m-d", $dateRetrait)) === false)

			{

				return (new \lbs\view\lbsview(null))->render('creerCommande', $req, $resp, $args);

			}

			else

			{

				$commande->dateretrait = $dateRetrait;

				$commande->etat = 1;

				$commande->montant = filter_var($obj->montant, FILTER_SANITIZE_NUMBER_FLOAT);;



				$factory = new \RandomLib\Factory;

				$generator = $factory->getGenerator(new \SecurityLib\Strength(\SecurityLib\Strength::MEDIUM));

				$commande->token = $generator->generateString(32, 'abcdefghijklmnopqrstuvwxyz0123456789');



				$commande->save();

				return (new \lbs\view\lbsview($commande))->render('creerCommande', $req, $resp, $args);

			}

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



		// Exemple :

		// { "taillepain" : 1 , "typepain" : 1 , "ingredients" : [1, 3, 4, 9] }



		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

		$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$dataSandwich = json_decode($_POST["json"], true);



		if(\lbs\model\commande::where('id', $id)->get()->toJson() != "[]")

		{

			if(isset($_GET["token"]))

			{

				$commande = \lbs\model\commande::find($id);

				if($commande->token == $token)

				{

					if($commande->etat <= 2)

					{

						if((isset ($dataSandwich["taillepain"])) && (isset ($dataSandwich["typepain"])) && (isset ($dataSandwich["ingredients"])))

						{

							$sandwich = new \lbs\model\sandwich();

							$sandwich->taillepain = filter_var($dataSandwich["taillepain"], FILTER_SANITIZE_NUMBER_INT);

							$sandwich->typepain = filter_var($dataSandwich["typepain"], FILTER_SANITIZE_NUMBER_INT);

							$sandwich->id_commande = $id;

							$sandwich->save();

							$idSandwich = $sandwich->id;



							// Enregistrer les ingrédients

							if(is_array($dataSandwich["ingredients"]))

							{

								for($i = 0; $i < count($dataSandwich["ingredients"]); $i++)

								{

									if(\lbs\model\ingredient::where('id', filter_var($dataSandwich["ingredients"][$i], FILTER_SANITIZE_NUMBER_INT))->get()->toJson() != "[]")

									{

										$sandwich->ingredientsSandwich()->attach(filter_var($dataSandwich["ingredients"][$i], FILTER_SANITIZE_NUMBER_INT));

									}

								}

								return (new \lbs\view\lbsview($sandwich))->render('ajouterSandwich', $req, $resp, $args);

							}

							else

							{

								$arr = array('error' => 'la donnée ingrédient n\'est pas un tableau : '.$req->getUri());

								$resp = $resp->withStatus(400);

								return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

							}

						}

						else

						{

							$arr = array('error' => 'données manquantes : '.$req->getUri());

							$resp = $resp->withStatus(400);

							return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

						}

					}

					else

					{

						$arr = array('error' => 'vous n\'êtes pas autorisé à modifier cette commande en raison de son état : '.$req->getUri());

						$resp = $resp->withStatus(403);

						return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

					}

				}

				else

				{

					$arr = array('error' => 'mauvais token : '.$req->getUri());

					$resp = $resp->withStatus(403);

					return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

				}

			}

			else

			{

				$arr = array('error' => 'token exigé : '.$req->getUri());

				$resp = $resp->withStatus(403);

				return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

			}

		}

		else

		{

			$arr = array('error' => 'commande inexistante : '.$req->getUri());

			$resp = $resp->withStatus(404);

			return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

		}

	}



	public function dateCommande(Request $req, Response $resp, $args)

	{

        function verifierDate($date) {

            if(!is_array($date) || $date === false || $date === null)

                return false;

            if($date['error_count'] > 0)

                return false;

            if(!checkdate($date['month'], $date['day'], $date['year']))

                return false;

            return true;

        }



		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);



        if(empty($_GET["token"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'token exigé : '.$req->getUri(),

                'status' => 401

			)))->render('dateCommande', $req, $resp, $args);

		}

		$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



		// Date dans un format accepté par la fonction strtotime(), par exemple aaaa-mm-dd

		$date = date_parse($args['date']);



		$commande = \lbs\model\commande::find($id);

		if($commande === false  || $commande === null) {

			return (new \lbs\view\lbsview(array(

				'error' => 'Ressource non trouvée : '.$req->getUri(),

				'status' => 404

			)))->render('dateCommande', $req, $resp, $args);

		}



        if($commande->token != $token) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token : '.$req->getUri(),

                'status' => 403

			)))->render('dateCommande', $req, $resp, $args);

        }



		if(!verifierDate($date)) {

			return (new \lbs\view\lbsview(array(

				'error' => 'Date incorrecte : '.$req->getUri()

			)))->render('dateCommande', $req, $resp, $args);

		}



		// On compare avec le timestamp d'aujourd'hui à minuit

		if(mktime(0, 0, 0, $date['month'], $date['day'], $date['year']) < mktime(0, 0, 0, date('m'), date('d'), date('Y'))) {

			return (new \lbs\view\lbsview(array(

				'error' => 'Date dépassée : '.$req->getUri()

			)))->render('dateCommande', $req, $resp, $args);

		}



		$commande->dateretrait = $date['year'].'-'.$date['month'].'-'.$date['day'];

		if($commande->save()) {

			$json = $commande->toJson();

			return (new \lbs\view\lbsview($json))->render('dateCommande', $req, $resp, $args);

		}

    }



	public function supprimerSandwich(Request $req, Response $resp, $args)

	{

		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

		$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$json = "[]";



		if(\lbs\model\sandwich::where('id', $id)->get()->toJson() != "[]")

		{

			$leSandwich = \lbs\model\sandwich::where('id', $id)->get();

			if(isset($_GET["token"]))

			{

				$commande = \lbs\model\sandwich::find($id)->belongsTo('\lbs\model\commande', "id_commande")->first();

				if($commande->token == $token)

				{

					$reqCommande = \lbs\model\sandwich::select('id_commande')->where('id', $id)->get();

					$idCommande = "";

					foreach ($reqCommande as $idCom)

					{

						$idCommande = $idCom->id_commande;

					}



					$commande = \lbs\model\commande::select('etat')->where('id', $idCommande)->get();

					$etatCommande = "";

					foreach ($commande as $etat)

					{

						$etatCommande = $etat->etat;

					}



					if(($etatCommande == 1) || ($etatCommande == 2))

					{

						\lbs\model\sandwich::find($id)->ingredientsSandwich()->detach();

						\lbs\model\sandwich::destroy($id);

						return (new \lbs\view\lbsview($idCommande))->render('supprimerSandwich', $req, $resp, $args);

					}

					else

					{

						$arr = array('error' => 'impossible de modifier la commande : '.$req->getUri());

						$resp = $resp->withStatus(403);

						return (new \lbs\view\lbsview($arr))->render('supprimerSandwich', $req, $resp, $args);

					}

				}

				else

				{

					$arr = array('error' => 'mauvais token : '.$req->getUri());

					$resp = $resp->withStatus(403);

					return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

				}

			}

			else

			{

				$arr = array('error' => 'token exigé : '.$req->getUri());

				$resp = $resp->withStatus(403);

				return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

			}

		}

		else

		{

			$arr = array('error' => 'sandwich inexistant : '.$req->getUri());

			$resp = $resp->withStatus(404);

			return (new \lbs\view\lbsview($arr))->render('ajouterSandwich', $req, $resp, $args);

		}

	}



	public function modifierSandwich(Request $req, Response $resp, $args)

	{

		// Modifie le sandwich

		// Si l'état est à 1 (commande créée), on peut modifier le sandwich de A à Z (type pain + ingrédients + taille pain)

		// Si l'état est à 2 (commande payée), on peut modifier le sandwich à coût constant (type pain + ingrédients)

		// Sinon, modification impossible

		// Les données sont envoyées en POST en JSON



		// Exemple :

		// { "taillepain" : 1 , "typepain" : 1 , "ingredients" : [1, 3, 4, 9] }



		$idSandwich = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);



		if(empty($_GET["token"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'token exigé : '.$req->getUri(),

                'status' => 401

			)))->render('modifierSandwich', $req, $resp, $args);

		}



		$commandeToken = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if(empty($_POST["json"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'pas de données : '.$req->getUri()

			)))->render('modifierSandwich', $req, $resp, $args);

		}

		$dataSandwich = json_decode($_POST["json"], true);



		$commande = \lbs\model\commande::where('token', '=', $commandeToken)->first();

		if($commande === false || $commande === null) {

			return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token : '.$req->getUri(),

                'status' => 403

			)))->render('modifierSandwich', $req, $resp, $args);

		}



		$sandwich = \lbs\model\sandwich::find($idSandwich);

		if($sandwich === false || $sandwich === null) {

			return (new \lbs\view\lbsview(array(

				'error' => 'sandwich inexistant : '.$req->getUri(),

                'status' => 404

			)))->render('modifierSandwich', $req, $resp, $args);

		}



		if($sandwich->id_commande != $commande->id) {

			return (new \lbs\view\lbsview(array(

				'error' => 'mauvais id : '.$req->getUri()

			)))->render('modifierSandwich', $req, $resp, $args);

		}



		if($commande->etat > 2) {

			return (new \lbs\view\lbsview(array(

				'error' => 'commande déjà traitée : '.$req->getUri()

			)))->render('modifierSandwich', $req, $resp, $args);

		}



		if($commande->etat == 1 && isset($dataSandwich["taillepain"])) {

			$taillepain = filter_var($dataSandwich["taillepain"], FILTER_SANITIZE_NUMBER_INT);

			if($taillepain > 0 && $taillepain < 5)

				$sandwich->taillepain = $taillepain;

		}



		if(isset ($dataSandwich["typepain"])) {

			$typepain = filter_var($dataSandwich["typepain"], FILTER_SANITIZE_NUMBER_INT);

			if($typepain > 0 && $typepain < 4)

				$sandwich->typepain = $typepain;

		}



		// Supprime les anciens ingrédients de la table pivot

		$sandwich->ingredientsSandwich()->detach();



		$sandwich->save();



		// Modifier les ingrédients (tous les ingrédients doivent être précisés)

		if(is_array($dataSandwich["ingredients"])) {

			for($i = 0; $i < count($dataSandwich["ingredients"]); $i++) {

				if(\lbs\model\ingredient::where('id', filter_var($dataSandwich["ingredients"][$i], FILTER_SANITIZE_NUMBER_INT))->get()->toJson() != "[]")

				{

					$sandwich->ingredientsSandwich()->attach(filter_var($dataSandwich["ingredients"][$i], FILTER_SANITIZE_NUMBER_INT));

				}

			}

			return (new \lbs\view\lbsview($sandwich))->render('modifierSandwich', $req, $resp, $args);

		}

		else {

			$arr = array('error' => 'la donnée ingrédient n\'est pas un tableau : '.$req->getUri());

			return (new \lbs\view\lbsview($arr))->render('modifierSandwich', $req, $resp, $args);

		}

	}



    public function etatCommande(Request $req, Response $resp, $args) {

        // Obtenir l'état d'une commande : date, montant, état d'avancement – paiement



        $idCommande = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);



		if(empty($_GET["token"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'token exigé : '.$req->getUri(),

                'status' => 401

			)))->render('etatCommande', $req, $resp, $args);

		}



		$commandeToken = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



        $commande = \lbs\model\commande::find($idCommande);

        if($commande === false  || $commande === null) {

			return (new \lbs\view\lbsview(array(

				'error' => 'Ressource non trouvée : '.$req->getUri(),

				'status' => 404

			)))->render('etatCommande', $req, $resp, $args);

		}



        if($commande->token != $commandeToken) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token : '.$req->getUri(),

                'status' => 403

			)))->render('etatCommande', $req, $resp, $args);

        }



        $json = $commande->toJson();

        return (new \lbs\view\lbsview($json))->render('etatCommande', $req, $resp, $args);

    }



    public function payerCommande(Request $req, Response $resp, $args)

	{

		// Paye une commande

		// L'état doit être à 1 (commande créée)

		// Les données sont envoyées en POST en JSON



		// Exemple :

		// { "typecarte" : "mastercard" , "numero" : "5442 3811 6727 0320" , "expire" : "3/2020", "code" : "157" }



        function verifExpire($expire) {

            $expire = explode("/", $expire);

            if(count($expire) != 2)

                return false;

            if(!is_numeric($expire['0']) || !is_numeric($expire['1']))

                return false;

            if((int)$expire['1'] < date('y'))

                return false;

            elseif((int)$expire['1'] > date('y'))

                return true;

            if((int)$expire['0'] < date('n'))

                return false;

            return true;

        }



        function verifCode($code) {

            if(!is_numeric($code))

                return false;

            if((int)$code >= 0 && (int)$code <= 999)

                return true;

            return false;

        }



		$idCommande = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);



		if(empty($_GET["token"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'token exigé : '.$req->getUri(),

                'status' => 401

			)))->render('payerCommande', $req, $resp, $args);

		}



		$commandeToken = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if(empty($_POST["json"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'pas de données : '.$req->getUri()

			)))->render('payerCommande', $req, $resp, $args);

		}

		$dataCommande = json_decode($_POST["json"], true);



        $commande = \lbs\model\commande::find($idCommande);

		if($commande === false || $commande === null) {

            return (new \lbs\view\lbsview(array(

                'error' => 'Ressource non trouvée : '.$req->getUri(),

                'status' => 404

            )))->render('payerCommande', $req, $resp, $args);

		}



		if($commandeToken != $commande->token) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token : '.$req->getUri(),

                'status' => 403

			)))->render('payerCommande', $req, $resp, $args);

		}



		if($commande->etat != 1) {

			return (new \lbs\view\lbsview(array(

				'error' => 'commande déjà traitée : '.$req->getUri()

			)))->render('payerCommande', $req, $resp, $args);

		}



        /* Pas de vérification des données bancaires ici, juste sur la syntaxe */

        if(isset($dataCommande['typecarte']) && isset($dataCommande['numero']) && isset($dataCommande['expire']) && isset($dataCommande['code'])) {

            // Toutes les données sont bien transmises

            if($dataCommande['typecarte'] != 'visa' && $dataCommande['typecarte'] != 'mastercard') {

                return (new \lbs\view\lbsview(array(

    				'error' => 'type de carte non supporté : '.$req->getUri()

    			)))->render('payerCommande', $req, $resp, $args);

            }



            if(

                ($dataCommande['typecarte'] == 'visa' && !preg_match("^4[0-9]{12}(?:[0-9]{3})?$", $dataCommande['typecarte']))

                &&

                ($dataCommande['typecarte'] == 'mastercard' && !preg_match("^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$", $dataCommande['typecarte']))

            ) {

                return (new \lbs\view\lbsview(array(

    				'error' => 'numéro de carte incorrect : '.$req->getUri()

    			)))->render('payerCommande', $req, $resp, $args);

            }



            if(!verifExpire($dataCommande['expire'])) {

                return (new \lbs\view\lbsview(array(

    				'error' => 'carte expirée : '.$req->getUri()

    			)))->render('payerCommande', $req, $resp, $args);

            }



            if(!verifCode($dataCommande['code'])) {

                return (new \lbs\view\lbsview(array(

    				'error' => 'code incorrect : '.$req->getUri()

    			)))->render('payerCommande', $req, $resp, $args);

            }



            $commande->etat = 2;

            $commande->save();



            return (new \lbs\view\lbsview($commande))->render('payerCommande', $req, $resp, $args);

        }

        else {

            return (new \lbs\view\lbsview(array(

				'error' => 'données bancaires incomplètes : '.$req->getUri()

			)))->render('payerCommande', $req, $resp, $args);

        }

	}



    public function creerCarte(Request $req, Response $resp, $args)

	{

        // Crée une carte de fidélité

		// Les données sont envoyées en POST en JSON



		// Exemple :

		// { "motDePasse" : "azerty" }

        // Retourne un identifiant



        if(empty($_POST["json"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'pas de données : '.$req->getUri()

			)))->render('creerCarte', $req, $resp, $args);

		}

        $carteInfos = json_decode($_POST["json"], true);



        if(empty($carteInfos['motDePasse'])) {

            return (new \lbs\view\lbsview(array(

				'error' => 'veuillez spécifier un mot de passe pour cette carte de fidélité : '.$req->getUri()

			)))->render('creerCarte', $req, $resp, $args);

        }



        $carte = new \lbs\model\cartefidelite();

        $carte->motDePasse = password_hash($carteInfos['motDePasse'], PASSWORD_BCRYPT);

        $carte->token = null;

        $carte->credit = 0;

        $carte->save();



        return (new \lbs\view\lbsview($carte))->render('creerCarte', $req, $resp, $args);

    }



    public function lireCarte(Request $req, Response $resp, $args)

	{

        // Lit une carte de fidélité (renvoie un token à usage unique et le montant) => l'id et le mot de passe doivent correspondre

		// Les données sont envoyées en POST en JSON



        // Exemple :

		// { "motDePasse" : "azerty" }

        // TODO : basic authentification



        $idCarte = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);

        if(empty($_POST["json"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'pas de données : '.$req->getUri()

			)))->render('lireCarte', $req, $resp, $args);

		}

        $carteInfos = json_decode($_POST["json"], true);



        if(empty($carteInfos['motDePasse'])) {

            return (new \lbs\view\lbsview(array(

				'error' => 'veuillez spécifier un mot de passe pour cette carte de fidélité : '.$req->getUri()

			)))->render('lireCarte', $req, $resp, $args);

        }



        $carte = \lbs\model\cartefidelite::find($idCarte);

        if($carte === false || $carte === null) {

            return (new \lbs\view\lbsview(array(

                'error' => 'Ressource non trouvée : '.$req->getUri(),

                'status' => 404

            )))->render('lireCarte', $req, $resp, $args);

		}



        if(!password_verify($carteInfos['motDePasse'], $carte->motDePasse)) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais mot de passe : '.$req->getUri(),

                'status' => 403

			)))->render('lireCarte', $req, $resp, $args);

        }



        $factory = new \RandomLib\Factory;

        $generator = $factory->getGenerator(new \SecurityLib\Strength(\SecurityLib\Strength::MEDIUM));

        $carte->token = $generator->generateString(32, 'abcdefghijklmnopqrstuvwxyz0123456789');

        $carte->save();



        return (new \lbs\view\lbsview($carte))->render('lireCarte', $req, $resp, $args);

    }



    public function payerCarte(Request $req, Response $resp, $args)

	{

        // Payer un utilisant une carte de fidélité. Le token de la carte doit être fourni

        // Si montant atteint > 100 € => réduction de 5% accordée sur la commande et montant remis à 0



        // Le token de la carte doit être fourni (en GET) ainsi que celui de la commande (en GET aussi)

        // Une fois payé, on remet le token à null



        if(empty($_GET["token"]) || empty($_GET["commande"])) {

			return (new \lbs\view\lbsview(array(

				'error' => 'token de carte fidélité et de commande exigé : '.$req->getUri(),

                'status' => 401

			)))->render('payerCarte', $req, $resp, $args);

		}



        $carteToken = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $commandeToken = filter_var($_GET["commande"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);



        $commande = \lbs\model\commande::where('token', '=', $commandeToken)->first();

        if($commande === null || $commande === false) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token de commande : '.$req->getUri(),

                'status' => 403

			)))->render('payerCarte', $req, $resp, $args);

        }



        if($commande->etat != 1) {

            return (new \lbs\view\lbsview(array(

				'error' => 'la commande est déjà payée : '.$req->getUri()

			)))->render('payerCarte', $req, $resp, $args);

        }



        $carte = \lbs\model\cartefidelite::where('token', '=', $carteToken)->first();

        if($carte === null || $carte === false) {

            return (new \lbs\view\lbsview(array(

				'error' => 'mauvais token de carte : '.$req->getUri(),

                'status' => 403

			)))->render('payerCarte', $req, $resp, $args);

        }



        $carte->credit += $commande->montant;

        if($carte->credit > 100) {

            $commande->montant = round(($commande->montant) * 0.95, 2);

            $commande->save();

            $carte->credit = 0;

        }



        $carte->token = null;

        $carte->save();

        return (new \lbs\view\lbsview($commande))->render('payerCarte', $req, $resp, $args);

    }

    public function getFacture(Request $req, Response $resp, $args) 
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		if(\lbs\model\commande::where('id', $id)->get()->toJson() !="[]") {
			if(isset($_GET["token"])) {
				$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

				$commande = \lbs\model\commande::where('id', $id)->first();

					$comm = \lbs\model\commande::with('sandwich')
					->where('id', $id)->get();

					$count = \lbs\model\commande::with('sandwich')
					->where('id', $id);

					if($commande->token == $token) { 
						foreach($comm as $q) {
							
							if($q->etat == 4) {
								$sand = $q->sandwich;
								$totalCount = 0;
								$json = "";
								foreach($sand as $s) {
									$totalSand = array();
									$totalSand[] = $s->id;
									$totalCount = $totalCount + count($totalSand);
								}
									$json =	'{ "Facture": {	"Numero": "'.$q->id.'",	"DateRetrait": "'.$q->dateretrait.'", "NombreSandwich": "'.$totalCount.'", "MontantSandwich": "'.$q->montant.'" } }';
									
									$arr = array('error' => 'Facture retourné avec succès : '.$req->getUri());

									$resp = $resp->withStatus(200);

									return (new \lbs\view\lbsview($json))->render('getFacture', $req, $resp, $args );
							}
							else {
									$arr = array('error' => 'Impossible d\'afficher la facture la commande car son etat est '. $q->etat .' : '.$req->getUri());

									$resp = $resp->withStatus(403);

									return (new \lbs\view\lbsview($arr))->render('getFacture', $req, $resp, $args);								
							}
						}
					} else {
						$arr = array('error' => 'Token incorrect : '.$req->getUri());

						$resp = $resp->withStatus(400);

						return (new \lbs\view\lbsview($arr))->render('getFacture', $req, $resp, $args);						
					}

			} else {
					$arr = array('error' => 'Token manquant : '.$req->getUri());

					$resp = $resp->withStatus(400);

					return (new \lbs\view\lbsview($arr))->render('getFacture', $req, $resp, $args);				
			}
		}
		else {

				$arr = array('error' => 'Commande inexistante ou vide : '.$req->getUri());

				$resp = $resp->withStatus(404);

				return (new \lbs\view\lbsview($arr))->render('getFacture', $req, $resp, $args);	
		}
	}

    public function suppCommande(Request $req, Response $resp, $args)
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		if(\lbs\model\commande::where('id', $id)->get()->toJson() !="[]")
		{
				if(isset($_GET["token"]))
				{

					$commande = \lbs\model\commande::where('id', $id)->first();

					$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

					if($commande->token == $token) {

								if($commande->etat == 1) {

									\lbs\model\commande::destroy($id);
									$arr = array('error' => 'Commande  supprime avec succes : '.$req->getUri());

									$resp = $resp->withStatus(201);

									return (new \lbs\view\lbsview($arr))->render('suppCommande', $req, $resp, $args);
								}
								else {

									$arr = array('error' => 'Impossible  de supprimer la commande car l\'etat est '. $commande->etat .' : '.$req->getUri());

									$resp = $resp->withStatus(403);

									return (new \lbs\view\lbsview($arr))->render('suppCommande', $req, $resp, $args);
								}
							
					} else {

						$arr = array('error' => 'Token incorrect : '.$req->getUri());

						$resp = $resp->withStatus(400);

						return (new \lbs\view\lbsview($arr))->render('suppCommande', $req, $resp, $args);	
					}

				} else {

					$arr = array('error' => 'Token manquant : '.$req->getUri());

					$resp = $resp->withStatus(400);

					return (new \lbs\view\lbsview($arr))->render('getCommande', $req, $resp, $args);					
				}

		} else 

		{
			$arr = array('error' => 'Commande inexistante: '.$req->getUri());

			$resp = $resp->withStatus(404);

			return (new \lbs\view\lbsview($arr))->render('suppCommande', $req, $resp, $args);

		}

		
	}

	public function getCommande(Request $req, Response $resp, $args) 
	{
		$id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
		if(\lbs\model\commande::where('id', $id)->get()->toJson() !="[]") {
			if(isset($_GET["token"]))
			{
				$token = filter_var($_GET["token"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$commande = \lbs\model\commande::find($id);
				if($commande->token == $token) {
					$tarifTab = array();

					$sand = \lbs\model\sandwich::where('id_commande', $id)->get();
					$totalDetails = array();
					$PrixSandwich = array();
					$DetailsSandwich = array();

					$json = '{ 
									"DetailsCommande" : {
										"NombreSandwich" : '. $sand->count() .' ,
										"Sandwichs" :  [';

					foreach($sand as $s) {
							$taille = \lbs\model\taille::where('id', $s->taillepain)->first();
							$json .= '{ "Taille" : "'.$taille->nom.'" , "TypePain" : "' .$s->typepain. '" , "Prix" : "'.$taille->prix.'" } ,';
						} 

						$json = substr($json, 0, -1);
						
						$json .= '] } }';

						$arr = array('error' => 'Ok : '.$req->getUri());

						$resp = $resp->withStatus(200);

						return (new \lbs\view\lbsview($json))->render('getCommande', $req, $resp, $args );
				}
				else
				{
					$arr = array('error' => 'Token incorrect : '.$req->getUri());

					$resp = $resp->withStatus(400);

					return (new \lbs\view\lbsview($arr))->render('getCommande', $req, $resp, $args);
				}
			}
			else
			{
				$arr = array('error' => 'Token manquant : '.$req->getUri());

				$resp = $resp->withStatus(400);

				return (new \lbs\view\lbsview($arr))->render('getCommande', $req, $resp, $args);
			}
		} else {
			$arr = array('error' => 'Commande inexistante : '.$req->getUri());

			$resp = $resp->withStatus(404);

			return (new \lbs\view\lbsview($arr))->render('getCommande', $req, $resp, $args);
		}
	}
	

}