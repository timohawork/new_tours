<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Транспорт</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div id="cars_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'cars' => $cars
		)); ?>
	</div>
</div>

<div id="car-edit" class="modal fade">
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
						<label for="type-select" class="col-sm-3 control-label">Тип</label>
						<div class="col-sm-8">
							<select id="type-select" name="type" data-validate="required:1" class="form-control">
								<option value="">Не выбран</option>
								<?php foreach (Cars::typesList() as $id => $type) : ?>
									<option value="<?=$id?>"><?=$type?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="pass-count-input" class="col-sm-3 control-label">Кол-во пассажиров</label>
						<div class="col-sm-3">
							<input id="pass-count-input" type="number" name="passCount" data-validate="required:1;min:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="comfort-select" class="col-sm-3 control-label">Степень комфорта</label>
						<div class="col-sm-8">
							<select id="comfort-select" name="comfort" data-validate="required:1" class="form-control">
								<?php for ($i = 0; $i <= 5; $i++) : ?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php endfor; ?>
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
							<input id="base-input" type="text" name="baseRegion" data-validate="required:1" class="form-control">
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
					<input id="car-id" type="hidden" name="id" value="">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>