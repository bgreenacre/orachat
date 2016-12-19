<?php

namespace Ora\Chat\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{

	/**
	 * Name of the table used in the schema.
	 * 
	 * @var string
	 */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'updated_at', 'created_id'
    ];

    /**
     * Provides the one to many relationship for user to chats.
     * 
     * @return $this
     */
    public function chats()
    {
        return $this->hasMany('Ora\Chat\Chats\ChatModel', 'user_id');
    }

    /**
     * Provides the one to many relationship for user to messages.
     * 
     * @return $this
     */
    public function messages()
    {
    	return $this->hasMany('Ora\Chat\Messages\MessageModel', 'user_id');
    }

}
