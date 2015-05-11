<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Гиды</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div id="guides_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'guides' => $guides
		)); ?>
	</div>
</div>

<div id="guide-edit" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<a class="preview-image hide" data-url="">
					<img src="" alt="">
				</a>
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label for="name-input" class="col-sm-3 control-label">Имя</label>
						<div class="col-sm-8">
							<input id="name-input" type="text" name="name" data-validate="required:1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="spec-select" class="col-sm-3 control-label">Специализация</label>
						<div class="col-sm-8">
							<select id="spec-select" name="spec" data-validate="required:1" class="form-control">
								<option value="">Не выбрана</option>
								<?php foreach (Guides::specList() as $id => $spec) : ?>
									<option value="<?=$id?>"><?=$spec?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="phone-input" class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-8">
							<input id="phone-input" type="text" name="phone" data-validate="required:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="rating-input" class="col-sm-3 control-label">Рейтинг</label>
						<div class="col-sm-3">
							<input id="rating-input" type="number" name="rating" data-validate="required:1;min:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="base-input" class="col-sm-3 control-label">Регион базирования</label>
						<div class="col-sm-8">
							<input id="base-input" type="text" name="baseRegion" data-validate="required:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Регионы работы</label>
						<div class="col-sm-8 regions">
							<?php foreach ($regions as $region) : ?>
								<div><label><input type="checkbox" name="regions[<?=$region->id?>]"> <?=$region->title?></label></div>
							<?php endforeach; ?>
						</div>
					</div>
					<input id="guide-id" type="hidden" name="id" value="">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>