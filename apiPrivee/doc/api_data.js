define({ "api": [
  {
    "group": "Commandes",
    "name": "changementEtat",
    "version": "0.1.0",
    "type": "post",
    "url": "/commandes/id",
    "title": "change l'état d'une commande",
    "description": "<p>Retourne une représentation json de l'état de la commande et le lien pour visualiser la commande.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "etat",
            "description": "<p>Etat de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Link",
            "optional": false,
            "field": "details",
            "description": "<p>Lien pour afficher les détails de la commande</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n\t{\n\t\t\"etat\": { 2 },\n\t\t\"links\": {\n\t\t\t\"details\": {\n\t\t\t\t\"href\": \"/commandes/2\"\n\t\t\t}\n\t\t}\n\t}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "error",
            "description": "<p>Commande inexistante</p>"
          }
        ],
        "Erreur : 400": [
          {
            "group": "Erreur : 400",
            "optional": false,
            "field": "error",
            "description": "<p>Etat incorrect</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"error\" : \"commande introuvable : http://localhost/lbsprive/api/commandes/10\"\n}",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n\n{\n  \"error\" : \"état incorrect: http://localhost/lbsprive/api/commandes/10\"\n}",
          "type": "json"
        },
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 400 Bad Request\n\n{\n  \"error\" : \"on ne peut pas rétrograder l'état d'une commande: http://localhost/lbsprive/api/commandes/10\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "././/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "detailsCommande",
    "version": "0.1.0",
    "type": "get",
    "url": "/commandes/id",
    "title": "retourne le détail d'une commande",
    "description": "<p>Retourne une représentation json de la commande et les liens pour visualiser la commande ou toutes les commandes.</p>",
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Date",
            "optional": false,
            "field": "dateretrait",
            "description": "<p>Date de retrait</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "etat",
            "description": "<p>Etat de la commande (1=créée, 2=payée, 3=en cours, 4=prête, 5=livrée)</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "montant",
            "description": "<p>Montant de la commande</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n\t{\n\t\t\"commande\": {\n\t\t\t\"id\": 2,\n\t\t\t\"dateretrait\": \"2017-01-24\",\n\t\t\t\"etat\": 1,\n\t\t\t\"token\": \"174086\",\n\t\t\t\"montant\": 0\n\t\t},\n\t\t\"links\": {\n\t\t\t\"all\": {\n\t\t\t\t\"href\": \"/commandes\"\n\t\t\t},\n\t\t\t\"sandwichs\": {\n\t\t\t\t\"href\": \"/commandes/2/sandwich\"\n\t\t\t}\n\t\t}\n\t}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Erreur : 404": [
          {
            "group": "Erreur : 404",
            "optional": false,
            "field": "RessourceNotFound",
            "description": "<p>Commande inexistante</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas d'erreur",
          "content": "HTTP/1.1 404 Not Found\n\n{\n  \"error\" : \"ressource not found : http://localhost/lbsprive/api/commandes/10\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "././/api.php",
    "groupTitle": "Commandes"
  },
  {
    "group": "Commandes",
    "name": "toutesCommandes",
    "version": "0.1.0",
    "type": "get",
    "url": "/commandes",
    "title": "accès à des ressources commandes",
    "description": "<p>Retourne un tableau contenant une représentation json de chaque commande.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<p>Nombre d'éléments à afficher</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "offset",
            "description": "<p>Pagination</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "etat",
            "description": "<p>Filtrage sur l'état</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "date",
            "description": "<p>Filtrage sur la date de retrait (format yyyy-mm-dd)</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Succès : 200": [
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>Identifiant de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Date",
            "optional": false,
            "field": "dateretrait",
            "description": "<p>Date de retrait de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Number",
            "optional": false,
            "field": "etat",
            "description": "<p>Etat de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "String",
            "optional": false,
            "field": "montant",
            "description": "<p>Montant de la commande</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Link",
            "optional": false,
            "field": "all",
            "description": "<p>Lien pour afficher toutes les commandes</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Link",
            "optional": false,
            "field": "previous",
            "description": "<p>Lien pour afficher les commandes précédentes</p>"
          },
          {
            "group": "Succès : 200",
            "type": "Link",
            "optional": false,
            "field": "next",
            "description": "<p>Lien pour afficher les commandes suivantes</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "exemple de réponse en cas de succès",
          "content": "    HTTP/1.1 200 OK\n\n\t{\n\t\t\"commandes\" :\n\t\t[\n\t\t\t{\n\t\t\t\t\"id\": 1,\n\t\t\t\t\"dateretrait\": \"2017-01-04\",\n\t\t\t\t\"etat\": 1,\n\t\t\t\t\"token\": 1546425,\n\t\t\t\t\"montant\": 0\n\t\t\t},\n\t\t\t{\n\t\t\t\t\"id\": 2,\n\t\t\t\t\"dateretrait\": \"2017-01-24\",\n\t\t\t\t\"etat\": 1,\n\t\t\t\t\"token\": \"174086\",\n\t\t\t\t\"montant\": 0\n\t\t\t}\n\t\t],\n\t\t\"links\" :\n\t\t{\n\t \t\t\"all\" : { \"href\" : \"/commandes\" },\n\t\t\t\"previous\" : { \"href\" : \"/commandes?limit=20&offset=0\" },\n\t\t\t\"next\" : { \"href\" : \"/commandes?limit=20&offset=20\" }\n\t\t}\n\t}",
          "type": "json"
        }
      ]
    },
    "filename": "././/api.php",
    "groupTitle": "Commandes"
  }
] });
