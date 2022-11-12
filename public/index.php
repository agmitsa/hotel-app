<?php
require __DIR__.'/../boot/boot.php';

use Hotel\User;
use Hotel\Room;
use Hotel\RoomType;

$room = new Room();
$cities = $room->getCities();

//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();
?>
<!DOCTYPE html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
		<title>Hotels-Welcome page</title>
		<link href="assets/css/index.css" type="text/css" rel="stylesheet" />	
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link
		  rel="stylesheet"
		  href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"
		/>		
		<script src='./index.js'></script>	
	<body>

        <header>
            <div class="container">
				<p class="logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
						<li class='home'><a href="index.php"><i class='fas fa-home'></i>Home</a></li>	
						<li class="profile"><a href="profile.php"><i class='fas fa-user'></i>Profile</a></li>

                    </ul>
                </div>
				<div class="clear"></div>
            </div>
        </header>		
		
		<main>
			
			<form class='searchForm' name='searchForm' action='list.php'>
				<div class="form-group">
					<select id="formCity" name='city'>
						<option value='' disabled selected>City</option>
						<?php 
							foreach ($cities as $city) {																										
						?>
							<option value="<?php echo $city; ?>"><?php echo $city; ?></option>
						<?php
							}
						?>

					</select>
				</div>
				<div class="form-group">
					<select id="formRoom" name='room_type'>
						<option value='' disabled selected>Room Type</option>					
						<?php 
							foreach ($allTypes as $roomType) {																										
						?>
							<option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?>
							</option>
						<?php
							}
						?>
					</select>
				</div>	
				<div class='form-group'>
					<input type="text" id="from" name='check_in_date' size="16" placeholder='Check in date'>
				</div>
				<div class='form-group'>
					<input type="text" id="to" name='check_out_date' size="16" placeholder='Check out date'>
				</div>	
				<div class='text-danger inputs-error'>
					*City<br>
					*Check in date<br>
					*Check out date are required!
				</div>
				<div class="action">
					<input name="btn-submit" id="submitButton" type="submit" value="Search">
				</div>					
			</form>
			
		</main>
		
		<footer class='index-footer'>
			<p>©collegelink 2020</p>		
		</footer>
		<link href="assets/css/fontawesome.min.css" rel="stylesheet" />				
		<link href="assets/css/wda-style.css" type="text/css" rel="stylesheet" />
	</body>
</html>




