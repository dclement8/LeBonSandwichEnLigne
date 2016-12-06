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
		return $this->belongsToMany("\model\ingredient","contenir","id","id_ingredient");
	}
}