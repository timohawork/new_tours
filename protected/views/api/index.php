<h1>Запрос:</h1>

<form id="request" class="form-horizontal" role="form" action="" method="POST">
	<div class="form-group">
		<label for="method-select" class="col-sm-3 control-label">Метод</label>
		<div class="col-sm-8">
			<select id="method-select" name="method" class="form-control">
				<option value="listing">listing</option>
				<option value="types_list">types_list</option>
				<option value="obj_get">obj_get</option>
				<option value="mark_edit">mark_edit</option>
				<option value="login">login</option>
			</select>
		</div>
	</div>
	<div id="request-inputs" class="form-group">
		<label for="type-title-input" class="col-sm-3 control-label">Данные</label>
		<div class="col-sm-8">
			<select id="type-select" name="type" class="form-control">
				<option value="regions" selected>regions</option>
				<option value="cities">cities</option>
				<option value="groups">groups</option>
			</select>
			<br>
			<input id="listing-type-id-input" type="text" name="id" class="form-control" placeholder="ID">
		</div>
	</div>
	<a href="#" class="btn btn-primary">Отправить</a>
</form>

<h1>Ответ:</h1>

<div id="response">
	<div class="row">
		<div class="col-md-1"><h3>Type:</h3></div>
		<div class="col-md-9" id="response-type"></div>
	</div>
	<div class="row error-row hide">
		<div class="col-md-1"><h3>Error:</h3></div>
		<div class="col-md-9" id="response-errors"></div>
	</div>
	<div class="row">
		<div class="col-md-1"><h3>Data:</h3></div>
		<div class="col-md-9" id="response-data"></div>
	</div>
</div>