<?php
namespace lbs\model;

class commande extends \Illuminate\Database\Eloquent\Model
{
	// Database
	protected $table = 'commande';
	protected $primaryKey = 'id';
	
	public $timestamps = false;


	public function categorieIngredient()
	{
		return $this->hasMany("\lbs\model\sandwich","id");
	}

}



