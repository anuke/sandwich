<?php

class UserProfile extends AppModel 
{
	public $userTable = 'user_profiles';
	public $belongsTo = array('Users');
}