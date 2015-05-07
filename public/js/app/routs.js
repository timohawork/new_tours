$(document).ready(function() {
	$('#add-new, .ap-blocks-block').live('click', function() {
		window.location.href = '/routs/edit'+($(this).hasClass('ap-blocks-block') ? '/id/'+$(this).data('id') : '');
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
});

function refreshTable() {
	$.ajax({
		url: "/routs",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('.ap-blocks-list').html(response.html);
			refreshImg();
		}
	});
}