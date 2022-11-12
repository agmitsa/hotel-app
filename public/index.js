var date = new Date();
var date2;// date3;
$(document).ready(function() {
	var dateFormat = "mm/dd/yy",
	  from = $( "#from" )
		.datepicker({
		  minDate: 0,
		  defaultDate: date,
		  changeMonth: true,
		})
		.on( "change", function() {
			date2 = $('#from').datepicker('getDate');
			date.setDate(date2.getDate() + 1);
		  to.datepicker( "option", "minDate", date);
		}),
	  to = $( "#to" ).datepicker({
		minDate: +1,
		defaultDate: "+1d",
		changeMonth: true,
	  })
	  .on( "change", function() {
			date2 = $('#to').datepicker('getDate');
			date.setDate(date2.getDate() - 1);	  
		from.datepicker( "option", "maxDate", date);
	  });
 
	function getDate( element ) {
	  var date;
	  try {
		date = $.datepicker.parseDate( dateFormat, element.value );
		console.log(date = $.datepicker.parseDate( dateFormat, element.value));
	  } catch( error ) {
		date = null;
	  }
 
	  return date;
	}

//Check if city, check in and check out date are filled
	$('.inputs-error').css('display','none');	
	$('.searchForm').submit(function(e) {
		if ($( "#formCity option:selected" ).val() =='' || $( "#from.hasDatepicker" ).val() =='' || $( "#to.hasdatepicker" ).val() =='') {	
			e.preventDefault();
			$('.inputs-error').css('display','');	
		
		} 
		
	});
});
	