<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Review;


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

//Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

//Return to room page
header(sprintf('Location: /public/room-page.php?room_id=%s', $roomId));
