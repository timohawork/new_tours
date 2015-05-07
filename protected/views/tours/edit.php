<h1>Редактирование экскурсии</h1>
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
					<input id="title" type="text" name="title" data-validate="required:1" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="description" class="col-sm-3 control-label">Описание</label>
				<div class="col-sm-9">
					<textarea id="description" name="description" rows="4" data-validate="required:0" class="form-control"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="rout-id" class="col-sm-3 control-label">Маршрут</label>
				<div class="col-sm-9">
					<select id="rout-id" name="routId" class="form-control">
						<option value="0">Пока пусто</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Фотографии</label>
				<div id="images-block" class="col-sm-9"></div>
			</div>
			<div class="form-group">
				<label for="type" class="col-sm-3 control-label">Тип</label>
				<div class="col-sm-9">
					<div class="radio">
						<label>
							<input type="radio" name="type" value="0" checked>
							индивидуальная
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="type" value="1">
							групповая
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Всего человек</label>
				<div class="col-sm-9 text-only">0</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Наличие детей</label>
				<div class="col-sm-9 text-only">0</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Наличие инвалидов</label>
				<div class="col-sm-9 text-only">0</div>
			</div>
			<div class="form-group">
				<label for="date-begin" class="col-sm-3 control-label">Дата и время начала</label>
				<div class="col-sm-3">
					<input id="date-begin" type="text" name="dateBegin" data-validate="required:1" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="date-end" class="col-sm-3 control-label">Дата и время конца</label>
				<div class="col-sm-3">
					<input id="date-end" type="text" name="dateEnd" data-validate="required:1" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<div class="checkbox">
						<label><input type="checkbox"> акционная</label>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="serice">
			<div class="form-group">
				<label for="guide-id" class="col-sm-3 control-label">Гид</label>
				<div class="col-sm-9">
					<select id="guide-id" name="guideId" class="form-control">
						<option value="0">Внук Сусанина</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="car-id" class="col-sm-3 control-label">Транспорт</label>
				<div class="col-sm-9">
					<select id="car-id" name="carId" class="form-control">
						<option value="0">Аэробус</option>
					</select>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="report">
			<div class="form-group">
				<label for="guide-cost" class="col-sm-3 control-label">Стоимость гида</label>
				<div class="col-sm-2">
					<input id="guide-cost" type="number" name="guideCost" data-validate="required:0;min:0" class="form-control" value="0">
				</div>
			</div>
			<div class="form-group">
				<label for="car-cost" class="col-sm-3 control-label">Стоимость транспорта</label>
				<div class="col-sm-2">
					<input id="car-cost" type="number" name="carCost" data-validate="required:0;min:0" class="form-control" value="0">
				</div>
			</div>
			<div class="form-group">
				<label for="expenses" class="col-sm-3 control-label">Организационные расходы</label>
				<div class="col-sm-2">
					<input id="expenses" type="number" name="expenses" data-validate="required:0;min:0" class="form-control" value="0">
				</div>
			</div>
			<div class="form-group">
				<label for="margin" class="col-sm-3 control-label">Маржа</label>
				<div class="col-sm-2">
					<input id="margin" type="number" name="margin" data-validate="required:0;min:0" class="form-control" value="0">
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
</form>
<form id="group-image-form" class="hide" action="/photos/upload" method="POST">
	<input id="group-id-image" type="hidden" name="groupId" value="">
	<input id="group-image-file" type="file" name="photo">
</form>