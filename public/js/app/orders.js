$(document).ready(function() {
	$('#add-new, tr').live('click', function() {
		var isNew = $(this).attr('id') === 'add-new',
			tr = $(this);
		$('#order-edit form')[0].reset();
		removeErrors('#order-edit form');
		$('#order-edit .modal-title').text(isNew ? 'Новая заявка' : 'Редактирование заявки');
		
		if (!isNew) {
			$.ajax({
				url: "/orders/get_data/id/"+tr.data('id'),
				type: "POST",
				async: true,
				success: function(response) {
					$('#client-name').text(response.clientName);
					$('#client-phone').text(response.clientPhone);
					$('#comfort').text(response.comfort);
					$('#start-object').text(response.startTitle);
					$('#tour-id').val(response.tourId);
					$('#pass-count').val(response.passCount);
					setPaid(response.isPaid == 1, response.paymentType, response.summ);
				}
			});
		}
		else {
			setPaid(false);
		}
		$('#order-id').val(isNew ? '' : tr.data('id'));
		
		$('#order-edit').modal('show');
		return false;
	});
	
	$('#is-paid').live('change', function() {
		setPaid($(this).attr("checked") === 'checked');
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
			success: function() {
				refreshTable();
				$('#order-edit').modal('hide');
			}
		});
		return false;
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить заявку?")) {
			return false;
		}
		$.ajax({
			url: "/orders/delete/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			cache: false,
			success: refreshTable
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
			$('#orders_list').html(response.html);
		}
	});
}

function setPaid(isPaid, type, summ) {
	isPaid = !undef(isPaid) && isPaid;
	console.log(isPaid);
	$('#is-paid').attr("checked", isPaid);
	$('#payment-type').attr("disabled", !isPaid)
		.attr("data-validate", 'required:'+(isPaid? '1' : '0')+';')
		.val(isPaid? type : '');
	$('#summ').attr("disabled", !isPaid)
		.attr("data-validate", 'required:'+(isPaid? '1' : '0')+';')
		.val(isPaid? summ : '');
}