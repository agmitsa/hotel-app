<?php
ini_set("display_errors", 0);

require __DIR__.'/../boot/boot.php';
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

//Search for room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId);

?>

<!DOCTYPE html> 
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">	
		<title>Hotels-Results Page</title>				
		<link href="assets/css/search-results.css" type="text/css" rel="stylesheet" />
		<link href="assets/css/list.css" type="text/css" rel="stylesheet" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>		
		<script src="assets/pages/search.js"></script>
		<link
		  rel="stylesheet"
		  href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
		/>	
		<link rel="icon" href="data:,">
	</head>
	
	<body>
	<body>

        <header>
            <div class="container">
				<p class="logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
						<li class='home'><a href="index.php"><i class='fas fa-home'></i>Home</a></li>	
						<li class="profile"><a href="profile-page.php"><i class='fas fa-user'></i>Profile</a></li>

                    </ul>
                </div>
				<div class="clear"></div>
				<div class="shadow-box"></div>								
            </div>
        </header>	
		<main>
			
			<aside class='left-section searchbox box'>
				<h1>FIND THE PERFECT HOTEL</h1>
				<div class='filters'>
					<form name='searchForm' class='searchForm' action='list.php'>
						<div class="form-group">
							<select id="formGuests" name='count_of_guests'>
								<option value="" disabled selected>Count of Guests</option>
							
							<?php 
								foreach ($countOfGuests as $guest) {																										
							?>
								<option value="<?php echo $guest; ?>"><?php echo $guest; ?>
								</option>
							<?php
								}
							?>							
							</select>
						</div>	
						<div class="form-group">
							<select id="formRoom" name='room_type'>
								<option disabled <?php echo $selectedTypeId == $roomType ? 'selected="selected"' : '' ?> value="<?php echo $roomType['type_id']; ?>">Room Type</option>							
							<?php 
								foreach ($allTypes as $roomType) {																										
							?>
								<option <?php echo $selectedTypeId == $roomType ? 'selected="selected"' : '' ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?>
								</option>
							<?php
								}
							?>							
							</select>
						</div>						
						<div class="form-group">
							<select id="formCity" name='city'>
								<option value="" disabled>City</option>							
							<?php 
								foreach ($cities as $city) {																										
							?>
								<option <?php echo $selectedCity == $city ? 'selected="selected"' : '' ?> value="<?php echo $city; ?>"><?php echo $city; ?></option>
							<?php
								}
							?>
							</select>
						</div>
						<div class='form-group formPrice'>
							<p>
							  <label for="amount" style='text-transform: uppercase; font-weight: 400; color: #908b8b;'>Price range:</label>
							  <input type="text" name='price' id="amount" readonly style="border:0; color:#f45111; font-weight:bold;">
							</p>
							 
							<div id="slider-range"></div>						
						</div>
						<br>
						<div class='form-group'>
							<input type="text" id="from" size="16" value='<?php echo $checkInDate?>' name='check_in_date' placeholder='Check in date'>
						</div>
						<div class='form-group'>
							<input type="text" id="to" size="16" value='<?php echo $checkOutDate?>' name='check_out_date' placeholder='Check out date'>
						</div>						
						<div class="action">
							<input type="submit" id="find-hotel" value='Find Hotel'>
						</div>					
					</form>				
				</div>
			</aside>
			<section class='main-section box'>
				<div class='page-title box'>
					<h2>Search results</h2>					
				</div>	

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
			</section>
		</main>
		<footer>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />
		<script src='./index.js'></script>
		<script>
			$( function() {
			$( "#slider-range" ).slider({
			  range: true,
			  min: 0,
			  max: 1000,
			  values: [ 75, 300 ],
			  slide: function( event, ui ) {
				$( "#amount" ).val( "€" + ui.values[ 0 ] + " - €" + ui.values[ 1 ] );
			  }
			});
			$( "#amount" ).val( "€" + $( "#slider-range" ).slider( "values", 0 ) +
			  " - €" + $( "#slider-range" ).slider( "values", 1 ) );
			} );		
		</script>		
	</body>
</html>