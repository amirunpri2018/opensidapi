<?php namespace App\Models;

class Admin extends Opensid {
	protected $table = 'user';
    protected $fillable = [];

    protected $hidden = ['username','password'];

}
