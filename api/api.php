<?php

// Autoloaders

require_once("../vendor/autoload.php");

use \Psr\Http\Message\ServerRequestInterface as Request;

use \Psr\Http\Message\ResponseInterface as Response;

$configuration = [

	'settings' => [

		'displayErrorDetails' => true ]

];

$c = new\Slim\Container($configuration);

$app = new \Slim\App($c);



/**

 * @apiGroup Categories

 * @apiName detailsCategorie

 * @apiVersion 0.1.0

 *

 * @api {get} /categories/id  accès à une ressource catégorie

 *

 * @apiDescription Accès à une ressource de type catégorie permet d'accéder à la représentation de la ressource categorie désignée. Retourne une représentation json de la ressource.

 *

 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.

 *

 * @apiParam {Number} id Identifiant de la catégorie

 *

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie

 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie

 * @apiSuccess (Succès : 200) {String} description Description de la catégorie

 * @apiSuccess (Succès : 200) {Link} all Lien vers la de toutes les catégories

 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        categorie : {

 *            "id"  : 4 ,

 *            "nom" : "crudités",

 *            "description" : "nos salades et crudités fraiches et bio."

 *        },

 *        links : {

 *            "all" : { "href" : "/categories" },

 *            "ingredients" : { "href" : "/categories/4/ingredients" }

 *        }

 *     }

 *

 * @apiError (Erreur : 404) error Categorie inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource not found"

 *     }

 */

$app->get('/categories/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->detailsCategorie($req, $resp, $args);

	}

)->setName('detailsCategorie');



/**

 * @apiGroup Categories

 * @apiName toutesCategories

 * @apiVersion 0.1.0

 *

 * @api {get} /categories  accès à toutes les ressources catégories

 *

 * @apiDescription Accès à toutes les ressources de type catégorie. Retourne une représentation json.

 *

 *

  * @apiSuccess (Succès : 200) {Array} categories Toutes les catégories

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie

 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie

 * @apiSuccess (Succès : 200) {String} description Description de la catégorie

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        "categories" : [

 *			{

 *            	"id"  : 4 ,

 *            	"nom" : "crudités",

 *            	"description" : "nos salades et crudités fraiches et bio."

 *			},

 *			{

 *				"id"  : 5 ,

 *            	"nom" : "Sauces",

 *            	"description" : "Toutes les sauces du monde !"

 *			}

 *        ]

 *     }

 */

$app->get('/categories',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->toutesCategories($req, $resp, $args);

	}

)->setName('toutesCategories');



/**

 * @apiGroup Ingredients

 * @apiName detailsIngredient

 * @apiVersion 0.1.0

 *

 * @api {get} /categories/id  accès à une ressource ingrédient

 *

 * @apiDescription Accès à une ressource de type ingrédient permet d'accéder à la représentation de la ressource ingrédient désignée. Retourne une représentation json de la ressource.

 *

 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.

 *

 * @apiParam {Number} id Identifiant de la catégorie

 *

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie

 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie

 * @apiSuccess (Succès : 200) {String} description Description de la catégorie

 * @apiSuccess (Succès : 200) {Link} all Lien vers la de toutes les catégories

 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        categorie : {

 *            "id"  : 4 ,

 *            "nom" : "crudités",

 *            "description" : "nos salades et crudités fraiches et bio."

 *        },

 *        links : {

 *            "all" : { "href" : "/categories" },

 *            "ingredients" : { "href" : "/categories/4/ingredients" }

 *        }

 *     }

 *

 * @apiError (Erreur : 404) error Categorie inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource not found"

 *     }

 */

$app->get('/ingredients/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->detailsIngredient($req, $resp, $args);

	}

)->setName('detailsIngredient');



