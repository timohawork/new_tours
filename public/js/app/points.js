$(document).ready(function() {
	$('#add-new, .ap-blocks-block').live('click', function() {
		window.location.href = '/points/edit'+($(this).hasClass('ap-blocks-block') ? '/id/'+$(this).data('id') : '');
	});
	
	$('.fa-times').live('click', function() {
		if (!confirm('Вы уверены, что хотите удалить запись?')) {
			return false;
		}
		$.ajax({
			url: "/points/delete/id/"+$(this).closest('.ap-blocks-block').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('.fa-check').live('click', function() {
		$.ajax({
			url: "/points/activate/id/"+$(this).closest('.ap-blocks-block').data('id'),
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
		url: "/points",
		type: "POST",
		data: {
			regionId: $('#filter-region').val()
		},
		async: true,
		cache: false,
		success: function(response) {
			$('#points_list').html(response.html);
			refreshImg();
		}
	});
}