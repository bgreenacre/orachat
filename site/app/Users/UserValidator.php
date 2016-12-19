<?php namespace Ora\Chat\Users;

use Ora\Chat\Observers\EloquentValidatorObserver;

class UserValidator extends EloquentValidatorObserver {

    public function getRules($model)
    {
        return [
        	'name' => [
        		'required',
        		'max:255',
        		'unique:users,username,' . $model->id,
        	],
        	'email' => [
        		'required',
        		'max:255',
        		'email',
        		'unique:users,email,' . $model->id,
        	],
        	'password' => [
        		'required',
        		'max:255',
        	],
        ];
    }

}