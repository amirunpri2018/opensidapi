<?php namespace App\Models;

class Komentar extends Opensid {
	protected $table = 'komentar';
	const CREATED_AT = 'tgl_upload';
	const UPDATED_AT = NULL;
	public $timestamps = true;
    protected $fillable = [];
	
	public function email(){
		return $this->belongsTo('App\models\Warga','email','nik');
	}
	
	public function setEmailAttribute($email){
		/* jika email adalah nik, maka set owner dengan nama penduduk */
		$penduduk = Warga::whereNik($email)->first();
		if($penduduk){
			$this->owner = $penduduk->nama;	
		}
		$this->attributes['email'] = $email;
	}
}
