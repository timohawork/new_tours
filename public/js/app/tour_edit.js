$(document).ready(function() {
	$.datepicker.setDefaults($.datepicker.regional["ru"]);
	$("#start-date").datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		onClose: function(selectedDate) {
			$("#finish-date").datepicker("option", "minDate", selectedDate);
		}
    });
    $("#finish-date").datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		onClose: function(selectedDate) {
			$("#start-date").datepicker("option", "maxDate", selectedDate);
		}
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
			'<a class="preview-image" href="#" data-url="/images/routs/'+data.routId+'/'+data.name+'_view.jpg">'+
				'<img class="img-thumbnail" src="/images/routs/' + data.routId + '/' + data.name + '_small.jpg" alt="">' +
			'</a>'+
		'</div>');
	}
});