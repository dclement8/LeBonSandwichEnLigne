<?php
namespace lbs\model;

class ingredient extends \Illuminate\Database\Eloquent\Model
{
	// Database
	protected $table = 'ingredient';
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	// contenir
	public function sandwichsIngredient()
	{
		return $this->belongsToMany("\lbs\model\sandwich","contenir","id_ingredient","id");
	}
	
	// catégorie de l'ingredient
	public function categorieIngredient()
	{
		return $this->belongsTo("\lbs\model\categorie","cat_id");
	}
}