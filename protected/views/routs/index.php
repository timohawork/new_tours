<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Маршруты</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('layouts/list', array(
			'routs' => $routs
		)); ?>
	</div>
</div>