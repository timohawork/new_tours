<?php foreach ($regions as $region) : ?>
	<div class="ap-block region<?=$region->active ? ' active' : ''?>" data-id="<?=$region->id?>">
		<div class="ap-block-header">
			<i class="ap-caret fa fa-caret-right fa-2x"></i>
			<div class="title">
				<i class="fa fa-check fa-2x"></i>
				<?php if (!empty($region->image)) : ?>
					<img class="image" src="<?=RoutPhotos::DIR_NAME.'/regions/'.$region->id.'/'.$region->image.'_small.jpg'?>">
				<?php else : ?>
					<span class="fa-stack fa-lg image">
						<i class="fa fa-camera fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"></i>
					</span>
				<?php endif; ?>
				<h3><?=$region->title?></h3>
			</div>
			<i class="fa fa-plus fa-2x"></i>
			<i class="fa fa-pencil fa-2x"></i>
			<i class="fa fa-times fa-2x"></i>
		</div>
		<div class="ap-block-body hide">
			<?php foreach ($region->regions as $childRegion) : ?>
				<div class="ap-block region<?=$childRegion->active ? ' active' : ''?>" data-id="<?=$childRegion->id?>">
					<div class="ap-block-header">
						<i class="ap-caret fa fa-caret-right fa-2x"></i>
						<div class="title">
							<i class="fa fa-check fa-2x"></i>
							<?php if (!empty($childRegion->image)) : ?>
								<img class="image" src="<?=RoutPhotos::DIR_NAME.'/regions/'.$childRegion->id.'/'.$childRegion->image.'_small.jpg'?>">
							<?php else : ?>
								<span class="fa-stack fa-lg image">
									<i class="fa fa-camera fa-stack-1x"></i>
									<i class="fa fa-ban fa-stack-2x text-danger"></i>
								</span>
							<?php endif; ?>
							<h3><?=$childRegion->title?></h3>
						</div>
						<i class="fa fa-pencil fa-2x"></i>
						<i class="fa fa-times fa-2x"></i>
					</div>
					<div class="ap-block-body hide">
						<div class="ap-blocks-list">
							<div class="ap-border-block">
								<?php foreach ($childRegion->getTours($date) as $tour) : ?>
									<a href="/tours/edit/id/<?=$tour->id?>" class="ap-blocks-block tour<?=$tour->active ? ' active' : ''?>">
										<?php if (count($tour->rout->images)) : ?>
											<img class="img-rounded" src="<?=$tour->rout->images[0]->getUrl('small')?>" alt="">
										<?php else : ?>
											<span class="fa-stack fa-2x no-photo">
												<i class="fa fa-camera fa-stack-1x"></i>
												<i class="fa fa-ban fa-stack-2x text-danger"></i>
											</span>
										<?php endif; ?>
										<span class="title"><?=$tour->title?></span>
									</a>
								<?php endforeach; ?>
								<div class="ap-blocks-block tour add">
									<a href="/tours/edit" class="border"><i class="fa fa-plus fa-3x"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="ap-blocks-list">
				<div class="ap-border-block">
					<?php foreach ($region->getTours($date) as $tour) : ?>
						<a href="/tours/edit/id/<?=$tour->id?>" class="ap-blocks-block tour<?=$tour->active ? ' active' : ''?>">
							<?php if (count($tour->rout->images)) : ?>
								<img class="img-rounded" src="<?=$tour->rout->images[0]->getUrl('small')?>" alt="">
							<?php else : ?>
								<span class="fa-stack fa-2x no-photo">
									<i class="fa fa-camera fa-stack-1x"></i>
									<i class="fa fa-ban fa-stack-2x text-danger"></i>
								</span>
							<?php endif; ?>
							<span class="title"><?=$tour->title?></span>
						</a>
					<?php endforeach; ?>
					<div class="ap-blocks-block tour add">
						<a href="/tours/edit" class="border"><i class="fa fa-plus fa-3x"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>