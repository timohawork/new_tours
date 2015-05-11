$(document).ready(function() {
	$('#add-new, tr').live('click', function() {
		var isNew = $(this).attr('id') === 'add-new',
			tr = $(this);
		$('#client-edit form')[0].reset();
		removeErrors('#client-edit form');
		$('#client-edit .modal-title').text(isNew ? 'Новый клиент' : 'Редактирование клиента');
		
		if (!isNew) {
			$.ajax({
				url: "/clients/get_data/id/"+tr.data('id'),
				type: "POST",
				async: true,
				success: function(response) {
					$('#name-input').val(response.name);
					$('#phone-input').val(response.phone);
					$('#email-input').val(response.email);
					$('#uid-input').val(response.uid);
					$('#social-id-input').val(response.socialId);
					$('#login-input').val(response.login);
					$('#password-input').attr('data-validate', 'required:0;minLength:6');
				}
			});
		}
		else {
			$('#password-input').attr('data-validate', 'required:1;minLength:6');
		}
		$('#client-id').val(isNew ? '' : tr.data('id'));
		
		$('#client-edit').modal('show');
		return false;
	});
	
	$('#client-edit .btn-primary').live('click', function() {
		if (!isValidate('#client-edit form')) {
			return false;
		}
		$.ajax({
			url: "/clients/edit",
			type: "POST",
			async: true,
			data: $('#client-edit form').serializeArray(),
			success: function() {
				refreshTable();
				$('#client-edit').modal('hide');
			}
		});
		return false;
	});
	
	$('.activation').live('click', function() {
		$.ajax({
			url: "/clients/activate/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('.orders').live('click', function() {
		window.location.href = $(this).attr('href');
		return false;
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить клиента?")) {
			return false;
		}
		$.ajax({
			url: "/clients/delete/id/"+$(this).closest('tr').data('id'),
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
		url: "/clients",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('#clients_list').html(response.html);
		}
	});
}