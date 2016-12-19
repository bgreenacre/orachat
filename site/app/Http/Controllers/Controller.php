<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tymon\JWTAuth\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// somewhere in your controller
	public function getAuthenticatedUser()
	{
		$auth = app()->make(JWTAuth::class);

	    try {
	        if ( ! $user = $auth->parseToken()->authenticate()) {
	            return response()->payload(['error' => 'user_not_found'], false, 404);
	        }

	    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

	        return response()->payload(['error' => 'token_expired'], false, $e->getStatusCode());

	    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

	        return response()->paylod(['error' => 'token_invalid'], false, $e->getStatusCode());

	    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

	        return response()->payload(['error' => 'token_absent'], false, $e->getStatusCode());

	    }

	    // the token is valid and we have found the user via the sub claim
	    return response()->payload(compact('user'));
	}

}
