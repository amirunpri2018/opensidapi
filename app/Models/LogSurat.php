<?php namespace App\Models;

class LogSurat extends Opensid {
	protected $table = 'log_surat';
    protected $fillable = [];
	
    
	public function suratFormat(){
		return $this->belongsTo('App\models\SuratFormat','id_format_surat','id');
	}
	
	public function desaPamong(){
		return $this->belongsTo('App\models\DesaPamong','id_pamong','pamong_id');
	}
	
	public function admin(){
		return $this->belongsTo('App\models\Admin','id_user','id');
	}
	
	public function scopeLengkap(){
		return $this->with(['suratFormat' => function($q){
			return $q->select(['id','nama']);
		},'desaPamong' => function($r){
			return $r->select(['pamong_id','pamong_nama']);
		},'admin' => function($s){
			return $s->select(['id','nama']);
		}]);
	}
}
