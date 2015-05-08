function undef(value){
	return 'undefined' === typeof(value);
}

function setMap(selector, editable, value)
{
	var value = value.split(','),
		map = new YMaps.Map($(selector)),
		startPoint = new YMaps.GeoPoint(2 == value.length ? value[0] : 34.413538444787285, 2 == value.length ? value[1] : 45.32359471957162),
		placemark = new YMaps.Placemark(startPoint);
	map.setCenter(startPoint, 2 == value.length ? 12 : 8);
	map.addControl(new YMaps.TypeControl());
	map.addControl(new YMaps.Zoom());
	map.addOverlay(placemark);
	
	if (!undef(editable) && editable) {
		YMaps.Events.observe(map, map.Events.Click, function(map, mEvent) {
			if (!undef(placemark)) {
				map.removeOverlay(placemark);
			}
			var point = mEvent.getGeoPoint();
			$('#ll').val(point.getLng()+','+point.getLat());
			placemark = new YMaps.Placemark(point);
			map.addOverlay(placemark);
		}, this);
	}
}

$(document).ready(function() {
	$('form [data-validate]').live('change', function() {
		inputValidation($(this));
	});
	
	$('.dropdown-menu li').live('click', function() {
		$(this).parent().find('.active').removeClass('active');
		$(this).addClass('active');
	});
	
	$('#preview-image-block').live('click', function() {
		$(this).remove();
	});
	
	$(document).click(function() {
		var preview = $('#preview-image-block');
		if (preview.length) {
			preview.animate({opacity: 0}, 700, function() {
				preview.remove();
			});
			return false;
		}
	});
	
	setTimepickers();
	$(document).live('click', function(e) {
		if ($('.timepicker-toggle').length && !$(e.target).hasClass('timepicker') && !$(e.target).closest('.timepicker-toggle').length) {
			$('.timepicker-toggle').remove();
		}
	});
	
	$(".preview-image").live('click', function() {
		var block = $('<div id="preview-image-block"><img class="img-thumbnail" src="'+$(this).attr('data-url')+'" alt=""></div>');
		$('body').append(block);
		block.animate({opacity: 1}, 700);
		return false;
	});
});

function inputValidation(input)
{
	var tag = input.prop("tagName").toLowerCase(),
		value = input.val(),
		data = {},
		emailRegExp = /\S+@\S+\.\S+/,
		error;
	if (input.attr('data-validate')) {
		$.each(input.attr('data-validate').split(";"), function(key, params) {
			params = params.split(":");
			data[params[0]] = params[1];
		});
	}
	else {
		return;
	}

	if (!undef(data.required) && 1 == data.required && !value.length) {
		addError(input, 'Необходимо '+('select' === tag ? 'выбрать' : 'ввести')+' значение.');
	}
	else if (!undef(data.min) && parseInt(value) < data.min) {
		addError(input, 'Неверное значение.');
	}
	else if (!undef(data.email) && 1 == data.email && !emailRegExp.test(value)) {
		addError(input, 'Неверное значение.');
	}
	else if (!undef(data.minLength) && value.length && value.length < data.minLength) {
		addError(input, 'Минимум '+data.minLength+' символов.');
	}
	else if (!undef(data.compare) && $('#'+data.compare).val() !== value) {
		addError(input, 'Значения не совпадают.');
	}
	else {
		addSuccess(input);
	}
}

function isValidate(form)
{
	if ($(form+' [data-validate]').length != $(form+' .has-success').length) {
		$(form+' [data-validate]').each(function() {
			inputValidation($(this));
		});
		return $(form+' [data-validate]').length == $(form+' .has-success').length;
	}
	return true;
}

function addError(selector, text)
{
	var group = selector.closest('.form-group');
	group.removeClass('has-success')
		.addClass('has-error');
	if (undef(text) || !text) {
		return;
	}
	if (group.find('.help-block.error').length) {
		group.find('.help-block.error').text(text);
	}
	else {
		selector.parent().append('<p class="help-block error">'+text+'</p>');
	}
}

function addSuccess(selector)
{
	var group = selector.closest('.form-group');
	group.removeClass('has-error')
		.addClass('has-success')
		.find('.help-block.error').remove();
}

function removeErrors(form)
{
	var selector = $(form);
	selector.find('.has-error').removeClass('has-error');
	selector.find('.has-success').removeClass('has-success');
	selector.find('.help-block.error').remove();
}

