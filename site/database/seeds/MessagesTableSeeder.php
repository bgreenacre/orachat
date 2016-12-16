<?php

use Illuminate\Database\Seeder;
use Ora\Chat\Users\UserModel;
use Ora\Chat\Chats\ChatModel;
use Ora\Chat\Messages\MessageModel;

class MessagesTableSeeder extends Seeder
{

	protected $userModel;
	protected $chatModel;
	protected $messageModel;

	public function __construct(UserModel $userModel, ChatModel $chatModel, MessageModel $messageModel)
	{
		$this->userModel = $userModel;
		$this->chatModel = $chatModel;
		$this->messageModel = $messageModel;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = $this->userModel->newQuery()
    		->where('email', 'tester@mail.com')
    		->firstOrFail();

    	$chat = $this->chatModel->newQuery()
    		->with([
    			'user' => function($query) use ($user)
	    		{
	    			$query->where('id', $user->id);
	    		},
	    	])
	    	->firstOrFail();

	    $message = clone $this->messageModel;

	    $message->message = 'This is an example chat message.';

	    $message->user()->associate($user);
	    $message->chat()->associate($chat);

	    $message->save();
    }
}
