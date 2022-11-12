<?php

require __DIR__.'/../boot/boot.php';

header('Access-Control-Allow-Origin: collegelink.gr');

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

$room = new Room();
$favorite = new Favorite();

$roomId = $_REQUEST['room_id'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

$alreadyBooked = empty($checkInDate) || empty($checkOutDate);
//Check for room id
if (empty($roomId)) {
	header('Location: index.php');
	return;
}

if (!$alreadyBooked) {
	//Look for bookings
	$booking = new Booking();
	$alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}

//Load room info
$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
	header('Location: index.php');
	return;
}

//Get latitude and longitude for Google Maps API
$lat = $roomInfo['location_lat'];
$long = $roomInfo['location_long'];

//Get current user id
$userId = User::getCurrentUserId();
//Check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);

$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex,nofollow">
		<title>Hotels-Room Page</title>		
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link href="assets/css/room-page.css" type="text/css" rel="stylesheet" />		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">		
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="assets/pages/room.js"></script>		
		<style>
		  #map {
			height: 400px;  
			width: 100%;  
		   }
		</style>	
	</head>
	
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
			<section class='page-title description box'>
				<div class='text-left'>
					<div class='hotel-name'><?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?></div>
					<div class='stars-reviews'><p>Reviews:</p>
						<?php 
							$roomAvgReview = $roomInfo['avg_reviews'];
							for ($i = 1; $i <= 5; $i++) {
								if($roomAvgReview >= $i) {
									?>
									<span><i class='fas fa-star star-1' style='color: #ff9b00'></i></span>
									
									<?php
								} else {
									?>
									
									<span><i class='fas fa-star star-1'></i></span>
									<?php
								}
							}
						?>
					</div>
					<div class='favorite' style='padding:0'>
						<form name="favoriteForm" method='post' id='favoriteForm' class='favoriteForm' action='actions/favorite.php'>
							<input type='hidden' name='room_id' value='<?php echo $roomId;?>'>
							<input type='hidden' name='is_favorite' value='<?php echo $isFavorite ? 1 : 0; ?>'>
							<button type='submit' class='favorite-btn'>
								<i class="<?php echo $isFavorite ? 'fas' : 'far'?> fa-heart"></i>
							</button>
						</form>
					</div>
				</div>	
				<div class='text-right perNight'><p>Per Night:</p> <?php echo $roomInfo['price'];?> €</div>
			</section>
			
			<section class='image-container'>
				<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
					<div class="carousel-item active">
					  <img class="d-block w-100" src="assets/images/rooms/<?php echo $roomInfo['photo_url']?>" alt="First slide">
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="assets/images/rooms/<?php echo $roomInfo['photo_url']?>" alt="Second slide">
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="assets/images/rooms/<?php echo $roomInfo['photo_url']?>" alt="Third slide">
					</div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
			</section>
			<section class='page-title room-properties box'>
				<div id='guest-counter'>
					<span><i class='fas fa-user'></i></span>
					<span id='guest-number'><?php echo $roomInfo['count_of_guests'];?></span>
					<p>COUNT OF GUESTS</p>
				</div>
				<div id='room-type'>
					<span><i class="fas fa-bed"></i></span>
					<span id='type-number'><?php echo $roomInfo['room_type'];?></span>
					<p>TYPE OF ROOM</p>
				</div>
				<div id='parking'>
					<span><i class="fas fa-parking"></i></span>
					<span id='parking-number'><?php echo $roomInfo['parking']? 'YES' : 'NO';?></span>
					<p>PARKING</p></div>
				<div id='wifi'>
					<span><i class="fas fa-wifi"></i></span>
					<span id='is-wifi'><?php echo $roomInfo['wifi']? 'YES' : 'NO';?></span>
					<p>WIFI</p></div>
				<div id='pet-friendly'>
					<span><i class="fas fa-dog"></i></span>
					<span id='is-pet-friendly'><?php echo $roomInfo['pet_friendly']? 'YES' : 'NO';?></span>
					<p>PET FRIENDLY</p></div>
			</section>
			<section class='room-description'>
				<h3>Room description</h3>
				<p><?php echo $roomInfo['description_long']?></p>						
			</section>
			
			<div class='links'>
				<?php
					if ($alreadyBooked) {						
				?>
					<button class='booking-status' type='button' id='booked' disabled>Already Booked</button>							
				<?php
					} else {			
				?>
					<form method='post' action='actions/book.php'>
						<input type='hidden' name='room_id' value='<?php echo $roomId?>'>
						<input type='hidden' name='check_in_date' value='<?php echo $checkInDate?>'>					
						<input type='hidden' name='check_out_date' value='<?php echo $checkOutDate?>'>										
						<button class='booking-status' type='submit' id='available'>Reservation</button>
					</form>
				<?php
					}
				?>	
			</div>
			
			<div class='clear'></div>

			<section id="map"></section>
			<div class='divider' style='margin:25px 0px; border-bottom: 2px dashed #ccc;'></div>
			<section class='reviews'>
				<h3>Reviews</h3>
				<section class='reviews-list'>
					<?php
						foreach ($allReviews as $counter => $review) {
					?>
						<div class='user-review'><p><?php echo sprintf('%d. %s', $counter + 1, $review['user_name']);?>
					<?php
						$roomReview = $review['rate'];
						for ($i = 1; $i <= 5; $i++) {
							if($roomReview >= $i) {
								?>
								<span><i class='fas fa-star star-1' style='color: #ff9b00'></i></span>
								
								<?php
							} else {
								?>
								
								<span><i class='fas fa-star star-1'></i></span>
								<?php
							}
						}
					?>									
						</div><br>
						<div class='comment'><p><?php echo htmlentities($review['comment']);?></p></div>
						<div class='add-time'><p>Created time: <?php echo $review['created_time'];?></p></div>				
					<?php
						}
					?>
				</section>
			</section>
			<section class='add-review'>
                <h3>Add review </h3> 			
				<form class='reviewForm' name='reviewForm' method='post' id='reviewForm'  action='actions/review.php'>
					<input type='hidden' name='room_id' value='<?php echo $roomId?>'>
					<input type='hidden' name='csrf' value='<?php echo User::getCsrf();?>'>					
					<div class='form-group stars'>
						<div class='form-star formStar-1'>
							<label for='star1'><i class='fas fa-star'></i></label>
							<input type="radio" class='rate' id="star1" name="rate" value='1'/>					
						</div>
						<div class='form-star formStar-2'>
							<label for='star2'><i class='fas fa-star'></i></label>						
							<input type="radio" class='rate' id="star2" name="rate" value='2'/>						
						</div>
						<div class='form-star formStar-3'>
							<label for='star3'><i class='fas fa-star'></i></label>						
							<input type="radio" class='rate' id="star3" name="rate" value='3'/>
						</div>
						<div class='form-star formStar-4'>
							<label for='star4'><i class='fas fa-star'></i></label>						
							<input type="radio" class='rate' id="star4" name="rate" value='4'/>						
						</div>
						<div class='form-star formStar-5'>
							<label for='star5'><i class='fas fa-star'></i></label>						
							<input type="radio" class='rate' id="star5" name="rate" value='5'/>						
						</div>

					</div>
                    <div class="form-group comments">
                        <textarea id="comment" name="comment" class='comment' placeholder="Your comments here"></textarea>
                    </div>	
			
					<div class="action">
						<button type='submit' class='btn-submit'>Submit</button>
					</div>				
				</form>
			
			</section>

		</main>
		<footer>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />				
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src='./star-review.js'></script>		
		<script>
			var lat = <?php echo $lat?>;
			var lng= <?php echo $long?>;
			// Initialize and add the map
			function initMap() {
			  // The location of Uluru
			  var roomLoc = {lat, lng};
			  // The map, centered at Uluru
			  var map = new google.maps.Map(
				  document.getElementById('map'), {zoom: 8, center: roomLoc});
			  // The marker, positioned at Uluru
			  var marker = new google.maps.Marker({position: roomLoc, map: map});
			  const geocoder = new google.maps.Geocoder();
			  const infowindow = new google.maps.InfoWindow();
			  marker.addListener("click", () => {
				  geocodeLatLng(geocoder, map, infowindow);
			  });			  
			  
			}
			function geocodeLatLng(geocoder, map, infowindow) {
				const latlng = {
				  lat: parseFloat(lat),
				  lng: parseFloat(lng)
				};
				geocoder.geocode(
				  {
					location: latlng
				  },
				  (results, status) => {
					if (status === "OK") {
					  if (results[0]) {
						map.setZoom(11);
						const marker = new google.maps.Marker({
						  position: latlng,
						  map: map
						});
						infowindow.setContent(results[0].formatted_address + 
						`<br><a target="_blank" href="https://www.google.com/maps?daddr=${results[0].formatted_address}" style='color: #f45111' title="Μετάβαση στους χάρτες">Οδηγίες πρόσβασης</a>`
						);
						infowindow.open(map, marker);
						  marker.addListener('click', function() {
						});

					  } else {
						window.alert("No results found");
					  }
					} else {
					  window.alert("Geocoder failed due to: " + status);
					}
				  }
				);
			}
		</script>
		<script defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3jDrtqtOwwszrawa5WWIOlKtZ4UwpSk4&callback=initMap">
		</script>		
	</body>
</html>

