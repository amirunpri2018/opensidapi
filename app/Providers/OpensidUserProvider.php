<?php
namespace App\Providers; 
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class OpensidUserProvider extends EloquentUserProvider{
	/**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $user->hash_pin($credentials['password']);
        $hashed = $user->getAuthPassword();

        if (strlen($hashed) === 0) {
            return false;
        }
		
        return $plain == $hashed;
    }
	
}