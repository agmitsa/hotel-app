<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;

class Room extends BaseService
{
	public function get($roomId) {
		$parameters = [
			':room_id' => $roomId,
		];
		return $this->fetch('SELECT room.*, room_type.title as room_type
		FROM room 
		INNER JOIN room_type ON room.type_id = room_type.type_id		
		WHERE room_id= :room_id', $parameters);		
	}
	
	public function getCities() {

		//Get cities
		$cities=[];		
		try {
			$rows = $this->fetchAll('SELECT DISTINCT city FROM room'); 
			foreach ($rows as $row) {
				$cities[] = $row['city'];
			}
		} catch (Exception $ex) {
			
		}
		
		return $cities;
	}
	public function getGuests() {

		//Get cities
		$rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room'); 
		$countOfGuests=[];
		foreach ($rows as $row) {
			$countOfGuests[] = $row['count_of_guests'];
		}
		return $countOfGuests;
	}	
	
	public function search($checkInDate, $checkOutDate, $city='', $typeId='', $countOfGuests= NULL, $min= NULL, $max= NULL) {
		
		$parameters = [
			':check_in_date' => $checkInDate->format(\DateTime::ATOM),
			':check_out_date' => $checkOutDate->format(\DateTime::ATOM)			
		];
		if (!empty($city)) {
			$parameters[':city'] = $city;
		}
		if (!empty($typeId)) {
			$parameters[':type_id'] = $typeId;
		}
		if (!empty($countOfGuests)) {
			$parameters[':count_of_guests'] = $countOfGuests;
		}		
		if (!empty($min) && !empty($max)) {
			$parameters[':min'] = $min;
			$parameters[':max'] = $max;

		}	
		//Build query
		$sql = 'SELECT room.*, room_type.title as room_type
		FROM room 
		INNER JOIN room_type ON room.type_id = room_type.type_id
		WHERE ';
		if (!empty($city)) {
			$sql .= 'city = :city AND ';
		}	
		if (!empty($typeId)) {
			$sql .= 'room.type_id=:type_id AND ';

		}
		if (!empty($countOfGuests)) {
			$sql .= 'count_of_guests=:count_of_guests AND ';
		}				
		if (!empty($min) && !empty($max)) {
			$sql .='price BETWEEN :min AND :max AND ';
		}		
		$sql .= 'room_id NOT IN (
			SELECT room_id
			FROM booking
			WHERE check_in_date <= :check_out_date OR check_out_date >= :check_in_date
		)';
		return $this->fetchAll($sql, $parameters);
	}
}