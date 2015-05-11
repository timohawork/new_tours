$(document).ready(function() {
	$('#add-new, .edit').live('click', function() {
		var isNew = !$(this).hasClass('edit'),
			tr = $(this).closest('tr');
		$('#car-edit form')[0].reset();
		$('#car-edit input[type="checkbox"]').attr("checked", false);
		removeErrors('#car-edit form');
		$('#car-edit .modal-title').text(isNew ? 'Новый транспорт' : 'Редактирование транспорта');
		
		$('#name-input').val(isNew ? '' : tr.find('.name').text());
		$('#type-select').val(isNew ? '' : tr.data('type'));
		$('#pass-count-input').val(isNew ? 0 : tr.find('.count').text());
		$('#comfort-select').val(isNew ? 0 : tr.find('.comfort').text());
		$('#phone-input').val(isNew ? '' : tr.find('.phone').text());
		$('#rating-input').val(isNew ? 0 : tr.find('.rating').text());
		$('#base-input').val(isNew ? '' : tr.data('base'));
		if (!isNew) {
			var regions = tr.data('regions')+'';
			regions = regions.split(',');
			$.each(regions, function(key, id) {
				$('#car-edit .regions input[name="regions['+id+']"]').attr("checked", true);
			});
		}
		$('#car-id').val(isNew ? '' : tr.data('id'));
		
		$('#car-edit').modal('show');
		return false;
	});
	
	$('#car-edit .btn-primary').live('click', function() {
		if (!isValidate('#car-edit form')) {
			return false;
		}
		$.ajax({
			url: "/cars/edit",
			type: "POST",
			async: true,
			data: $('#car-edit form').serializeArray(),
			success: function() {
				refreshTable();
				$('#car-edit').modal('hide');
			}
		});
		return false;
	});
	
	$('.activation').live('click', function() {
		$.ajax({
			url: "/cars/activate/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			success: refreshTable
		});
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить транспорт?")) {
			return false;
		}
		$.ajax({
			url: "/cars/delete/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			cache: false,
			success: refreshTable
		});
	});
});

function refreshTable()
{
	$.ajax({
		url: "/cars",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('#cars_list').html(response.html);
		}
	});
}