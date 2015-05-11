<div id="rout-edit" class="panel panel-default">
	<div class="panel-heading">
		<h1><?=$model->isNewRecord ? 'Новая экскурсия' : 'Редактирование экскурсии'?></h1>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active"><a href="#main" data-toggle="tab">Основная</a></li>
			<li><a href="#serice" data-toggle="tab">Сервисная</a></li>
			<li><a href="#report" data-toggle="tab">Отчётная</a></li>
		</ul>
		<form class="form-horizontal" role="form" action="" method="POST">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="main">
					<div class="form-group">
						<label for="title" class="col-sm-3 control-label">Название</label>
						<div class="col-sm-9">
							<input id="title" type="text" name="title" data-validate="required:0" class="form-control" value="<?=$model->title?>">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-3 control-label">Описание</label>
						<div class="col-sm-9">
							<textarea id="description" name="description" rows="4" data-validate="required:0" class="form-control"><?=$model->description?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="rout-id" class="col-sm-3 control-label">Маршрут</label>
						<div class="col-sm-9">
							<select id="rout-id" name="routId" class="form-control" data-validate="required:1">
								<option value="">Не выбран</option>
								<?php foreach ($routs as $rout) : ?>
									<option value="<?=$rout->id?>"<?=$model->routId == $rout->id ? ' selected' : ''?>><?=$rout->title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Фотографии</label>
						<div id="images-block" class="col-sm-9">
							<div class="photos-group">
								<div class="photos">
									<?php if (!empty($model->routId)) : ?>
										<?php foreach ($model->rout->images as $image) : ?>
											<div class="photo" data-id="<?=$image->id?>">
												<a class="preview-image" href="#" data-url="<?=$image->getUrl('view')?>">
													<img class="img-thumbnail" src="<?=$image->getUrl()?>" alt="">
												</a>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="type" class="col-sm-3 control-label">Тип</label>
						<div class="col-sm-9">
							<div class="radio">
								<label>
									<input type="radio" name="type" value="<?=Tours::TYPE_INDIVID?>"<?=$model->type == Tours::TYPE_INDIVID ? ' checked' : ''?>>
									индивидуальная
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="type" value="<?=Tours::TYPE_GROUP?>"<?=$model->type == Tours::TYPE_GROUP ? ' checked' : ''?>>
									групповая
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Всего человек</label>
						<div class="col-sm-2">
							<input id="total-pass" type="number" name="totalPass" data-validate="required:1;min:0" class="form-control" value="<?=$model->totalPass?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Наличие детей</label>
						<div class="col-sm-2">
							<input id="child-pass" type="number" name="childPass" data-validate="required:1;min:0" class="form-control" value="<?=$model->childPass?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Наличие инвалидов</label>
						<div class="col-sm-2">
							<input id="invalid-pass" type="number" name="invalidPass" data-validate="required:1;min:0" class="form-control" value="<?=$model->invalidPass?>">
						</div>
					</div>
					<div class="form-group">
						<label for="date-begin" class="col-sm-3 control-label">Дата и время начала</label>
						<div class="col-sm-2">
							<input id="start-date" type="text" name="startDate" data-validate="required:1" class="form-control" value="<?=DateHelper::getDate($model->startDate)?>">
						</div>
						<div class="col-sm-2">
							<input id="start-time" type="text" name="startTime" data-validate="required:1" class="form-control timepicker" value="00:00">
						</div>
					</div>
					<div class="form-group">
						<label for="date-end" class="col-sm-3 control-label">Дата и время конца</label>
						<div class="col-sm-2">
							<input id="finish-date" type="text" name="finishDate" data-validate="required:1" class="form-control" value="<?=DateHelper::getDate($model->finishDate)?>">
						</div>
						<div class="col-sm-2">
							<input id="finish-time" type="text" name="finishTime" class="form-control timepicker" value="00:00" disabled>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label><input name="isAction" type="checkbox"<?=$model->isAction ? ' checked' : ''?>> акционная</label>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="serice">
					<div class="form-group">
						<label for="guide-id" class="col-sm-3 control-label">Гид</label>
						<div class="col-sm-9">
							<select id="guide-id" name="guideId" class="form-control" data-validate="required:1">
								<option value="">Не выбран</option>
								<?php foreach ($guides as $guide) : ?>
									<option value="<?=$guide->id?>"<?=$model->guideId == $guide->id ? ' selected' : ''?>><?=$guide->name?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="car-id" class="col-sm-3 control-label">Транспорт</label>
						<div class="col-sm-9">
							<select id="car-id" name="carId" class="form-control" data-validate="required:1">
								<option value="">Не выбран</option>
								<?php foreach ($cars as $car) : ?>
									<option value="<?=$car->id?>"<?=$model->carId == $car->id ? ' selected' : ''?>><?=$car->name?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="report">
					<div class="form-group">
						<label for="guide-cost" class="col-sm-3 control-label">Стоимость гида</label>
						<div class="col-sm-9">
							<input id="guide-cost" type="text" name="guideCost" data-validate="required:0" class="form-control" value="<?=$model->guideCost?>">
						</div>
					</div>
					<div class="form-group">
						<label for="car-cost" class="col-sm-3 control-label">Стоимость транспорта</label>
						<div class="col-sm-9">
							<input id="car-cost" type="text" name="carCost" data-validate="required:0" class="form-control" value="<?=$model->carCost?>">
						</div>
					</div>
					<div class="form-group">
						<label for="expenses" class="col-sm-3 control-label">Организационные расходы</label>
						<div class="col-sm-9">
							<input id="expenses" type="text" name="expenses" data-validate="required:0" class="form-control" value="<?=$model->expenses?>">
						</div>
					</div>
					<div class="form-group">
						<label for="margin" class="col-sm-3 control-label">Маржа</label>
						<div class="col-sm-9">
							<input id="margin" type="text" name="margin" data-validate="required:0" class="form-control" value="<?=$model->margin?>">
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
	</div>
</div>