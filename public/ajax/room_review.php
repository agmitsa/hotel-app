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
//verify csrf
$csrf = $_REQUEST['csrf'];
if (!$csrf || !User::verifyCsrf($csrf)) {
	echo 'This is an invalid request';
	return;
}

//Add review
$review = new Review();
$rate = $_REQUEST['rate'];
$comment = $_REQUEST['comment'];
$review->insert($roomId, User::getCurrentUserId(), $rate, $comment);

//Get all reviews 
$roomReviews = $review->getReviewsByRoom($roomId);

//Load user data
$user = new User();
$userInfo = $user->getUserById(User::getCurrentUserId());

?>

<div class='user-review'><p><?php echo sprintf('%d. %s', count($roomReviews), $userInfo['name']);?>
	<?php
		for ($i = 1; $i <= 5; $i++) {
			if($rate >= $i) {
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
		<br>
		<div class='comment'><p><?php echo $comment;?></p></div>
		<div class='add-time'p>Created time: <?php echo (new DateTime())->format('Y-m-d H:i:s');?></p></div>						
</div>