var Folding = function()
{
	var self = this;
	
	self.regionsType = 'region';
	self.citiesType = 'city';
	self.groupsType = 'type-group';
	
	self.foldingValue = window.location.hash.replace('#', '');
	self.obj = {
		regions: [],
		cities: [],
		groups: []
	};
	
	self.init = function(saving) {
		var hash = self.foldingValue.split('&'),
			saving = undef(saving) || true === saving;
		$.each(hash, function(key, value) {
			var valueArray = value.split('=');
			if (self.regionsType === valueArray[0]) {
				saving && self.obj.regions.push(valueArray[1]);
				self.toggle(self.getCaret(self.regionsType, valueArray[1]), false);
			}
			else if (self.citiesType === valueArray[0]) {
				saving && self.obj.cities.push(valueArray[1]);
				self.toggle(self.getCaret(self.citiesType, valueArray[1]), false);
			}
			else if (self.groupsType === valueArray[0]) {
				saving && self.obj.groups.push(valueArray[1]);
				self.toggle(self.getCaret(self.groupsType, valueArray[1]), false);
			}
		});
	};
	
	self.getCaret = function(type, name) {
		return $('.'+type+'[data-id="'+name+'"]').find('.ap-caret').eq(0);
	};
	
	self.set = function(type, name, closing) {
		var result = '';
		
		if (!closing && type === self.regionsType) {
			self.obj.regions.push(name);
		}
		else if (!closing && type === self.citiesType) {
			self.obj.cities.push(name);
		}
		else if (!closing && type === self.groupsType) {
			self.obj.groups.push(name);
		}
		else if (closing && type === self.regionsType) {
			self.obj.regions.splice(self.obj.regions.indexOf(name), 1);
		}
		else if (closing && type === self.citiesType) {
			self.obj.cities.splice(self.obj.cities.indexOf(name), 1);
		}
		else if (closing && type === self.groupsType) {
			self.obj.groups.splice(self.obj.groups.indexOf(name), 1);
		}
		
		$.each(self.obj.regions, function(key, value) {
			result += '&'+self.regionsType+'='+value;
		});
		$.each(self.obj.cities, function(key, value) {
			result += '&'+self.citiesType+'='+value;
		});
		$.each(self.obj.groups, function(key, value) {
			result += '&'+self.groupsType+'='+value;
		});
		
		result = result.substring(1);
		window.location.hash = self.foldingValue = result;
	};
	
	self.toggle = function(selector, set) {
		var block = selector.closest('.ap-block'),
			closing = selector.hasClass('fa-caret-down'),
			name = block.attr('data-id');

		if (!closing) {
			selector.removeClass('fa-caret-right')
				.addClass('fa-caret-down');
		}
		else {
			selector.removeClass('fa-caret-down')
				.addClass('fa-caret-right');
		}
		
		block.find('.ap-block-body').eq(0).toggleClass('hide');
		if (block.hasClass('ap-group')) {
			block.toggleClass('open');
		}
		
		if (undefined === set || set) {
			var type;
			if (block.hasClass(self.regionsType)) {
				type = self.regionsType;
			}
			else if (block.hasClass(self.citiesType)) {
				type = self.citiesType;
			}
			else if (block.hasClass(self.groupsType)) {
				type = self.groupsType;
			}
			self.set(type, name, closing);
		}
	};
};

