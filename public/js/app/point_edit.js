$(document).ready(function() {
	var imageEditor = new ImageEditor();
	
	$('.photo.add').live('click', function() {
		$('#point-photo-id-image').val('');
		$('#point-image-file').trigger('click');
		return false;
	});
	
	$('#point-image-file').live('change', function() {
		var selector = $('#point-photo-id-image').val().length ? $('#image-editor .photo-load') : $('#point-edit .photo-load');
		$('#point-image-form').ajaxForm({
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
					var fullName = '/images/points/'+response.data.pointId+'/'+response.data.name;
					$('.photo[data-id="'+response.data.id+'"] img').attr('src', fullName+'_small.jpg');
					$('#image-editor .image-frame img').attr('src', fullName+'_view.jpg');
				}
			}
		}).submit();
		return false;
	});
	
	$('.photo').live('click', function() {
		var self = $(this),
			img = $(this).find('img'),
			prop = img.attr('data-prop');
		if (!undef(prop) && prop.length) {
			prop = prop.split('x');
		}
		imageEditor.init($('#title').val(), img.attr('src').replace('_small', '_view'), self.attr('data-id'), 'points', prop, function() {
			$('#point-photo-id-image').val(self.attr('data-id'));
			$('#point-image-file').trigger('click');
		}, function() {
			self.remove();
			var count = $('#point-edit .photos .photo:not(.add)').length;
			if (3 > count && !$('#point-edit .photo.add').length) {
				$('#point-edit .photos').append('<div class="photo add"><i class="fa fa-plus fa-2x"></i></div>');
			}
		}, function(props) {
			img.attr('data-prop', props.join('x'));
		});
		return false;
	});
	
	$('.btn-primary').live('click', function() {
		if (!isValidate('.form-horizontal')) {
			return false;
		}
	});
	
	$('#add-map').live('click', function() {
		$('#map-marker').fadeIn(300);
		setMap('#map-marker', true, $('#ll').val());
		return false;
	});
	
	function addPhoto(data)
	{
		$('#images-block .photos').prepend('<div class="photo" data-id="'+data.id+'">'+
			'<img class="img-rounded" src="/images/points/'+data.pointId+'/'+data.name+'_small.jpg" alt="" data-prop="'+(null !== data.previewProp ? data.previewProp : '')+'">'+
		'</div>');
		if (3 == $('.photos .photo:not(.add)').length) {
			$('.photo.add').remove();
		}
	}
});