$(document).ready(function() {
	$('.btn-primary').live('click', function() {
		var form = $('form').serializeArray();
		clearResponse();
		$.ajax({
			url: "/api/"+form[0].value,
			type: "POST",
			async: true,
			cashe: false,
			data: form,
			success: function(response) {
				$('#response-type').html(response.type);
				if (!undef(response.errors)) {
					$('#response-errors').html(JSON.stringify(response.errors));
					$('#response .error-row').removeClass('hide');
				}
				if (!undef(response.data)) {
					$('#response-data').html(JSON.stringify(response.data));
				}
			}
		});
		return false;
	});
	
	$('#method-select').live('change', function() {
		var inputs = $('#request-inputs .col-sm-8');
		clearResponse();
		switch ($(this).val()) {
			case 'login':
				inputs.html(
					'<input id="email-input" type="text" name="email" class="form-control" placeholder="Email">'+
					'<br>'+
					'<input id="password-input" type="password" name="password" class="form-control" placeholder="Password">'
				);
			break;
			
			case 'listing':
				inputs.html('');
			break;
			
			case 'types_list':
				inputs.html('');
			break;
			
			case 'obj_get':
				inputs.html('<input id="uid-input" type="text" name="uid" class="form-control" placeholder="Uid">');
			break;
			
			case 'mark_edit':
				inputs.html(
					'<input id="uid-input" type="text" name="uid" class="form-control" placeholder="Uid">'+
					'<br>'+
					'<input id="city-id-input" type="text" name="cityId" class="form-control" placeholder="CityId">'+
					'<br>'+
					'<input id="groupId-id-input" type="text" name="groupIdId" class="form-control" placeholder="GroupId">'+
					'<br>'+
					'<input id="title-input" type="text" name="title" class="form-control" placeholder="Title">'+
					'<br>'+
					'<textarea id="description-input" name="description" class="form-control" placeholder="Description"></textarea>'+
					'<br>'+
					'<input id="address-input" type="text" name="address" class="form-control" placeholder="Address">'+
					'<br>'+
					'<input id="coord-input" type="text" name="coord" class="form-control" placeholder="Coordinates">'+
					'<br>'+
					'<input id="phone-input" type="text" name="phone" class="form-control" placeholder="Phone">'+
					'<br>'+
					'<input id="mark-email-input" type="text" name="email" class="form-control" placeholder="Email">'+
					'<br>'+
					'<input id="skype-input" type="text" name="skype" class="form-control" placeholder="Skype">'+
					'<br>'+
					'<input id="viber-input" type="text" name="viber" class="form-control" placeholder="Viber">'+
					'<br>'+
					'<input id="site-input" type="text" name="site" class="form-control" placeholder="Site">'+
					'<br>'+
					'<select id="active-input" name="active" class="form-control">'+
						'<option value=""></option>'+
						'<option value="0">0</option>'+
						'<option value="1">1</option>'+
					'</select>'
				);
			break;
		}
	});
});

function clearResponse()
{
	$('#response-type, #response-errors, #response-data').html('');
	$('#response .error-row').addClass('hide');
}