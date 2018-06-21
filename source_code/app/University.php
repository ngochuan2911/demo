<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class University extends Model
{

	protected $table = 'truong';

	protected $primaryKey = 'id';
	
	public $timestamps=false;

}
