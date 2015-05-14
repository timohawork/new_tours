$(document).ready(function() {
	$('.order-tour-block').live('click', function() {
		var id = $(this).data('id');
		$('#order-edit form')[0].reset();
		removeErrors('#order-edit form');
		$('#error-alert').css('display', 'none');
		
		$.ajax({
			url: "/orders/get_data/id/"+id,
			type: "POST",
			async: true,
			success: function(response) {
				$('#order-edit tbody').empty();
				$('#guide-id').val(response.guideId);
				$('#car-id').val(response.carId);
				$.each(response.orders, function(key, order) {
					addOrderLine('order-edit', order);
				});
				$('#not-placed').empty().append('<option value=""></option>');
				
				$.each(response.notPlaced, function(key, order) {
					$('#not-placed').append(
						'<option value="'+order.id+'" data-id="'+order.id+'" data-client="'+order.client+'" data-pass="'+order.passCount+'" data-summ="'+order.summ+'" data-payment-type="'+order.paymentType+'">'+order.client+' - '+order.passCount+' чел.</option>'
					);
				});
				$('#order-id').val(id);
			}
		});
		
		$('#order-edit').modal('show');
		return false;
	});
	
	$('.add-line').live('click', function() {
		if (!$('#not-placed').val()) {
			return false;
		}
		var option = $('#not-placed option[data-id="'+$('#not-placed').val()+'"]'),
			obj = {
				id: option.data('id'),
				client: option.data('client'),
				passCount: option.data('pass'),
				summ: option.data('summ'),
				paymentType: option.data('payment-type')
			};
		option.remove();
		addOrderLine('order-edit', obj, true);
		return false;
	});
	
	$('.del').live('click', function() {
		var tr = $(this).closest('tr');
		tr.fadeOut(300, function() {
			$(this).remove();
			$('#not-placed').append('<option value="'+tr.data('id')+'" data-id="'+tr.data('id')+'" data-client="'+tr.data('client')+'" data-pass="'+tr.data('pass')+'" data-summ="'+tr.data('summ')+'" data-payment-type="'+tr.data('payment-type')+'">'+tr.data('client')+' - '+tr.data('pass')+' чел.</option>');
		});
		return false;
	});
	
	$('#order-edit .btn-primary').live('click', function() {
		if (!isValidate('#order-edit form')) {
			return false;
		}
		$.ajax({
			url: "/orders/edit",
			type: "POST",
			async: true,
			data: $('#order-edit form').serializeArray(),
			success: function(response) {
				if (response.error) {
					$('#error-alert').fadeIn();
				}
				else {
					refreshTable();
					$('#order-edit').modal('hide');
				}
			}
		});
		return false;
	});
	
	$('#error-alert .alert-link').live('click', function() {
		$('#order-edit').modal('hide');
		$.ajax({
			url: "/orders/get_data/id/"+$('#order-id').val(),
			type: "POST",
			async: true,
			success: function(response) {
				$('#order-new tbody').empty();
				$('#guide-id').val(response.guideId);
				$('#car-id').val(response.carId);
				$.each(response.notPlaced, function(key, order) {
					addOrderLine('order-new', order);
				});
				$('#tour-id').val(response.tourId);
				$('#order-new').modal('show');
			}
		});
		return false;
	});
	
	$('#order-new .btn-primary').live('click', function() {
		if (!isValidate('#order-new form')) {
			return false;
		}
		$.ajax({
			url: "/orders/create",
			type: "POST",
			async: true,
			data: $('#order-new form').serializeArray(),
			success: function(response) {
				if (response.error) {
					$('#error-alert').fadeIn();
				}
				else {
					refreshTable();
					$('#order-new').modal('hide');
				}
			}
		});
		return false;
	});
});

function refreshTable()
{
	$.ajax({
		url: window.location.href,
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			var notPlacedSel = $('.indicator.not-placed');
			$('.indicator.placed span').text(response.indicators.placed);
			response.indicators.notPlaced ? notPlacedSel.addClass('active') : notPlacedSel.removeClass('active');
			$('.indicator.not-placed span').text(response.indicators.notPlaced);
			$('#orders_list').html(response.html);
		}
	});
}

function setPaid(isPaid, type, summ)
{
	isPaid = !undef(isPaid) && isPaid;
	$('#is-paid').attr("checked", isPaid);
	$('#payment-type').attr("disabled", !isPaid)
		.attr("data-validate", 'required:'+(isPaid? '1' : '0')+';')
		.val(isPaid? type : '');
	$('#summ').attr("disabled", !isPaid)
		.attr("data-validate", 'required:'+(isPaid? '1' : '0')+';')
		.val(isPaid? summ : '');
}

function addOrderLine(modal, order, fading)
{
	fading = !undef(fading) && fading;
	var line = $('<tr class="" data-id="'+order.id+'" data-client="'+order.client+'" data-pass="'+order.passCount+'" data-summ="'+order.summ+'" data-payment-type="'+order.paymentType+'">'+
		'<td><b>'+order.client+'</b></td>'+
		'<td>'+order.passCount+'</td>'+
		'<td>'+(order.summ ? order.summ + ' р., '+order.paymentType : '&mdash;')+'</td>'+
		'<td class="edit-block">'+
			'<a href="#" class="del"><i class="fa fa-trash-o fa-lg"></i></a>'+
			'<input type="hidden" name="orders[]" value="'+order.id+'">'+
		'</td>'+
	'</tr>');
	if (fading) {
		line.css('display', 'none');
		$('#'+modal+' tbody').append(line);
		line.fadeIn(300);
	}
	else {
		$('#'+modal+' tbody').append(line);
	}
}