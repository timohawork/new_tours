<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Редактирование объекта</h1>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active"><a href="#main" data-toggle="tab">Основная</a></li>
			<li><a href="#serice" data-toggle="tab">Сервисная</a></li>
		</ul>
		<form class="form-horizontal" role="form" action="" method="POST">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="main">
					<div class="form-group">
						<label for="title" class="col-sm-3 control-label">Название</label>
						<div class="col-sm-9">
							<input id="title" type="text" name="title" data-validate="required:1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="short-desc" class="col-sm-3 control-label">Краткое описание</label>
						<div class="col-sm-9">
							<textarea id="short-desc" name="shortDesc" rows="2" data-validate="required:0" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="full-desc" class="col-sm-3 control-label">Дополнительное описание</label>
						<div class="col-sm-9">
							<textarea id="full-desc" name="fullDesc" rows="4" data-validate="required:0" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Фотографии</label>
						<div id="point-images-block" class="col-sm-9"></div>
					</div>
					<div class="form-group">
						<label for="ll" class="col-sm-3 control-label">Координаты</label>
						<div class="col-sm-9">
							<input id="ll" type="text" name="ll" data-validate="required:0" class="form-control">
							<a id="add-map" class="btn btn-info" href=""><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="form-group hide">
						<div id="map-marker"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Дополнительные объекты</label>
						<div class="col-sm-9"></div>
					</div>
					<div class="form-group">
						<label for="rating" class="col-sm-3 control-label">Рейтинг настоящий</label>
						<div class="col-sm-2">
							<input id="rating" type="number" name="rating" data-validate="required:1;min:0" class="form-control" value="0">
						</div>
					</div>
					<div class="form-group">
						<label for="rating-teh" class="col-sm-3 control-label">Рейтинг технический</label>
						<div class="col-sm-2">
							<input id="rating-teh" type="text" name="ratingTeh" data-validate="required:1;min:0" class="form-control" value="0">
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="serice">
					<div class="form-group">
						<label for="phone" class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-9">
							<input id="phone" type="text" name="phone" data-validate="required:0" class="form-control" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="address" class="col-sm-3 control-label">Адрес</label>
						<div class="col-sm-9">
							<input id="address" type="text" name="phone" data-validate="required:0" class="form-control" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Почта</label>
						<div class="col-sm-9">
							<input id="email" type="text" name="phone" data-validate="required:0" class="form-control" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="work-time" class="col-sm-3 control-label">Время работы</label>
						<div class="col-sm-9">
							<input id="work-time" type="text" name="workTime" data-validate="required:0" class="form-control" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="comment" class="col-sm-3 control-label">Комментарии</label>
						<div class="col-sm-9">
							<textarea id="comment" name="comment" data-validate="required:0" class="form-control" rows="4"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="max-count" class="col-sm-3 control-label">Максимальная группа</label>
						<div class="col-sm-2">
							<input id="max-count" type="number" name="maxCount" data-validate="required:0;min:0" class="form-control" value="0">
						</div>
					</div>
					<div class="form-group">
						<label for="rating-inside" class="col-sm-3 control-label">Внутренний рейтинг</label>
						<div class="col-sm-2">
							<input id="rating-inside" type="number" name="ratingInside" data-validate="required:0;min:0" class="form-control" value="0">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" class="btn btn-default">Отмена</button>
					<button type="button" class="btn btn-primary">ОК</button>
				</div>
			</div>
			<div class="form-group photo-load"></div>
			<input id="group-id" type="hidden" name="id" value="">
		</form>
		<form id="group-image-form" class="hide" action="/photos/upload" method="POST">
			<input id="group-id-image" type="hidden" name="groupId" value="">
			<input id="group-image-file" type="file" name="photo">
		</form>
	</div>
</div>