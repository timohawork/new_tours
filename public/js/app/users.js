$(document).ready(function() {
	$('#add-new, tr').live('click', function() {
		var isNew = $(this).attr('id') === 'add-new',
			tr = $(this);
		$('#user-edit form')[0].reset();
		removeErrors('#user-edit form');
		$('#user-edit .modal-title').text(isNew ? 'Новый пользователь' : 'Редактирование пользователя');
		
		$('#email-input').val(isNew ? '' : tr.find('.email').text());
		$('#role-select').val(isNew ? '' : tr.data('user-role'));
		$('#password-input').attr('data-validate', 'required:'+(isNew ? '1' : '0')+';minLength:6');
		$('#user-id').val(isNew ? '' : tr.data('id'));
		
		$('#user-edit').modal('show');
		return false;
	});
	
	$('#user-edit .btn-primary').live('click', function() {
		if (!isValidate('#user-edit form')) {
			return false;
		}
		$.ajax({
			url: "/users/edit",
			type: "POST",
			async: true,
			data: $('#user-edit form').serializeArray(),
			success: function() {
				refreshTable();
				$('#user-edit').modal('hide');
			}
		});
		return false;
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить пользователя?")) {
			return false;
		}
		$.ajax({
			url: "/users/delete/id/"+$(this).closest('tr').data('id'),
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
		url: "/users",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('#users_list').html(response.html);
		}
	});
}