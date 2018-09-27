<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthsController extends Controller {

    const MODEL = "App\Models\User";

    // use RESTActions;

	public function login(Request $request)
    {
    	$this->validate($request, [
			'nik' => 'required|string|max:255',
			'pin' => 'required|string|min:6',
    	]);
		//$m = self::MODEL;
        $credentials = $request->only('nik');
		$credentials['password'] = $request->get('pin');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $this->validate($request, [
			'nik' => 'required|string|max:255|unique:tweb_penduduk_mandiri',
			'pin' => 'required|string|min:6',
    	]);
		$id_pend = \App\Models\Penduduk::select(['id'])->whereNik($request->get('nik'))->first();
		if(!$id_pend){
			$message = 'Nik tidak ditemukan';
			return response()->json(compact('message'));
		}
        $m = self::MODEL;
        $user = $m::create([
            'nik' => $request->get('nik'),
            'pin' => $m::hash_pin($request->get('pin')),
			'id_pend' => $id_pend->id
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

	        if (! $user = JWTAuth::parseToken()->authenticate()) {
	                return response()->json(['user_not_found'], 404);
	        }

		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

		    return response()->json(['token_expired'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

		    return response()->json(['token_invalid'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

		    return response()->json(['token_absent'], $e->getStatusCode());

		}

		return response()->json(compact('user'));
    }
}
