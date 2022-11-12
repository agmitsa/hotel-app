<?php
ini_set('display_errors', 0);
// Register autoload function
spl_autoload_register(function ($class) {
	$class = str_replace("\\", "/", $class);
    require_once sprintf(__DIR__.'/../app/%s.php', $class);
});

use Hotel\User;

$user = new User();

//check if there is a token in request

$userToken = $_COOKIE['user_token'];
if ($userToken) {
	//Verify user
	if ($user->verifyToken($userToken)) {
	//set user in memory
		$userInfo = $user->getTokenPayload($userToken);
		User::setCurrentUserId($userInfo['user_id']);

	}
}

