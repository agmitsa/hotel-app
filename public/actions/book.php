<?php

require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;
use Hotel\Booking;


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

//Create new booking
$booking = new Booking();

$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$booking->insert($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);

//Return to room page
header(sprintf('Location: /public/room-page.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkInDate, $checkOutDate));
