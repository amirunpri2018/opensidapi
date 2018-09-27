<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class User extends Opensid implements AuthenticatableContract, AuthorizableContract,JWTSubject
{
    use Authenticatable, Authorizable;
    protected $table = 'tweb_penduduk_mandiri';
    protected $primaryKey = "id_pend";
    const CREATED_AT = "tanggal_buat";
	const UPDATED_AT = "last_login";
	protected $password = 'pin';
   // protected $date = ['tanggal_buat','last_login'];
   public $incrementing = false;
   public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik', 'pin','id_pend'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'pin',
    ];
	
	public static function hash_pin($pin=""){
		$pin = strrev($pin);
		$pin = $pin*77;
		$pin .= "!#@$#%";
		$pin = md5($pin);
		return $pin;
	}
	
	
    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pin;
    }
	
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }



    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }
}
