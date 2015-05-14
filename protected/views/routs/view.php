<div id="rout-edit" class="panel panel-default">
	<div class="panel-heading">
		<h1>Описание маршрута</h1>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			<li class="active"><a href="#main" data-toggle="tab">Основная</a></li>
			<li><a href="#regions" data-toggle="tab">Регионы</a></li>
			<li><a href="#points" data-toggle="tab">Объекты</a></li>
		</ul>
		<form class="form-horizontal" role="form" action="" method="POST">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="main">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Название</label>
						<div class="col-sm-10 text-only"><?=$model->title?></div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Описание</label>
						<div class="col-sm-10">
							<textarea id="description" name="description" rows="4" class="form-control"><?=$model->description?></textarea>
						</div>
					</div>
					<?php if (!$model->isNewRecord) : ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Фотографии</label>
							<div class="col-sm-10">
								<div class="photos-group">
									<div class="photos">
										<?php foreach ($model->images as $image) : ?>
											<div class="photo" data-id="<?=$image->id?>">
												<img class="img-rounded" src="<?=$image->getUrl()?>" alt="" data-prop="<?=$image->previewProp?>">
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="complexity" class="col-sm-2 control-label">Сложность</label>
						<div class="col-sm-2 text-only"><?=$model->complexity?></div>
					</div>
				</div>
				<div class="tab-pane fade" id="points">
					<div class="form-group">
						<label for="start-point" class="col-sm-2 control-label">Стартовый</label>
						<div class="col-sm-10 text-only"><?=$routPoints['start']->title?></div>
					</div>
					<div class="form-group">
						<label for="end-point" class="col-sm-2 control-label">Финишный</label>
						<div class="col-sm-10 text-only"><?=$routPoints['finish']->title?></div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Обязательные</label>
						<?php foreach ($routPoints['required'] as $point) : ?>
							<div class="col-sm-5 text-only"><?=$point->title?></div>
							<div class="col-sm-5 text-only"><?=substr($point->time, 0, 5)?></div>
						<?php endforeach; ?>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Дополнительные</label>
						<?php foreach ($routPoints['additional'] as $point) : ?>
							<div class="col-sm-5 text-only"><?=$point->title?></div>
							<div class="col-sm-5 text-only"><?=substr($point->time, 0, 5)?></div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="tab-pane fade" id="regions">
					<?php foreach ($model->regions as $region) : ?>
						<div class="form-group">
							<div class="col-sm-12 text-only"><?=$region->title?></div>
						</div>
						<?php foreach($region->regions as $child) : ?>
							<div class="form-group">
								<div class="col-sm-offset-1 col-sm-11 text-only"><?=$child->title?></div>
							</div>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</form>
	</div>
</div>