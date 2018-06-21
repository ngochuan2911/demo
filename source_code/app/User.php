<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'fullname', 'email','password','level','sodienthoai','id_thanhpho','remember_token'];
    protected $hidden = ['password'];
    public  $timestamps=false;

}
