<?php
namespace lbs\model;

class ingredient extends \Illuminate\Database\Eloquent\Model
{
	// Database
	protected $table = 'ingredient';
	protected $primaryKey = 'id';
	
	public $timestamps = false;
}