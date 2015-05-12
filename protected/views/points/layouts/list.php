<div class="ap-blocks-list">
	<?php foreach ($points as $point) : ?>
		<div class="ap-blocks-block<?=$point->active ? ' active' : ''?>" data-id="<?=$point->id?>">
			<?php if (count($point->images)) : ?>
				<img class="img-rounded" src="<?=$point->images[0]->getUrl('small')?>" alt="">
			<?php else : ?>
				<span class="fa-stack fa-2x no-photo">
					<i class="fa fa-camera fa-stack-1x"></i>
					<i class="fa fa-ban fa-stack-2x text-danger"></i>
				</span>
			<?php endif; ?>
			<span class="title"><?=$point->title?></span>
			<i class="fa fa-check fa-2x"></i>
			<i class="fa fa-times fa-2x"></i>
		</div>
	<?php endforeach; ?>
</div>