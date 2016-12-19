<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Http\Request;
use Ora\Chat\Chats\ChatModel;
use Tymon\JWTAuth\JWTAuth;

class ChatsController extends Controller
{

	protected $chatModel;
	protected $auth;

	public function __construct(ChatModel $chatModel, JWTAuth $auth)
	{
		$this->chatModel = $chatModel;
		$this->auth      = $auth;
	}

	public function list(Request $request)
	{
		$chats = $this->chatModel
		    ->with('user', function($query) use ($userId)
			{
				$query->where('id', $userId);
			});

		if ($query = $request->input('q'))
		{
			$chats->where('name', 'LIKE', $query);
		}

		$chats = $chats->paginate($request->input('limit'));

		$payload = $chats->toArray();

		return response()->payload($payload);
	}

	public function create(Request $request)
	{
        if ( ! $user = $this->auth->parseToken()->authenticate()) {
            return response()->payload(['error' => 'user_not_found'], false, 404);
        }

        $chat = $user->chats()->create($request->all());

        $payload = $chat->toArray();
        $payload['last_message'] = null;

        return response()->payload($payload);
	}

}
