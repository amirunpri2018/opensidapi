<?php namespace App\models;

class ProgramPeserta extends Opensid {
    protected $table = 'program_peserta';
	/* dapatkan program bantuan yang dimiliki warga*/
	public function programs(){
		return $this->belongsTo('App\models\Program','program_id','id');
	}

}
