<?php

namespace Ora\Chat\Messages;

use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{

	/**
	 * Name of the table used in the schema.
	 * 
	 * @var string
	 */
	protected $table = 'messages';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'last_update',
    ];

    /**
     * Provides the reverse one to many relationship of
     * chat to messages.
     * 
     * @return $this
     */
	public function chat()
	{
		return $this->belongsTo('Ora\Chat\Chats\ChatModel', 'chats', 'chat_id');
	}

	/**
	 * Provides the reverse one to many relationship of
	 * user to messages.
	 * 
	 * @return $this
	 */
	public function user()
	{
		return $this->belongsTo('Ora\Chat\Users\UserModel', 'users', 'user_id');
	}

}
