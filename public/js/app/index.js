$(document).ready(function() {
	var folding = new Folding(),
		imageEditor = new ImageEditor();
	folding.init();
	refreshImg();
	
	$.datepicker.setDefaults($.datepicker.regional["ru"]);
	$("#region-period-begin-input").datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		onClose: function(selectedDate) {
			$("#region-period-end-input").datepicker("option", "minDate", selectedDate);
		}
    });
    $("#region-period-end-input").datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		onClose: function(selectedDate) {
			$("#region-period-begin-input").datepicker("option", "maxDate", selectedDate);
		}
    });
	
	$('.btn-group .btn-info:not(.dropdown-toggle)').live('click', function() {
		$(this).parent().toggleClass('open');
		return false;
	});
	
	$('.ap-block-header').live('click', function() {
		folding.toggle($(this).find('.ap-caret'));
	});
	
	$('.fa-pencil').live('click', function() {
		var block = $(this).closest('.ap-block');
		$('#region-edit .preview-image').addClass('hide');
		$('#region-edit form')[0].reset();
		removeErrors('#region-edit form');
		$('#region-edit .photo-load').html('');
		$.ajax({
			url: "/regions/get/id/"+block.attr('data-id'),
			type: "POST",
			async: true,
			success: function(response) {
				$('#region-edit .modal-title').text('Редактирование '+(response.data.type === 'region' ? 'региона' : 'города'));
				$('#region-name-input').val(response.data.title);
				$('#region-description-input').val(response.data.description);
				$('#region-start-point-input').val(response.data.startPointId);
				$('#region-period-begin-input').val(response.data.startDate);
				$('#region-period-end-input').val(response.data.endDate);
				$('#region-image').html(response.data.image ? '<img class="img-thumbnail region-image" src="/images/regions/'+response.data.id+'/'+response.data.image+'_small.jpg" alt="">' : '<span class="region-image fa-stack fa-2x no-photo">'+
					'<i class="fa fa-camera fa-stack-1x"></i>'+
					'<i class="fa fa-ban fa-stack-2x text-danger"></i>'+
				'</span>').attr('data-prop', response.data.previewProp);
				if (response.data.image) {
					$('#region-edit .preview-image').removeClass('hide')
						.attr('data-url', '/images/regions/'+response.data.id+'/'+response.data.image+'_view.jpg');
					$('#region-edit .preview-image img').attr('src', '/images/regions/'+response.data.id+'/'+response.data.image+'_preview.jpg');
				}
				$('#region-id, #region-id-image').val(response.data.id);
				refreshImg();
			}
		});
		$('#region-edit').modal('show');
		return false;
	});
	
	$('#region-add, .ap-block-header .fa-plus').live('click', function() {
		var block = $(this).closest('.ap-block'),
			obj = {
				url: "/regions/add",
				type: "POST",
				async: false,
				success: function(response) {
					refreshTable();
					$('.ap-block[data-id="'+response.data.id+'"] .fa-pencil').trigger('click');
				}
			};
		if (block.hasClass('region')) {
			obj.data = {regionId: block.attr('data-id')}
		}
		$.ajax(obj);
		return false;
	});
	
	$('#region-edit .btn-primary').live('click', function() {
		$.ajax({
			url: "/regions/edit",
			type: "POST",
			async: true,
			data: $('#region-edit form').serializeArray(),
			success: function() {
				$('#region-edit').modal('hide');
				refreshTable();
			}
		});
		return false;
	});
	
	$('.region-image').live('click', function() {
		if ($(this).hasClass('no-photo')) {
			$('#region-image-file').trigger('click');
			return false;
		}
		var prop = $('#region-image').attr('data-prop');
		if (!undef(prop) && prop.length) {
			prop = prop.split('x');
		}
		imageEditor.init($('#region-name-input').val(), $(this).attr('src').replace('_small', '_view'), $('#region-id').val(), 'regions', prop, function() {
			$('#region-image-file').trigger('click');
		}, undefined, function(props) {
			$('#region-image').attr('data-prop', props.join('x'));
		});
		return false;
	});
	
	$('#region-image-file').live('change', function() {
		$('#region-image-form').ajaxForm({
			beforeSend: function() {
				if (!$('#image-editor .photo-load .progress-bar').length) {
					$('#image-editor .photo-load, #region-edit .photo-load').html('<div class="progress progress-striped">'+
						'<div class="progress-bar progress-bar-success"></div>'+
					'</div>');
				}
				$('#image-editor .photo-load .progress-bar, #region-edit .photo-load .progress-bar').width('0%');
			},
			uploadProgress: function(event, position, total, percentComplete) {
				$('#image-editor .photo-load .progress-bar, #region-edit .photo-load .progress-bar').width(percentComplete+'%');
			},
			success: function(response) {
				$('#image-editor .photo-load .progress, #region-edit .photo-load .progress').remove();
				if (response.data) {
					var fullName = '/images/regions/'+response.data.regionId+'/'+response.data.name;
					$('#region-image').html('<img class="img-thumbnail region-image" src="'+fullName+'_small.jpg" alt="">');
					$('#region-edit .preview-image').removeClass('hide')
						.attr('data-url', fullName+'_view.jpg');
					$('#region-edit .preview-image img').attr('src', fullName+'_preview.jpg');
					$('#image-editor .image-frame img').attr('src', fullName+'_view.jpg');
					refreshTable();
				}
			}
		}).submit();
		return false;
	});
	
	/* ---------------------------------------------------------------------- */
	
	$('.fa-times').live('click', function() {
		if ($(this).closest('#image-editor').length || !confirm('Вы уверены, что хотите удалить запись?')) {
			return false;
		}
		var type, id;
		if ($(this).parent().hasClass('rout')) {
			type = 'routs';
			id = $(this).parent().data('id');
		}
		else {
			type = 'regions';
			id = $(this).closest('.ap-block').data('id');
		}
		$.ajax({
			url: "/"+type+"/delete/id/"+id,
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('.fa-check').live('click', function() {
		if ($(this).closest('#image-editor').length) {
			return;
		}
		var type, id;
		if ($(this).parent().hasClass('rout')) {
			type = 'routs';
			id = $(this).parent().data('id');
		}
		else {
			type = 'regions';
			id = $(this).closest('.ap-block').data('id');
		}
		$.ajax({
			url: "/"+type+"/activate/id/"+id,
			type: "POST",
			async: true,
			success: refreshTable
		});
		return false;
	});
	
	$('#listing_date').datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true
	}).live('change', refreshTable);
	
	function refreshTable()
	{
		$.ajax({
			url: "/index",
			type: "POST",
			data: {
				date: $('#listing_date').val()
			},
			async: false,
			cache: false,
			success: function(response) {
				$('#listing').html(response.html);
				$('#region-start-point-input').empty();
				$.each(response.points, function(key, point) {
					$('#region-start-point-input').append('<option value="'+point.id+'">'+point.title+'</option>');
				});
				refreshImg();
				folding.init(false);
			}
		});
	}
});