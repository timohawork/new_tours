<div id="point-edit" class="panel panel-default">
	<div class="panel-heading">
		<h1><?=$model->isNewRecord ? 'Новый объект' : 'Редактирование объекта'?></h1>
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
							<input id="title" type="text" name="title" data-validate="required:1" class="form-control" value="<?=$model->title?>">
						</div>
					</div>
					<div class="form-group">
						<label for="short-desc" class="col-sm-3 control-label">Краткое описание</label>
						<div class="col-sm-9">
							<textarea id="short-desc" name="shortDesc" rows="2" data-validate="required:0" class="form-control"><?=$model->shortDesc?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="full-desc" class="col-sm-3 control-label">Дополнительное описание</label>
						<div class="col-sm-9">
							<textarea id="full-desc" name="fullDesc" rows="4" data-validate="required:0" class="form-control"><?=$model->fullDesc?></textarea>
						</div>
					</div>
					<?php if (!$model->isNewRecord) : ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Фотографии</label>
							<div id="images-block" class="col-sm-9">
								<div class="photos-group">
									<div class="photos">
										<?php foreach ($model->images as $image) : ?>
											<div class="photo" data-id="<?=$image->id?>">
												<a class="preview-image" data-url="<?=$image->getUrl('view')?>">
													<img class="img-thumbnail" src="<?=$image->getUrl()?>" alt="" data-prop="<?=$image->previewProp?>">
													<i class="fa fa-pencil fa-2x"></i>
												</a>
											</div>
										<?php endforeach; ?>
										<?php if (count($model->images) < 3) : ?>
											<div class="photo add"><i class="fa fa-plus fa-2x"></i></div>
										<?php endif; ?>
									</div>
								</div>
								<div class="photo-load"></div>
							</div>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="ll" class="col-sm-3 control-label">Координаты</label>
						<div class="col-sm-9">
							<input id="ll" type="text" name="ll" data-validate="required:0" class="form-control" value="<?=$model->ll?>">
							<a id="add-map" class="btn btn-info" href=""><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div id="map-marker"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Дополнительные объекты</label>
						<div class="col-sm-9"></div>
					</div>
					<div class="form-group">
						<label for="rating" class="col-sm-3 control-label">Рейтинг настоящий</label>
						<div class="col-sm-2">
							<input id="rating" type="number" name="rating" data-validate="required:1;min:0" class="form-control" value="<?=ArrayHelper::val($model, 'rating', 0)?>">
						</div>
					</div>
					<div class="form-group">
						<label for="rating-teh" class="col-sm-3 control-label">Рейтинг технический</label>
						<div class="col-sm-2">
							<input id="rating-teh" type="number" name="ratingTeh" data-validate="required:1;min:0" class="form-control" value="<?=ArrayHelper::val($model, 'ratingTeh', 0)?>">
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="serice">
					<div class="form-group">
						<label for="phone" class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-9">
							<input id="phone" type="text" name="phone" data-validate="required:0" class="form-control" value="<?=$model->phone?>">
						</div>
					</div>
					<div class="form-group">
						<label for="address" class="col-sm-3 control-label">Адрес</label>
						<div class="col-sm-9">
							<input id="address" type="text" name="address" data-validate="required:0" class="form-control" value="<?=$model->address?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Почта</label>
						<div class="col-sm-9">
							<input id="email" type="text" name="email" data-validate="required:0" class="form-control" value="<?=$model->email?>">
						</div>
					</div>
					<div class="form-group">
						<label for="work-time" class="col-sm-3 control-label">Время работы</label>
						<div class="col-sm-9">
							<input id="work-time" type="text" name="workTime" data-validate="required:0" class="form-control" value="<?=$model->workTime?>">
						</div>
					</div>
					<div class="form-group">
						<label for="comment" class="col-sm-3 control-label">Комментарии</label>
						<div class="col-sm-9">
							<textarea id="comment" name="comment" data-validate="required:0" class="form-control" rows="4"><?=$model->comment?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="max-count" class="col-sm-3 control-label">Максимальная группа</label>
						<div class="col-sm-2">
							<input id="max-count" type="number" name="maxCount" data-validate="required:0;min:0" class="form-control" value="<?=ArrayHelper::val($model, 'maxCount', 0)?>">
						</div>
					</div>
					<div class="form-group">
						<label for="rating-inside" class="col-sm-3 control-label">Внутренний рейтинг</label>
						<div class="col-sm-2">
							<input id="rating-inside" type="number" name="ratingInside" data-validate="required:0;min:0" class="form-control" value="<?=ArrayHelper::val($model, 'ratingInside', 0)?>">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="button" class="btn btn-default">Отмена</button>
					<button type="submit" class="btn btn-primary">Сохранить</button>
				</div>
			</div>
		</form>
		<form id="point-image-form" class="hide" action="/photos/upload" method="POST">
			<input id="point-photo-id-image" type="hidden" name="pointPhotoId" value="">
			<input id="point-id-image" type="hidden" name="pointId" value="<?=!$model->isNewRecord ? $model->id : 0?>">
			<input id="point-image-file" type="file" name="photo">
		</form>
	</div>
</div>