var ImageEditor = function(settings)
{
	var self = this,
		options = $.extend({
			editable: false,
			top: 200,
			left: 100,
			width: 600,
			height: 200,
			imageUrl: '',
			imageId: '',
			type: '',
			title: '',
			modal: '#image-editor',
			onRefresh: undefined,
			onDelete: undefined,
			onSave: function(props) {}
		}, settings);
	
	self.init = function(title, imageUrl, id, type, props, onRefresh, onDelete, onSave) {
		options.imageUrl = imageUrl;
		options.imageId = id;
		options.type = type;
		options.title = title;
		$(options.modal+' .modal-title').html(options.title);
		$(options.modal+' .image-frame img').attr('src', options.imageUrl);
		$(options.modal).modal('show');
		if (!undef(onRefresh)) {
			options.onRefresh = onRefresh;
		}
		if (!undef(onDelete)) {
			options.onDelete = onDelete;
		}
		if (!undef(onSave)) {
			options.onSave = onSave;
		}
		if (!undef(props) && props.length) {
			options.top = props[2];
			options.left = props[3];
			options.width = props[0];
			options.height = props[1];
		}
		else {
			options.top = 200;
			options.left = 100;
			options.width = 600;
			options.height = 200;
		}
		$(options.modal+' .frame').css({
			top: options.top+'px',
			left: options.left+'px',
			width: options.width+'px',
			height: options.height+'px'
		});
	};
	
	$(options.modal+' .frame-block').live('mousemove', function(e) {
		if (!options.editable) {
			return;
		}
		var offset = $(this).offset(),
			top = e.pageY - offset.top - 100,
			left = e.pageX - offset.left - 300;
		top = 0 > top ? 0 : top;
		options.top = 400 < top ? 400 : top;
		left = 0 > left ? 0 : left;
		options.left = 200 < left ? 200 : left;
		$(options.modal+' .frame').css({
			top: options.top+'px',
			left: options.left+'px'
		});
	});
	
	$(options.modal+' .frame').live('mousedown', function(e) {
		options.editable = !$(e.target).hasClass('ui-resizable-handle');
	});
	
	$(options.modal+' .frame').live('mouseup', function() {
		options.editable = false;
	});
	
	$(options.modal+' .frame').resizable({
		aspectRatio: 600 / 200,
		maxWidth: 600,
		minWidth: 200,
		stop: function(event, ui) {
			options.width = ui.size.width;
			options.height = ui.size.height;
		}
	});
	
	$(options.modal+' .frame').live('click', function() {
		options.editable = false;
	});
	
	$(options.modal+' .fa-refresh').live('click', function() {
		if (!undef(options.onRefresh)) {
			options.onRefresh();
		}
		return false;
	});
	
	$(options.modal+' .fa-trash-o').live('click', function() {
		if (!confirm('Вы уверены, что хотите удалить изображение?')) {
			return false;
		}
		$.ajax({
			url: '/photos/delete',
			type: "POST",
			async: true,
			data: {
				id: options.imageId,
				type: options.type
			},
			success: function() {
				if (!undef(options.onDelete)) {
					options.onDelete();
				}
				$(options.modal).modal('hide');
			}
		});
		return false;
	});
	
	$(options.modal+' .fa-check').live('click', function() {
		$.ajax({
			url: "/photos/frame_edit",
			type: "POST",
			async: true,
			cache: false,
			data: {
				type: options.type,
				id: options.imageId,
				top: options.top,
				left: options.left,
				width: options.width,
				height: options.height
			},
			success: function() {
				refreshImg();
				$(options.modal).modal('hide');
				if (!undef(options.onSave)) {
					options.onSave([options.width, options.height, options.top, options.left]);
				}
			}
		});
		return false;
	});
};

function refreshImg()
{
	$('img').each(function() {
		var src = $(this).attr('src').split("?");
		if (src[0].length && -1 == src[0].indexOf("http://")) {
			$(this).attr('src', src[0]+'?rand='+Math.random());
		}
	});
}

function setTimepickers()
{
	$('.timepicker').each(function() {
		var self = $(this),
			selfId = $('.timepicker[rel^="id_"]').length ? 'id_'+($('.timepicker[rel^="id_"]').length+1) : 'id_1',
			buttons = $('<div class="timepicker-toggle" rel="'+selfId+'">'+
				'<a href="#"><i class="fa fa-chevron-up hours"></i></a>'+
				'<a href="#"><i class="fa fa-chevron-down hours"></i></a>'+
				'<a href="#"><i class="fa fa-chevron-up mins"></i></a>'+
				'<a href="#"><i class="fa fa-chevron-down mins"></i></a>'+
			'</div>');
		if (self.hasClass('on')) {
			return true;
		}
		self.addClass('on');
		self.attr('rel', selfId);
		$(this).live('focus', function() {
			self.before(buttons);
			buttons.find('a').each(function() {
				$(this).live('click', function() {
					var input = $('.timepicker[rel="'+$(this).parent().attr('rel')+'"]'),
						isHour = $(this).children('.fa').hasClass('hours') ? 0 : 1,
						isUp = $(this).children('.fa').hasClass('fa-chevron-up'),
						time = input.val();
					time = time.length ? time.split(":") : ["00", "00"];
					if (isUp) {
						time[isHour] = parseInt(time[isHour]) + (!isHour ? 1 : 10);
					}
					else {
						time[isHour] = parseInt(time[isHour]) - (!isHour ? 1 : 10);
					}
					if (!isHour && 0 > time[isHour]) {
						time[isHour] = 23;
					}
					else if (!isHour && 24 == time[isHour]) {
						time[isHour] = 0;
					}
					else if (isHour && 0 > time[isHour]) {
						time[isHour] = 50;
					}
					else if (isHour && 60 == time[isHour]) {
						time[isHour] = 0;
					}
					time[isHour] = (10 > time[isHour] ? '0' : '')+time[isHour];
					input.val(time[0]+':'+time[1]);
					input.trigger('change');
					return false;
				});
			});
		});
	});
}