<?php
use Hotel\User;

require_once __DIR__.'/../../boot/boot.php';

if(strtolower($_SERVER['REQUEST_METHOD']) != 'post') 
{
	header('Location: /');
	return;
}

$user = new User();

try{
	if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
		header('Location: /public/login.php?error=Could not verify user');
		
		return;
	}
} catch (InvalidArgumentException $ex) {
	header('Location: public/login.php?error=No user exists with the given email');
	
	return;
}


$userInfo = $user->getByEmail($_REQUEST['email']);

$token = $user->getUserToken($userInfo['user_id']);

setcookie('user_token', $token, time() + (30*24*60*60), '/');

header('Location: /public/index.php');

