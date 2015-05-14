$(document).ready(function() {
	$('#add-new, .ap-blocks-block').live('click', function() {
		window.location.href = $(this).hasClass('ap-blocks-block') ? $(this).data('href') : '/routs/edit';
	});
	
	$('.fa-times').live('click', function() {
		if (!confirm('Вы уверены, что хотите удалить запись?')) {
			return false;
		}
		$.ajax({
			url: "/routs/delete/id/"+$(this).closest('.ap-blocks-block').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('.fa-check').live('click', function() {
		$.ajax({
			url: "/routs/activate/id/"+$(this).closest('.ap-blocks-block').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('#filter-region').live('change', refreshTable);
});

function refreshTable() {
	$.ajax({
		url: "/routs",
		type: "POST",
		data: {
			regionId: $('#filter-region').val()
		},
		async: true,
		cache: false,
		success: function(response) {
			$('#routs_list').html(response.html);
			refreshImg();
		}
	});
}