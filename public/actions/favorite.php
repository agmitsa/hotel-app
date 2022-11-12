<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Favorite;


if(strtolower($_SERVER['REQUEST_METHOD']) != 'post') 
{
	header('Location: /');
	return;
}

if (empty(User::getCurrentUserId())) {
	header('Location: /');
	
	return;
}

$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
	header('Location: /');
	
	return;
}

//Set room to favorites
$favorite = new Favorite();

$isFavorite = $_REQUEST['is_favorite'];

if (!$isFavorite) {
	$favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
	$favorite->removeFavorite($roomId, User::getCurrentUserId());
	
}

//Return to room page
header(sprintf('Location: /public/room-page.php?room_id=%s', $roomId));
