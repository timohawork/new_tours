<div class="ap-blocks-list">
	<?php foreach ($tours as $tour) : ?>
		<div class="ap-blocks-block<?=$tour->active ? ' active' : ''?>" data-id="<?=$tour->id?>">
			<i class="fa fa-times fa-2x"></i>
			<?php if (count($tour->rout->images)) : ?>
				<img class="img-thumbnail" src="<?=$tour->rout->images[0]->getUrl('small')?>" alt="">
			<?php else : ?>
				<span class="fa-stack fa-2x no-photo">
					<i class="fa fa-camera fa-stack-1x"></i>
					<i class="fa fa-ban fa-stack-2x text-danger"></i>
				</span>
			<?php endif; ?>
			<span class="title"><?=$tour->title?></span>
			<i class="fa fa-check fa-2x"></i>
		</div>
	<?php endforeach; ?>
</div>