<div id="rout-edit" class="panel panel-default">
	<div class="panel-heading">
		<h1><?=$model->isNewRecord ? 'Новый маршрут' : 'Редактирование маршрута'?></h1>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active"><a href="#main" data-toggle="tab">Основная</a></li>
			<li><a href="#points" data-toggle="tab">Объекты</a></li>
		</ul>
		<form class="form-horizontal" role="form" action="" method="POST">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="main">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Название</label>
						<div class="col-sm-10">
							<input id="title" type="text" name="title" data-validate="required:1" class="form-control" value="<?=$model->title?>">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Описание</label>
						<div class="col-sm-10">
							<textarea id="description" name="description" rows="4" data-validate="required:0" class="form-control"><?=$model->description?></textarea>
						</div>
					</div>
					<?php if (!$model->isNewRecord) : ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Фотографии</label>
							<div id="images-block" class="col-sm-10">
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
						<label for="complexity" class="col-sm-2 control-label">Сложность</label>
						<div class="col-sm-2">
							<select id="complexity" name="complexity" class="form-control">
								<?php for ($i = 1; $i <= 5; $i++) : ?>
									<option value="<?=$i?>"<?=$i == $model->complexity ? ' selected' : ''?>><?=$i?></option>
								<?php endfor; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="points">
					<div class="form-group">
						<label for="start-point" class="col-sm-2 control-label">Стартовый</label>
						<div class="col-sm-10">
							<select id="start-point" name="startPoint" data-validate="required:1" class="form-control">
								<option value="">Не выбрано</option>
								<?php foreach ($points as $point) : ?>
									<option value="<?=$point->id?>"<?=!empty($routPoints['start']) && $routPoints['start']->id == $point->id ? ' selected' : ''?>><?=$point->title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="end-point" class="col-sm-2 control-label">Финишный</label>
						<div class="col-sm-10">
							<select id="end-point" name="endPoint" data-validate="required:1" class="form-control">
								<option value="">Не выбрано</option>
								<?php foreach ($points as $point) : ?>
									<option value="<?=$point->id?>"<?=!empty($routPoints['finish']) && $routPoints['finish']->id == $point->id ? ' selected' : ''?>><?=$point->title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group" data-type="required">
						<label class="col-sm-2 control-label">Обязательные</label>
						<div class="col-sm-10 for-points-list">
							<select name="" class="form-control">
								<option value=""></option>
								<?php foreach ($points as $point) : ?>
									<option value="<?=$point->id?>"><?=$point->title?></option>
								<?php endforeach; ?>
							</select>
							<a href="#" class="btn btn-info add-line"><i class="fa fa-plus"></i></a>
							<table class="table table-hover rout-points-list">
								<tbody>
									<?php foreach ($routPoints['required'] as $point) : ?>
										<tr>
											<td class="title"><?=$point->title?></td>
											<td class="time"><input class="form-control timepicker" name="required_time[]" type="text" value="<?=$point->time?>"></td>
											<td class="del">
												<input type="hidden" name="required_id[]" value="<?=$point->id?>">
												<i class="fa fa-trash-o fa-lg"></i>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form-group" data-type="additional">
						<label class="col-sm-2 control-label">Дополнительные</label>
						<div class="col-sm-10 for-points-list">
							<select name="" class="form-control">
								<option value=""></option>
								<?php foreach ($points as $point) : ?>
									<option value="<?=$point->id?>"><?=$point->title?></option>
								<?php endforeach; ?>
							</select>
							<a href="#" class="btn btn-info add-line"><i class="fa fa-plus"></i></a>
							<table class="table table-hover rout-points-list">
								<tbody>
									<?php foreach ($routPoints['additional'] as $point) : ?>
										<tr>
											<td class="title"><?=$point->title?></td>
											<td class="time"><input class="form-control timepicker" name="additional_time[]" type="text" value="<?=$point->time?>"></td>
											<td class="del">
												<input type="hidden" name="additional_id[]" value="<?=$point->id?>">
												<i class="fa fa-trash-o fa-lg"></i>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8">
					<button type="button" class="btn btn-default">Отмена</button>
					<button type="submit" class="btn btn-primary">Сохранить</button>
				</div>
			</div>
		</form>
		<form id="rout-image-form" class="hide" action="/photos/upload" method="POST">
			<input id="rout-photo-id-image" type="hidden" name="routPhotoId" value="">
			<input id="rout-id-image" type="hidden" name="routId" value="<?=!$model->isNewRecord ? $model->id : 0?>">
			<input id="rout-image-file" type="file" name="photo">
		</form>
	</div>
</div>