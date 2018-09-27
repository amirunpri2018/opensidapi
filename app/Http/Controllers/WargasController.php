<?php namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\ProgramPeserta as Peserta;
use App\Models\LogSurat as LogSurat;
use App\Models\Komentar as Komentar;
class WargasController extends Controller {
    const MODEL = "App\Models\warga";
	use RESTActions{
		get as getTrait;
	}
	
	public function profil(){
		return $this->get(JWTAuth::user()->id_pend);	
	}
	/* kita override function getnya karena perlu info tambahan*/
	public function get($id){
		$m = self::MODEL;
        $model = $m::find($id);
        if(is_null($model)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $model);
	}
	
	public function bantuan(){
        $model = Peserta::select()->wherePeserta(JWTAuth::user()->nik)->with('programs')->get();
        if(is_null($model)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $model);
	}
	
	public function layanan(){
        $model = LogSurat::whereIdPend(JWTAuth::user()->id_pend)->lengkap()->get();
        if(is_null($model)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $model);
	}
	
	public function lapor(Request $request){
		$this->validate($request, [
			'komentar' => 'required|string|min:10',
    	]);
		$komentar = new Komentar();
		$komentar->email = JWTAuth::user()->nik;
		$komentar->komentar = $request->get('komentar');
		$komentar->id_artikel = 775;
        
        if(!$komentar->save()){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, ['pesan' => 'Laporan telah diterima ']);
	}
	
}
