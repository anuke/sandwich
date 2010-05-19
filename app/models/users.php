<?php

class Users extends AppModel 
{
	public $hasOne = array('UserProfile');
	public $hasMany = array('Photos');
}