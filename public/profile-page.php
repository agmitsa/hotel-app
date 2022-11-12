<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

$userId = User::getCurrentUserId();
if (empty($userId)) {
	header('Location: index.php');
	
	return;
}

//Get all favorites
$favorite = new Favorite();
$userFavorites = $favorite->getListByUser($userId);

//Get all reviews
$review = new Review();
$userReviews = $review->getListByUser($userId);

//Get all Bookings
$booking = new Booking();
$userBookings = $booking->getBookingsByUser($userId);
?>
<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">	
		<title>Hotels-Profile page</title>
		<link href="assets/css/list.css" type="text/css" rel="stylesheet" />
		<link href='assets/css/profile-page.css' type="text/css" rel="stylesheet" />
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
			<aside class='left-section profile box'>
				<h1>FAVORITES</h1>
				<?php
				if (count($userFavorites) > 0) {
				?>
				<ol>
					<?php foreach ($userFavorites as $userFavorite) {?>
					<h3>
						<li>
							<a href='room-page.php?room_id=<?php echo $userFavorite['room_id']?>'><?php echo $userFavorite['name']?></a>
						</li>
					</h3>
					<?php
					}
					?>
				</ol>
				<?php } else {?>
					<h4>No favorites!</h4>
				<?php }?>
				<h1>REVIEWS</h1>
				<?php
				if (count($userReviews) > 0) {
				?>
				<ol>
					<?php foreach ($userReviews as $userReview) {?>
					<h3>
						<li>
							<a href='room-page.php?room_id=<?php echo $userReview['room_id']?>'><?php echo $userReview['name']?></a>
							<div class='stars'>
							<?php								
								for ($i = 1; $i <= 5; $i++) {
									if($userReview['rate'] >= $i) {
										?>
										<span><i class='fas fa-star' style='color: #ff9b00'></i></span>
										
										<?php
									} else {
										?>
										
										<span><i class='fas fa-star'></i></span>
										<?php
									}
								}
							?>								
							</div>							
						</li>
					</h3>
					<?php
					}
					?>
				</ol>
				<?php } else {?>
					<h4>No reviews!</h4>
				<?php }?>				

			</aside>
			<section class='main-section box'>
				<div class='page-title box'>
					<h2>My bookings</h2>					
				</div>				
				<section class='search-results'>
				
					<?php 
						foreach ($userBookings as $userBooking) {	
					?>
					<article class='list-element'>
						<div class='hotel-img'>
							<img src='assets/images/rooms/<?php echo $userBooking['photo_url']?>'/>
						</div>					
						<div class='small-description'>
							<h1><?php echo $userBooking['name']?></h1>
							<h2><?php echo $userBooking['area']?>, <?php echo $userBooking['city']?></h2>
							<p><?php echo $userBooking['description_short']?></p>		
							<form action='room-page.php'>
								<input type='hidden' name='room_id' value='<?php echo $userBooking['room_id']?>'>
								<input type='hidden' name='check_in_date' value='<?php echo $userBooking['check_in_date']?>'>					
								<input type='hidden' name='check_out_date' value='<?php echo $userBooking['check_out_date']?>'>										
								<button class='action' type='submit'>Go to Room page</button>								
							</form>							
						</div>
						<div class='price' id='totalCost'>Total cost: <?php echo $userBooking['total_price']?></div>
						<div class='room-info booking'>
							<div id='check-in-bookDate'>Check-in Date: <?php echo $userBooking['check_in_date']?></div>
							<div id='check-out-bookDate'>Check-out Date: <?php echo $userBooking['check_out_date']?></div>
							<div id='room-type'>Room Type: <?php echo $userBooking['room_type']?></div>
						</div>
							
						<div class="clear"></div>
					</article>	
					<?php
						}
					?>					

					<?php
						if (count($userBookings) == 0) {
					?>
						<h2 class='check-seacrh'>You don't have any bookings yet!</h2>
					<?php
						}
					?>				
					
				</section>				
			</section>
		
		</main>
		<footer>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />		
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />	
	</body>
</html>