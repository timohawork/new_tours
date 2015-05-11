<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Клиенты</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div id="clients_list" class="panel-body table-listing">
		<?php $this->renderPartial('layouts/list', array(
			'clients' => $clients
		)); ?>
	</div>
</div>

<div id="client-edit" class="modal fade">
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
						<label for="login-input" class="col-sm-3 control-label">Логин</label>
						<div class="col-sm-8">
							<input id="login-input" type="text" name="login" class="form-control" data-validate="required:1;minLength:6">
						</div>
					</div>
					<div class="form-group">
						<label for="social-id-input" class="col-sm-3 control-label">Пароль</label>
						<div class="col-sm-8">
							<input id="password-input" type="password" name="password" class="form-control" data-validate="required:0">
						</div>
					</div>
					<div class="form-group">
						<label for="social-id-input" class="col-sm-3 control-label">Пароль ещё раз</label>
						<div class="col-sm-8">
							<input id="password-repeat-input" type="password" name="passwordRepeat" class="form-control" data-validate="compare:password-input">
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="name-input" class="col-sm-3 control-label">Имя</label>
						<div class="col-sm-8">
							<input id="name-input" type="text" name="name" data-validate="required:1" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="phone-input" class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-8">
							<input id="phone-input" type="text" name="phone" data-validate="required:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="email-input" class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-8">
							<input id="email-input" type="text" name="email" data-validate="required:0" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="uid-input" class="col-sm-3 control-label">ID в системе</label>
						<div class="col-sm-8">
							<input id="uid-input" type="text" name="uid" class="form-control" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="social-id-input" class="col-sm-3 control-label">ID соцсетей</label>
						<div class="col-sm-8">
							<input id="social-id-input" type="text" name="socialId" class="form-control">
						</div>
					</div>
					<input id="client-id" type="hidden" name="id" value="">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">ОК</button>
			</div>
		</div>
	</div>
</div>