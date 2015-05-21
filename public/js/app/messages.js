$(document).ready(function() {
	$('.activation').live('click', function() {
		$.ajax({
			url: "/support/seen/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить сообщение?")) {
			return false;
		}
		$.ajax({
			url: "/support/delete/id/"+$(this).closest('tr').data('id'),
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
		url: "/support",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('#messages_list').html(response.html);
		}
	});
}