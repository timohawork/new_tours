<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Регионы</h1>
		<i id="region-add" class="fa fa-plus fa-2x"></i>
		<?php /*<input id="listing_date" class="form-control" name="date" type="text" value="<?=$date?>">*/ ?>
	</div>
	<div id="listing" class="panel-body">
		<?php $this->renderPartial('layouts/listing', array(
			'regions' => $regions,
			'isAdmin' => $isAdmin
		)); ?>
	</div>
</div>

<?php $this->renderPartial('region_edit', array(
	'points' => $points
)); ?>