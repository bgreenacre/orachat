<?php

namespace Ora\Chat\Users;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{

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
        'password', 'remember_token',
    ];

    public function chats()
    {
        return $this->hasMany('Ora\Chat\Chats\ChatModel', 'chats', 'user_id');
    }

    public function messages()
    {
    	return $this->hasMany('Ora\Chat\Messages\MessageModel', 'messages', 'user_id');
    }

}
