<div class="panel panel-default">
	<div class="panel-heading">
		<a href="/tours/edit/date/<?=$date?>" class="left-side"><i class="fa fa-plus fa-3x"></i></a>
		<h1>Заявки на <?=$date?></h1>
		<div class="indicators">
			<div class="indicator tours"><i class="fa fa-flag fa-2x"></i> <span><?=count($tours)?></span></div>
			<div class="indicator placed"><i class="fa fa-users fa-2x"></i> <span><?=$indicators['placed']?></span></div>
			<div class="indicator not-placed<?=$indicators['notPlaced'] > 0 ? ' active' : ''?>"><i class="fa fa-exclamation fa-2x"></i> <span><?=$indicators['notPlaced']?></span></div>
		</div>
	</div>
	<div id="orders_list" class="panel-body">
		<?php $this->renderPartial('layouts/list', array(
			'tours' => $tours
		)); ?>
	</div>
</div>

<div id="order-edit" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Редактирование заявки</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label for="guide-id" class="col-sm-3 control-label">Гид</label>
						<div class="col-sm-9">
							<select id="guide-id" name="guideId" class="form-control" data-validate="required:1">
								<option value="">Не выбран</option>
								<?php foreach ($guides as $guide) : ?>
									<option value="<?=$guide->id?>"><?=$guide->name?></option>
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
									<option value="<?=$car->id?>"><?=$car->name?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select id="not-placed" name="" class="form-control"></select>
							<a href="#" class="btn btn-info add-line"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<table class="table table-hover table-striped">
						<thead>
							<th>Клиент</th>
							<th>Кол-во пассажиров</th>
							<th>Оплата</th>
							<th></th>
						</thead>
						<tbody></tbody>
					</table>
					<input id="order-id" type="hidden" name="id" value="">
				</form>
				<div id="error-alert" class="alert alert-danger">
					<strong>Ошибка!</strong> Не хватает мест в транспорте. <a href="#" class="alert-link">Разбить?</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div id="order-new" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Новая заявка</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label for="guide-id" class="col-sm-3 control-label">Гид</label>
						<div class="col-sm-9">
							<select id="guide-id" name="guideId" class="form-control" data-validate="required:1">
								<option value="">Не выбран</option>
								<?php foreach ($guides as $guide) : ?>
									<option value="<?=$guide->id?>"><?=$guide->name?></option>
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
									<option value="<?=$car->id?>"><?=$car->name?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<table class="table table-hover table-striped">
						<thead>
							<th>Клиент</th>
							<th>Кол-во пассажиров</th>
							<th>Оплата</th>
							<th></th>
						</thead>
						<tbody></tbody>
					</table>
					<input id="tour-id" type="hidden" name="tourId" value="">
				</form>
				<div id="error-alert" class="alert alert-danger">
					<strong>Ошибка!</strong> Не хватает мест в транспорте. <a href="#" class="alert-link">Разбить?</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>