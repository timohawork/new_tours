$(document).ready(function() {
	$('#add-new, tr').live('click', function() {
		var isNew = $(this).attr('id') === 'add-new',
			tr = $(this);
		$('#guide-edit form')[0].reset();
		$('#guide-edit input[type="checkbox"]').attr("checked", false);
		removeErrors('#guide-edit form');
		$('#guide-edit .modal-title').text(isNew ? 'Новые гид' : 'Редактирование гида');
		
		$('#name-input').val(isNew ? '' : tr.find('.name').text());
		$('#spec-select').val(isNew ? '' : tr.data('spec'));
		$('#base-input').val(isNew ? '' : tr.data('base'));
		$('#phone-input').val(isNew ? '' : tr.find('.phone').text());
		$('#rating-input').val(isNew ? 0 : tr.find('.rating').text());
		if (!isNew) {
			var regions = tr.data('regions')+'';
			regions = regions.split(',');
			$.each(regions, function(key, id) {
				$('#guide-edit .regions input[name="regions['+id+']"]').attr("checked", true);
			});
		}
		$('#guide-id').val(isNew ? '' : tr.data('id'));
		
		$('#guide-edit').modal('show');
		return false;
	});
	
	$('#guide-edit .btn-primary').live('click', function() {
		if (!isValidate('#guide-edit form')) {
			return false;
		}
		$.ajax({
			url: "/guides/edit",
			type: "POST",
			async: true,
			data: $('#guide-edit form').serializeArray(),
			success: function() {
				refreshTable();
				$('#guide-edit').modal('hide');
			}
		});
		return false;
	});
	
	$('.activation').live('click', function() {
		$.ajax({
			url: "/guides/activate/id/"+$(this).closest('tr').data('id'),
			type: "POST",
			async: true,
			cache: false,
			success: refreshTable
		});
		return false;
	});
	
	$('.del').live('click', function() {
		if (!confirm("Вы уверены, что хотите удалить гида?")) {
			return false;
		}
		$.ajax({
			url: "/guides/delete/id/"+$(this).closest('tr').data('id'),
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
		url: "/guides",
		type: "POST",
		async: true,
		cache: false,
		success: function(response) {
			$('#guides_list').html(response.html);
		}
	});
}