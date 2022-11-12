<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Favorite;


if(strtolower($_SERVER['REQUEST_METHOD']) != 'post') 
{
	die;
}

if (empty(User::getCurrentUserId())) {
	die;
}

$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
	die;
}

//Set room to favorites
$favorite = new Favorite();

$isFavorite = $_REQUEST['is_favorite'];
if (!$isFavorite) {
	$status = $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
	$status = $favorite->removeFavorite($roomId, User::getCurrentUserId());
	
}

//Return operation status
header('Content-Type: application/json');
echo json_encode([
	'status' => $status,
	'is_favorite' => !$isFavorite
]);