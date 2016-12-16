<?php

use Illuminate\Database\Seeder;
use Ora\Chat\Chats\ChatModel;
use Ora\Chat\Users\UserModel;

class ChatsTableSeeder extends Seeder
{

	protected $chatModel;
	protected $userModel;

	public function __construct(ChatModel $chatModel, UserModel $userModel)
	{
		$this->chatModel = $chatModel;
		$this->userModel = $userModel;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = $this->userModel
    	    ->newQuery()
    		->where('email', 'tester@mail.com')
    		->firstOrFail();

    	$user->chats()->create([
    		'name' => "Tester's chat",
    	]);
    }

}
