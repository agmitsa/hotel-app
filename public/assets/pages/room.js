(function ($) {

	$(document).on('submit', 'form.favoriteForm', function(e) {
		//Stop default form behavior
		e.preventDefault();
		
		//Get form data
		const formData = $(this).serialize();
		//Ajax request
		$.ajax(
		'http://hotel.collegelink.localhost/public/ajax/room_favorite.php',
		{
			type:'POST',
			dataType:'json',
			data: formData
		}).done(function(result) {
			
			if (result.status) {
				$('button i').attr("data-toggle", "tooltip");
				$('button i').attr("data-placement", "right");
				if(result.is_favorite) {
					$('input[name=is_favorite]').val(1);	
					$('button i').removeClass('far fa-heart');
					$('button i').addClass('fas fa-heart');
					$(this).tooltip();
					$('button i').attr("data-title", "Added to favorites!");

				} else {
					$('input[name=is_favorite]').val(0);
					$('button i').removeClass('fas fa-heart');
					$('button i').addClass('far fa-heart');	
					$('button i').attr("data-title", "Removed from favorites");

				}
				
				
			} else {
				$('button.favorite-btn').attr('disabled', true);	
			}

		});
	});
	$(document).on('submit', 'form.reviewForm', function(e) {
		//Stop default form behavior
		e.preventDefault();
		
		//Get form data
		const formData = $(this).serialize();
		//Ajax request
		$.ajax(
		'http://hotel.collegelink.localhost/public/ajax/room_review.php',
		{
			type:'POST',
			dataType:'html',
			data: formData
		}).done(function(result) {
			//Append review to list
			$('.reviews-list').append(result);

			//Reset review			
			$('form.reviewForm').trigger('reset');
			$('form.reviewForm input, form.reviewForm textarea, form.reviewForm button').attr('disabled', true);			
			$('.form-star').removeClass('active');
			$('.form-star').removeClass('secondary-active');
			$('.form-star').addClass('reset');
			
		});
		
	});	


})(jQuery);