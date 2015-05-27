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
			case 'orders':
				inputs.html('');
			break;
			
			case 'order_create':
				inputs.html(
					'<input id="tour-uid-input" type="text" name="tourUid" class="form-control" placeholder="TourUid">'+
					'<br>'+
					'<input id="pass-count-input" type="number" name="passCount" class="form-control" placeholder="PassCount">'+
					'<br>'+
					'<input id="summ-input" type="number" name="summ" class="form-control" placeholder="Summ">'+
					'<br>'+
					'<select id="payment-type-input" name="paymentType" class="form-control">'+
						'<option value=""></option>'+
						'<option value="0">Наличка</option>'+
						'<option value="1">Безнал</option>'+
					'</select>'
				);
			break;
		
			case 'order_edit':
				inputs.html(
					'<input id="uid-input" type="text" name="uid" class="form-control" placeholder="Uid">'+
					'<br>'+
					'<input id="tour-uid-input" type="text" name="tourUid" class="form-control" placeholder="TourUid">'+
					'<br>'+
					'<input id="pass-count-input" type="number" name="passCount" class="form-control" placeholder="PassCount">'+
					'<br>'+
					'<input id="summ-input" type="number" name="summ" class="form-control" placeholder="Summ">'+
					'<br>'+
					'<select id="payment-type-input" name="paymentType" class="form-control">'+
						'<option value="">PaymentType</option>'+
						'<option value="0">Наличка</option>'+
						'<option value="1">Безнал</option>'+
					'</select>'
				);
			break;
		
			case 'registration':
				inputs.html(
					'<input id="login-input" type="text" name="login" class="form-control" placeholder="Login">'+
					'<br>'+
					'<input id="password-input" type="password" name="password" class="form-control" placeholder="Password">'+
					'<br>'+
					'<input id="email-input" type="text" name="email" class="form-control" placeholder="Email">'+
					'<br>'+
					'<input id="name-input" type="text" name="name" class="form-control" placeholder="Name">'+
					'<br>'+
					'<input id="phone-input" type="text" name="phone" class="form-control" placeholder="Phone">'+
					'<br>'+
					'<input id="social-id-input" type="text" name="socialId" class="form-control" placeholder="SocialID">'
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