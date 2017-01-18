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

	public function sandwichCommande()
	{
		return $this->belongsTo("\lbs\model\commande","id");
	}

	//BelongsTo
}