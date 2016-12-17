<?php

namespace Ora\Chat\Http\Controllers;

use Illuminate\Http\Request;
use Ora\Chat\Chats\ChatModel;

class ChatsController extends Controller
{

	protected $chatModel;

	public function __construct(ChatModel $chatModel)
	{
		$this->chatModel = $chatModel;
		
		parent::boot();
	}

	public function list(Request $request)
	{
		$chats = $this->chatModel
		    ->with('user', function($query) use ($userId)
			{
				$query->where('id', $userId);
			})
			->get();
	}

	public function create(Request $request)
	{
		//
	}

}
