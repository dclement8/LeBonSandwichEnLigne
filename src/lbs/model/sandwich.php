<?php
namespace lbs\model;

class sandwich extends \Illuminate\Database\Eloquent\Model
{
	// Database
	protected $table = 'sandwich';
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	// contenir
	public function ingredientsSandwich()
	{
		return $this->belongsToMany("\lbs\model\ingredient","contenir","id_sandwich","id_ingredient");
	}
<<<<<<< HEAD

	public function sandwichCommande()
	{
		return $this->belongsTo("\lbs\model\commande","id");
	}

	//BelongsTo
=======
	
	// sandwich vers commande
	public function commande()
	{
		return $this->belongsTo('\lbs\model\commande', "id_commande");
	}
	
	// sandwich vers taille
	public function taille()
	{
		return $this->belongsTo('\lbs\model\taille', "taillepain");
	}
>>>>>>> refs/remotes/origin/master
}