/**

 * @apiGroup Categories

 * @apiName detailsIngredient

 * @apiVersion 0.1.0

 *

 * @api {get} /categories/id  accès à une ressource ingrédient

 *

 * @apiDescription Accès à une ressource de type ingrédient permet d'accéder à la représentation de la ressource ingrédient désignée. Retourne une représentation json de la ressource.

 *

 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie ainsi qu'un autre lien pour voir toutes les catégories.

 *

 * @apiParam {Number} id Identifiant de la catégorie

 *

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie

 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie

 * @apiSuccess (Succès : 200) {String} description Description de la catégorie

 * @apiSuccess (Succès : 200) {Link} all Lien vers la liste de toutes les catégories

 * @apiSuccess (Succès : 200) {Link} ingredients Lien vers la liste d'ingrédients de la catégorie

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        categorie : {

 *            "id"  : 4 ,

 *            "nom" : "crudités",

 *            "description" : "nos salades et crudités fraiches et bio."

 *        },

 *        links : {

 *            "all" : { "href" : "/categories" },

 *            "ingredients" : { "href" : "/categories/4/ingredients" }

 *        }

 *     }

 *

 * @apiError (Erreur : 404) error Categorie inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource not found"

 *     }

 */

$app->get('/categories/{id}/ingredients',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->ingredientsCategorie($req, $resp, $args);

	}

)->setName('ingredientsCategorie');



/**

 * @apiGroup Ingredients

 * @apiName categorieIngredient

 * @apiVersion 0.1.0

 *

 * @api {get} /ingredients/id/categorie  accès à une ressource catégorie d'un ingrédient

 *

 * @apiDescription Accès à une ressource de type catégorie d'un ingrédient particulier. Retourne une représentation json de la ressource.

 *

 * Le résultat inclut un lien pour accéder aux détails de l'ingrédient

 *

 * @apiParam {Number} id Identifiant de l'ingredient

 *

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie

 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie

 * @apiSuccess (Succès : 200) {String} description Description de la catégorie

 * @apiSuccess (Succès : 200) {Link} details Lien vers les détails de l'ingrédient

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        categorie : {

 *			[

 *            "id"  : 1 ,

 *            "nom" : "salades",

 *            "description" : "Nos bonnes salades, fraichement livr\u00e9es par nos producteurs bios et locaux"

 *			]

 *        },

 *        links : {

 *            "details" : { "href" : "/ingredients/3" }

 *        }

 *     }

 *

 * @apiError (Erreur : 404) error Ingrédient inexistant

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource not found"

 *     }

 */

$app->get('/ingredients/{id}/categorie',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->categorieIngredient($req, $resp, $args);

	}

)->setName('categorieIngredient');



/**

 * @apiGroup Commandes

 * @apiName creerCommande

 * @apiVersion 0.1.0

 *

 * @api {post} /commandes  créer une ressource commande

 *

 * @apiDescription Créer une ressource commande. Retourne un token servant à identifier l'utilisateur ayant créé la commande ainsi que l'identifiant de la commande.

 *

 * Le résultat inclut un lien pour accéder aux détails de la commande créee

 *

 * @apiParam {String} json JSON des données servant à la création de la commande (Exemple : { "dateretrait" : "2000-01-01" , "montant" : 10 })

 *

 *

 * @apiSuccess (Succès : 201) {String} token Token d'identification de l'utilisateur ayant créé la commande

 * @apiSuccess (Succès : 201) {Number} id Identifiant de la commande

 * @apiSuccess (Succès : 201) {Link} view Lien vers les détails de la commande qui a été créee

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        commande : {

 *            "token"  : "xal0810z9u6dz7xowtkyt5yl1p3sfny3" ,

 *            "id" : 1

 *        },

 *        links : {

 *            "view" : { "href" : "/commandes/1" }

 *        }

 *     }

 *

 * @apiError (Erreur : 400) error Données manquantes ou incorrectes pour créer la commande.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "données manquantes ou incorrectes pour la création de la commande : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes"

 *     }

 */

$app->post('/commandes',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->creerCommande($req, $resp, $args);

	}

)->setName('creerCommande');



