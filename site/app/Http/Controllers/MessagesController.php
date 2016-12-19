<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Ora\Chat\Chats\ChatModel;
use Ora\Chat\Messages\MessageModel;

class MessagesController extends Controller
{

	protected $chatModel;
	protected $messageModel;
	protected $auth;

	public function __construct(ChatModel $chatModel, MessageModel $messageModel, JWTAuth $auth)
	{
		$this->chatModel    = $chatModel;
		$this->messageModel = $messageModel;
		$this->auth         = $auth;
	}

	public function list(Request $request)
	{
		//
	}

	public function create(Request $request, $chatId)
	{
        if ( ! $user = $this->auth->parseToken()->authenticate()) {
            return response()->payload(['error' => 'user_not_found'], false, 404);
        }

        $chat = $this->chatModel->findOrFail($chatId);

        $message = clone $this->messageModel;

        $message->message = $request->input('message');

        $message->user()->associate($user);
        $message->chat()->associate($chat);

        $message->save();

        $payload = $message->toArray();

        return response()->payload($payload);
	}

}
