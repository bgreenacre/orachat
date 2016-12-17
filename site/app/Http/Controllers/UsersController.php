<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UsersController extends Controller
{

	protected $auth;

	public function __construct(JWTAuth $auth)
	{
		$this->auth = $auth;
	}

	public function me(Request $request)
	{
		//
	}

	public function edit(Request $request)
	{
		//
	}

	public function register(Request $request)
	{
		//
	}

	public function login(Request $request)
	{
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $this->auth->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
	}

}
