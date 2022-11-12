<?php
ini_set("display_errors", 0);
require __DIR__.'/../../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
//use DateTime;

//Initizalize Room Service
$room = new Room();
$type = new RoomType();

//Get all cities
$cities = $room->getCities();
$allTypes = $type->getAllTypes();
$countOfGuests = $room->getGuests();
//Get page parameters
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$selectedCountOfGuests = $_REQUEST['count_of_guests'];
$priceRange = $_REQUEST['price'];
//Get Price Range input in "$$$ - $$$" format and convert it into two integers (min and max prices)
$priceValues = explode('-', $priceRange);
$selectedMinPrice = intval(substr($priceValues[0], 3));
$selectedMaxPrice = intval(substr($priceValues[1], 4));

//Search for room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedCountOfGuests, $selectedMinPrice, $selectedMaxPrice);
?>

<div class='search-results'>					
	<?php 
		foreach ($allAvailableRooms as $availableRoom) {																										
	?>
	<article class='list-element'>
		<div class='hotel-img'>
			<img src='assets/images/rooms/<?php echo $availableRoom['photo_url']?>'/>
		</div>					
		<div class='small-description'>
			<h1><?php echo $availableRoom['name']?></h1>
			<h2><?php echo $availableRoom['area']?>, <?php echo $availableRoom['city']?></h2>
			<p><?php echo $availableRoom['description_short']?></p>		
			<form action='room-page.php'>
				<input type='hidden' name='room_id' value='<?php echo $availableRoom['room_id']?>'>
				<input type='hidden' name='check_in_date' value='<?php echo $checkInDate?>'>					
				<input type='hidden' name='check_out_date' value='<?php echo $checkOutDate?>'>										
				<button class='action' type='submit'>Go to Room page</button>								
			</form>							
		</div>
		<div class='price' id='per-night'>Per night: <?php echo $availableRoom['price']?></div>
		<div class='room-info'>
			<div id='guestCounter'>Count of Guests: <?php echo $availableRoom['count_of_guests']?></div>
			<div id='room-type'>Room type: <?php echo $availableRoom['room_type']?></div>
		</div>	
		<div class="clear"></div>
	</article>	
	<?php
		}
	?>					

	<?php
		if (count($allAvailableRooms) == 0) {
	?>
		<h2 class='check-seacrh'>There are no rooms available!</h2>
	<?php
		}
	?>
</div>				
