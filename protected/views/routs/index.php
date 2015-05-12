<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Маршруты</h1>
		<i id="add-new" class="fa fa-plus fa-2x"></i>
	</div>
	<div class="panel-body">
		<div class="list-filter">
			<select id="filter-region" name="regionId" class="form-control">
				<option value="">Выберите регион</option>
				<?php foreach ($regions as $region) : ?>
					<option class="parent" value="<?=$region->id?>"><?=$region->title?></option>
					<?php foreach($region->regions as $child) : ?>
						<option value="<?=$child->id?>">&mdash; <?=$child->title?></option>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</select>
		</div>
		<div id="routs_list">
			<?php $this->renderPartial('layouts/list', array(
				'routs' => $routs
			)); ?>
		</div>
	</div>
</div>