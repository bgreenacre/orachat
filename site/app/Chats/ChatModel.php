<?php

namespace Ora\Chat\Chats;

use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{

	/**
	 * Name of the table used in the schema.
	 * 
	 * @var string
	 */
	protected $table = 'chats';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'last_update',
    ];

    /**
     * Provides the one to many relationship of
     * chat to messages.
     * 
     * @return $this
     */
	public function messages()
	{
		return $this->hasMany('Ora\Chat\Messages\MessageModel', 'messages', 'chat_id');
	}

	/**
	 * Provides the reverse one to many relationship of
	 * user to chats.
	 * 
	 * @return $this
	 */
	public function user()
	{
		return $this->belongsTo('Ora\Chat\Users\UserModel', 'users', 'user_id');
	}

}
