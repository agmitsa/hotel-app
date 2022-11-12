<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;
use DateTime;

class Booking extends BaseService
{
	public function insert($roomId, $userId, $checkInDate, $checkOutDate) {
		
		//Step 1. Begin transaction
		$this->getPdo()->beginTransaction();
		
		//Step 2. Get room Info
		$parameters = [
			':room_id' => $roomId,
		];
		$roomInfo = $this->fetch('SELECT * FROM room WHERE room_id= :room_id', $parameters);		
		$price = $roomInfo['price'];
		
		//Calculate final price
		$checkInDateTime = new DateTime($checkInDate);
		$checkOutDateTime = new DateTime($checkOutDate);
		$daysDiff = $checkOutDateTime->diff($checkInDateTime)->days;
		$totalPrice = $price * $daysDiff;
		
		//Book Room
		$parameters = [
			':room_id' => $roomId,
			':user_id' => $userId,
			':check_in_date' => $checkInDate,
			':check_out_date' => $checkOutDate,
			':total_price' => $totalPrice
		];
		$this->execute('INSERT INTO booking (room_id, user_id, check_in_date, check_out_date, total_price) 
		VALUES (:room_id, :user_id, :check_in_date, :check_out_date, :total_price)', $parameters);		
	
		return $this->getPdo()->commit();
	}
	public function isBooked($roomId, $checkInDate, $checkOutDate) {
		$parameters = [
			':room_id' => $roomId,
			':check_in_date' => $checkInDate,
			':check_out_date' => $checkOutDate			
		];
		$rows = $this->fetchAll('SELECT room_id
			FROM booking
			WHERE room_id=:room_id AND check_in_date <= :check_out_date AND check_out_date >= :check_in_date', 
			$parameters);	
		

		return count($rows) > 0;
	}
	
	public function getBookingsByUser($userId) {
		$parameters = [
			':user_id' => $userId
		];
		
		return $this->fetchAll('SELECT booking.*, room.name, room.photo_url, room.count_of_guests, room.city, room.area, room.description_short, room_type.title as room_type 
		FROM booking 
		INNER JOIN room ON booking.room_id = room.room_id
		INNER JOIN room_type ON room.type_id = room_type.type_id		
		WHERE user_id= :user_id', $parameters);		
		
	}
}