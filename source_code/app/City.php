<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class City extends Model
{

	protected $table = 'vungmien';

	protected $primaryKey = 'id';
	public  $timestamps=false;

}
