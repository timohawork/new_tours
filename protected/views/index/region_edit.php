<div id="region-edit" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Редактирование региона</h4>
			</div>
			<div class="modal-body">
				<a class="preview-image hide" data-url="">
					<img src="" alt="">
				</a>
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label for="region-name-input" class="col-sm-3 control-label">Название</label>
						<div class="col-sm-8">
							<input id="region-name-input" type="text" name="name" data-validate="required:1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="region-description-input" class="col-sm-3 control-label">Описание</label>
						<div class="col-sm-8">
							<textarea id="region-description-input" name="description" rows="3" data-validate="required:0" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Фотография</label>
						<div id="region-image" class="col-sm-8"></div>
					</div>
					<div class="form-group">
						<label for="region-start-point-input" class="col-sm-3 control-label">Базовая точка</label>
						<div class="col-sm-8">
							<select id="region-start-point-input" name="startPoint" data-validate="required:1" class="form-control">
								<?php foreach ($points as $point) : ?>
									<option value="<?=$point->id?>"><?=$point->title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="region-period-begin-input" class="col-sm-3 control-label">Временной период</label>
						<div class="col-sm-4">
							<input id="region-period-begin-input" type="text" name="periodBegin" data-validate="required:0" class="form-control">
						</div>
						<div class="col-sm-4">
							<input id="region-period-end-input" type="text" name="periodEnd" data-validate="required:0" class="form-control">
						</div>
					</div>
					<div class="form-group photo-load"></div>
					<input id="region-id" type="hidden" name="id" value="">
				</form>
				<form id="region-image-form" class="hide" action="/photos/upload" method="POST">
					<input id="region-id-image" type="hidden" name="regionId" value="">
					<input id="region-image-file" type="file" name="photo">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>