let isClicked = false;
let isDisabled = $('.form-star').hasClass('reset');
$('form.reviewForm button').attr('disabled', true);	

$('.form-star').on('click', function(e) {
	isClicked = true;
	$('form.reviewForm button').attr('disabled', false);		
	$('.form-star').removeClass('active');
	$('.form-star').removeClass('secondary-active');
	$(this).addClass('active');
	$(this).prevAll().addClass('secondary-active');
	
});

$('.form-star').on('mouseover', function(e) {
	if (!isClicked && !isDisabled) {
		$(this).addClass('active');
		$(this).prevAll().addClass('secondary-active');		
	}	
}); 

$('.form-star').on('mouseleave', function(e) {
	if (!isClicked) {
		$('.form-star').removeClass('active');
		$('.form-star').removeClass('secondary-active');		
	}	
});

$('.form-star').on('click', function(e) {
	isClicked = true;
	$('.form-star').removeClass('active');
	$('.form-star').removeClass('secondary-active');
	$(this).addClass('active');
	$(this).prevAll().addClass('secondary-active');
	
});

