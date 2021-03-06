$(document).ready(function() {
	$.datepicker.setDefaults($.datepicker.regional["ru"]);
	$("#start-date").datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true
    });
    
	$('#start-date, #start-time').live('change', function() {
		var routId = $('#rout-id').val();
		if (!routId) {
			return true;
		}
		$.ajax({
			url: "/tours/time_diff",
			type: "POST",
			data: {
				id: routId,
				startDate: $('#start-date').val(),
				startTime: $('#start-time').val()
			},
			success: function(response) {
				$('#finish-date').val(response.date);
				$('#finish-time').val(response.time);
			}
		});
	});
	
	$('#rout-id').live('change', function() {
		if (!$(this).val()) {
			return;
		}
		var value = $(this).val();
		$('#images-block .photos').fadeOut(300, function() {
			$(this).empty();
			$.ajax({
				url: "/photos/get_photos",
				type: "POST",
				data: {
					type: "routs",
					id: value
				},
				success: function(response) {
					$.each(response.photos, function(key, photo) {
						addPhoto(photo);
					});
					$('#images-block .photos').fadeIn(300);
				}
			});
		});
	});
	
	$('.btn-primary').live('click', function() {
		if (!isValidate('.form-horizontal')) {
			return false;
		}
	});

	function addPhoto(data)
	{
		$('#images-block .photos').prepend('<div class="photo">' +
			'<img class="img-rounded" src="/images/routs/' + data.routId + '/' + data.name + '_small.jpg" alt="">' +
		'</div>');
	}
});