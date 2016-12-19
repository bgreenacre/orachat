<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Ora\Chat\Users\UserModel;

class UsersController extends Controller
{

	protected $auth;
	protected $userModel;

	public function __construct(JWTAuth $auth, UserModel $userModel)
	{
		$this->auth = $auth;
		$this->userModel = $userModel;
	}

	public function me(Request $request)
	{
        if ( ! $user = $this->auth->parseToken()->authenticate()) {
            return response()->payload(['error' => 'user_not_found'], false, 404);
        }

	    $user = $user->toArray();
	    $user['token'] = $this->auth->getToken();

	    // the token is valid and we have found the user via the sub claim
	    return response()->payload($user);
	}

	public function edit(Request $request)
	{
        if ( ! $user = $this->auth->parseToken()->authenticate()) {
            return response()->payload(['error' => 'user_not_found'], false, 404);
        }

		$user = $this->userModel
			->update($request->all());

		$user = $user->toArray();
		$user['token'] = $token;

		return response()->payload($user, true, 201);
	}

	public function register(Request $request)
	{
		echo '3333';exit;
		$user = $this->userModel
			->create($request->all());

		$token = $this->auth->fromUser($user);
		$user = $user->toArray();
		$user['token'] = $token;

		return response()->payload($user, true, 201);
	}

	public function login(Request $request)
	{
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if ( ! $token = $this->auth->attempt($credentials)) {
                return response()->payload(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->payload(['error' => 'could_not_create_token'], 500);
        }

        $user = $this->auth->toUser($token)->toArray();
        $user['token'] = $token;

        // all good so return the token
        return response()->payload($user);
	}

}