/**

 * @apiGroup Commandes

 * @apiName payerCommande

 * @apiVersion 0.1.0

 *

 * @api {post} /commandes/id  paye une commande

 *

 * @apiDescription Transmet les informations bancaires et retourne une représentation json de la commande.

 *

 * Seules les cartes Mastercard et Visa sont supportées !

 *

 * @apiParam {Number} id Identifiant de la commande

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 * @apiParam {String} json JSON des données servant au paiement de la commande (Exemple : { "typecarte" : "mastercard" , "numero" : "5442 3811 6727 0320" , "expire" : "3/2020", "code" : "157" })

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la commande

 * @apiSuccess (Succès : 200) {Date} dateretrait Date de retrait

 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande (1=créée, 2=payée, 3=en cours, 4=prête, 5=livrée)

 * @apiSuccess (Succès : 200) {String} token Token de la commande

 * @apiSuccess (Succès : 200) {Number} montant Montant de la commande

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *	{

 * 		"commande": {

 *    		"id": 1,

 *    		"dateretrait": "2017-12-12",

 *    		"etat": 1,

 *    		"token": "174086",

 *    		"montant": 0

 *  	}

 *	}

 *

 * @apiError (Erreur : 401) error Token exigé

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 401 Unauthorized

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1"

 *     }

 *

 * @apiError (Erreur : 404) error Commande inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource non trouvée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 403) error Mauvais token

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Pas de données transmises (données bancaires)

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "pas de données : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Commande déjà traitée (état > 2)

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "commande déjà traitée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Carte non supportée (seulement Visa et Mastercard accepté)

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "type de carte non supporté : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Numéro de carte incorrect

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "numéro de carte incorrect : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Carte expirée

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "carte expirée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Code de carte incorrect

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "code incorrect : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Données bancaires incomplètes

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "données bancaires incomplètes : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 */

$app->post('/commandes/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->payerCommande($req, $resp, $args);

	}

)->setName('payerCommande');



/**

 * @apiGroup Commandes

 * @apiName dateCommande

 * @apiVersion 0.1.0

 *

 * @api {post} /commandes/id/date  modifie la date de retrait d'une commande

 *

 * @apiDescription La modification est possible uniquement si la date est ultérieure à aujourd'hui. Retourne une représentation json de la commande.

 *

 * @apiParam {Number} id Identifiant de la commande

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 * @apiParam {Date} date Date de retrait (dans un format accepté par la fonction strtotime(), par exemple aaaa-mm-dd)

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la commande

 * @apiSuccess (Succès : 200) {Date} dateretrait Date de retrait

 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande

 * @apiSuccess (Succès : 200) {String} token Token de la commande

 * @apiSuccess (Succès : 200) {Number} montant Montant de la commande

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *	{

 * 		"commande": {

 *    		"id": 1,

 *    		"dateretrait": "2017-12-12",

 *    		"etat": 1,

 *    		"token": "174086",

 *    		"montant": 0

 *  	}

 *	}

 *

 * @apiError (Erreur : 401) error Token exigé

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 401 Unauthorized

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/2017-01-01"

 *     }

 *

 * @apiError (Erreur : 404) error Commande inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource non trouvée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/2017-01-01?token=174086"

 *     }

 *

 * @apiError (Erreur : 403) error Mauvais token

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/2017-01-01?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Date incorrecte

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "Date incorrecte : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/2017-01-01?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error Date dépassée

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "Date dépassée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/2017-01-01?token=174086"

 *     }

 */

$app->post('/commandes/{id}/{date}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->dateCommande($req, $resp, $args);

	}

)->setName('dateCommande');



/**

 * @apiGroup Commandes

 * @apiName etatCommande

 * @apiVersion 0.1.0

 *

 * @api {get} /commandes/id  retourne l'état d'une commande

 *

 * @apiDescription Retourne une représentation json de la commande.

 *

 * @apiParam {Number} id Identifiant de la commande

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 *

 * @apiSuccess (Succès : 200) {Number} id Identifiant de la commande

 * @apiSuccess (Succès : 200) {Date} dateretrait Date de retrait

 * @apiSuccess (Succès : 200) {Number} etat Etat de la commande (1=créée, 2=payée, 3=en cours, 4=prête, 5=livrée)

 * @apiSuccess (Succès : 200) {String} token Token de la commande

 * @apiSuccess (Succès : 200) {Number} montant Montant de la commande

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *	{

 * 		"commande": {

 *    		"id": 1,

 *    		"dateretrait": "2017-12-12",

 *    		"etat": 1,

 *    		"token": "174086",

 *    		"montant": 0

 *  	}

 *	}

 *

 * @apiError (Erreur : 401) error Token exigé

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 401 Unauthorized

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1"

 *     }

 *

 * @apiError (Erreur : 404) error Commande inexistante

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "ressource non trouvée : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 403) error Mauvais token

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1?token=174086"

 *     }

 */

