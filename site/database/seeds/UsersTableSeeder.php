<?php

use Illuminate\Database\Seeder;
use Ora\Chat\Users\UserModel;

class UsersTableSeeder extends Seeder
{

	protected $userModel;

	public function __construct(UserModel $model)
	{
		$this->userModel = $model;
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->userModel->create([
			'name'     => 'Tester',
			'email'    => 'tester@mail.com',
			'password' => bcrypt('abc123'),
    	]);
    }

}
