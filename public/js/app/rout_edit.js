$(document).ready(function() {
	var imageEditor = new ImageEditor();
	
	$('.add-line').live('click', function() {
		var group = $(this).closest('.form-group'),
			selected = group.find('select').val();
		if (!selected) {
			return false;
		}
		var type = group.data('type'),
			line = group.find('option[value="'+selected+'"]').text();
		
		$('.for-points-list option[value="'+selected+'"]').remove();
		group.find('.rout-points-list tbody').append('<tr>'+
			'<td class="title">'+line+'</td>'+
			'<td class="time"><input class="form-control timepicker" name="'+type+'_time[]" type="text" value="00:00"></td>'+
			'<td class="del">'+
				'<input type="hidden" name="'+type+'_id[]" value="'+selected+'">'+
				'<i class="fa fa-trash-o fa-lg"></i>'+
			'</td>'+
		'</tr>');
		setTimepickers();
		return false;
	});
	
	$('.rout-points-list .fa-trash-o').live('click', function() {
		$(this).closest('tr').remove();
	});
	
	$('.btn-primary').live('click', function() {
		if (!isValidate('.form-horizontal')) {
			return false;
		}
	});
	
	$('.photo.add').live('click', function() {
		$('#rout-photo-id-image').val('');
		$('#rout-image-file').trigger('click');
		return false;
	});
	
	$('#rout-image-file').live('change', function() {
		var selector = $('#rout-photo-id-image').val().length ? $('#image-editor .photo-load') : $('#rout-edit .photo-load');
		$('#rout-image-form').ajaxForm({
			beforeSend: function() {
				selector.empty().html('<div class="progress progress-striped">'+
						'<div class="progress-bar progress-bar-success"></div>'+
					'</div>');
				selector.find('.progress-bar').width('0%');
			},
			uploadProgress: function(event, position, total, percentComplete) {
				selector.find('.progress-bar').width(percentComplete+'%');
			},
			success: function(response) {
				selector.find('.progress').remove();
				if (response.data && response.data.isNew) {
					addPhoto(response.data);
				}
				else if (response.data) {
					var fullName = '/images/routs/'+response.data.routId+'/'+response.data.name;
					$('.photo[data-id="'+response.data.id+'"] img').attr('src', fullName+'_small.jpg');
					$('#image-editor .image-frame img').attr('src', fullName+'_view.jpg');
				}
			}
		}).submit();
		return false;
	});
	
	$('.preview-image .fa-pencil').live('click', function() {
		var self = $(this),
			img = $(this).prev(),
			prop = img.attr('data-prop');
		if (!undef(prop) && prop.length) {
			prop = prop.split('x');
		}
		imageEditor.init($('#title').val(), img.attr('src').replace('_small', '_view'), self.closest('.photo').attr('data-id'), 'routs', prop, function() {
			$('#rout-photo-id-image').val(self.closest('.photo').attr('data-id'));
			$('#rout-image-file').trigger('click');
		}, function() {
			var block = self.closest('.photo');
			block.remove();
			var count = $('#rout-edit .photos .photo:not(.add)').length;
			if (3 > count && !$('#rout-edit .photo.add').length) {
				$('#rout-edit .photos').append('<div class="photo add"><i class="fa fa-plus fa-2x"></i></div>');
			}
		}, function(props) {
			img.attr('data-prop', props.join('x'));
		});
		return false;
	});
	
	function addPhoto(data)
	{
		$('#images-block .photos').prepend('<div class="photo" data-id="'+data.id+'">'+
			'<a class="preview-image" href="#" data-url="/images/routs/'+data.routId+'/'+data.name+'_view.jpg">'+
				'<img class="img-thumbnail" src="/images/routs/'+data.routId+'/'+data.name+'_small.jpg" alt="" data-prop="'+(null !== data.previewProp ? data.previewProp : '')+'">'+
				'<i class="fa fa-pencil fa-2x"></i>'+
			'</a>'+
		'</div>');
		if (3 == $('.photos .photo:not(.add)').length) {
			$('.photo.add').remove();
		}
	}
});