$app->get('/commandes/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->etatCommande($req, $resp, $args);

	}

)->setName('etatCommande');



/**

 * @apiGroup Commandes

 * @apiName ajouterSandwich

 * @apiVersion 0.1.0

 *

 * @api {post} /commandes/id/sandwichs  ajouter un sandwich à une commande précise

 *

 * @apiDescription Créer une ressource sandwich et l'associe à une commande. Retourne l'id du sandwich créé.

 *

 * Le résultat inclut un lien pour accéder aux détails de la commande créee ainsi qu'un lien pour supprimer le sandwich.

 *

 * @apiParam {String} json JSON des données servant à la création du sandwich (Exemple : { "taillepain" : 1 , "typepain" : 1 , "ingredients" : [1, 3, 4, 9] })

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 *

 *

 * @apiSuccess (Succès : 201) {Number} sandwich Identifiant du sandwich créé

 * @apiSuccess (Succès : 201) {Link} view Lien vers les détails de la commande du sandwich et pour supprimer le sandwich.

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 201 OK

 *

 *     {

 *        sandwich :

 *            1

 *        ,

 *        links : {

 *            "details" : { "href" : "/commandes/1" },

 *			  "delete" : { "href" : "/sandwichs/1" }

 *        }

 *     }

 *

 * @apiError (Erreur : 400) error Données manquantes ou incorrectes pour créer le sandwich.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "données manquantes ou incorrectes pour la création de la commande : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/sandwichs"

 *     }

 *

 * @apiError (Erreur : 403) error La commande n'est plus modifiable en raison de son état.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "vous n\'êtes pas autorisé à modifier cette commande en raison de son état : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/sandwichs"

 *     }

 *

 * @apiError (Erreur : 403) error Le token de la commande entré est incorrect.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/sandwichs"

 *     }

 *

 * @apiError (Erreur : 403) error Token de la commande manquant.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/sandwichs"

 *     }

 *

 * @apiError (Erreur : 404) error La commande n'existe pas.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "commande inexistante : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/commandes/1/sandwichs"

 *     }

 */

$app->post('/commandes/{id}/sandwich',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->ajouterSandwich($req, $resp, $args);

	}

)->setName('ajouterSandwich');



/**

 * @apiGroup Sandwichs

 * @apiName supprimerSandwich

 * @apiVersion 0.1.0

 *

 * @api {delete} /sandwichs/id  supprime un sandwich

 *

 * @apiDescription Créer une ressource sandwich et l'associe à une commande. Retourne l'id de la commande.

 *

 * Le résultat inclut un lien pour accéder aux détails de la commande.

 *

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 *

 *

 * @apiSuccess (Succès : 200) {Number} commande Identifiant de la commande

 * @apiSuccess (Succès : 200) {Link} view Lien vers les détails de la commande du sandwich supprimé.

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *     {

 *        commande :

 *            1

 *        ,

 *        links : {

 *            "view" : { "href" : "/commandes/1" }

 *        }

 *     }

 *

 *

 * @apiError (Erreur : 403) error La commande n'est plus modifiable en raison de son état.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "impossible de modifier la commande : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/sandwichs/2"

 *     }

 *

 * @apiError (Erreur : 403) error Le token de la commande entré est incorrect.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/sandwichs/2"

 *     }

 *

 * @apiError (Erreur : 403) error Token de la commande manquant.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/sandwichs/2"

 *     }

 *

 * @apiError (Erreur : 404) error Le sandwich n'existe pas.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "sandwich inexistant : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/sandwichs/2"

 *     }

 */

