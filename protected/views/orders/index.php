<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Заявки</h1>
		<?php /*<i id="add-new" class="fa fa-plus fa-2x"></i>*/ ?>
	</div>
	<div id="orders_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'orders' => $orders
		)); ?>
	</div>
</div>

<div id="order-edit" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" action="" method="POST">
					<div class="form-group">
						<label class="col-sm-3 control-label">Клиент</label>
						<div id="client-name" class="col-sm-8 text-only"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Контактный телефон</label>
						<div id="client-phone" class="col-sm-8 text-only"></div>
					</div>
					<div class="form-group">
						<label for="tour-id" class="col-sm-3 control-label">Экскурсия</label>
						<div class="col-sm-8">
							<select id="tour-id" class="form-control" name="tourId" data-validate="required:1;">
								<option value="">Не выбрана</option>
								<?php foreach ($tours as $tour) : ?>
									<option value="<?=$tour->id?>"><?=$tour->title?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="pass-count" class="col-sm-3 control-label">Кол-во пассажиров</label>
						<div class="col-sm-2">
							<input id="pass-count" type="number" name="passCount" class="form-control" data-validate="required:1;min:0">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Степень конфортности</label>
						<div id="comfort" class="col-sm-8 text-only"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Стартовая точка</label>
						<div id="start-object" class="col-sm-8 text-only"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-8">
							<div class="checkbox">
								<label><input id="is-paid" type="checkbox" name="isPaid"> оплачена?</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="payment-type" class="col-sm-3 control-label">Тип оплаты</label>
						<div class="col-sm-8">
							<select id="payment-type" class="form-control" name="paymentType" data-validate="">
								<?php foreach (Orders::paymentTypes() as $type => $desc) : ?>
									<option value="<?=$type?>"><?=$desc?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="summ" class="col-sm-3 control-label">Сумма</label>
						<div class="col-sm-3">
							<input id="summ" type="number" name="summ" data-validate="" class="form-control">
						</div>
					</div>
					<input id="order-id" type="hidden" name="id" value="">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</div>
</div>