$app->delete('/sandwichs/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->supprimerSandwich($req, $resp, $args);

	}

)->setName('supprimerSandwich');



/**

 * @apiGroup Sandwichs

 * @apiName modifierSandwich

 * @apiVersion 0.1.0

 *

 * @api {post} /sandwichs/id  modifie un sandwich

 *

 * @apiDescription Modifie une ressource sandwich associée à une commande. Retourne le sandwich

 *

 * Si l'état est à 1 (commande créée), on peut modifier le sandwich de A à Z (type pain + ingrédients + taille pain)

 * Si l'état est à 2 (commande payée), on peut modifier le sandwich à coût constant (type pain + ingrédients)

 * Sinon, modification impossible

 *

 * Le résultat inclut un lien pour accéder aux détails de la commande et un lien pour supprimer le sandwich.

 *

 * @apiParam {String} token Token généré identifiant la commande (Exemple : 8x936gi2o18uwecfk5vvqwwv3fhya8f1)

 * @apiParam {String} json JSON des données servant à la modification du sandwich (Exemple : { "taillepain" : 1 , "typepain" : 1 , "ingredients" : [1, 3, 4, 9] })

 *

 * @apiSuccess (Succès : 200) {Number} sandwich Identifiant du sandwich

 * @apiSuccess (Succès : 200) {Link} details Lien vers les détails de la commande du sandwich modifié.

 * @apiSuccess (Succès : 200) {Link} delete Lien pour supprimer sandwich modifié.

 *

 * @apiSuccessExample {json} exemple de réponse en cas de succès

 *     HTTP/1.1 200 OK

 *

 *	{

 *		"sandwich": 1,

 *		"links": {

 *			"details": {

 *				"href": "/commandes/174086"

 *			},

 *			"delete": {

 *				"href": "/sandwichs/1"

 *			}

 *		}

 *	}

 *

 *

 * @apiError (Erreur : 401) error Token de la commande manquant.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 401 Unauthorized

 *

 *     {

 *       "error" : "token exigé : http://localhost/lbs/publique/LeBonSandwichEnLigne/api/sandwichs/1"

 *     }

 *

 * @apiError (Erreur : 400) error Pas de données comportant les informations afin de modifier un sandwich.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error": "pas de données : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 403) error Le token de la commande entré est incorrect.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 403 Forbidden

 *

 *     {

 *       "error" : "mauvais token : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 404) error Le sandwich n'existe pas.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 404 Not Found

 *

 *     {

 *       "error" : "sandwich inexistant : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error L'id de la commande ne correspond pas à la commande du sandwich spécifié.

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "mauvais id : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error La commande a déjà été traitée (l'état est strictement supérieur à 2)

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "commande déjà traitée : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 *

 * @apiError (Erreur : 400) error La valeur de ingrédients n'est pas un tableau

 *

 * @apiErrorExample {json} exemple de réponse en cas d'erreur

 *     HTTP/1.1 400 Bad Request

 *

 *     {

 *       "error" : "la donnée ingrédient n'est pas un tableau : http://localhost/LeBonSandwichEnLigne/api/sandwichs/1?token=174086"

 *     }

 */

$app->post('/sandwichs/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->modifierSandwich($req, $resp, $args);

	}

)->setName('modifierSandwich');



$app->post('/carte',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->creerCarte($req, $resp, $args);

	}

)->setName('creerCarte');



$app->post('/carte/{id}',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->lireCarte($req, $resp, $args);

	}

)->setName('lireCarte');



$app->get('/carte',

	function (Request $req, Response $resp, $args)

	{

		return (new lbs\control\lbscontrol($this))->payerCarte($req, $resp, $args);

	}

)->setName('payerCarte');

$app->get('/facture/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->getFacture($req, $resp, $args);
	}
)->setName('getFacture');

$app->get('/suppCommande/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->suppCommande($req, $resp, $args);
	}
)->setName('suppCommande');

$app->get('/getCommande/{id}',
	function (Request $req, Response $resp, $args)
	{
		return (new lbs\control\lbscontrol($this))->getCommande($req, $resp, $args);
	}
)->setName('getCommande');

$app->run();