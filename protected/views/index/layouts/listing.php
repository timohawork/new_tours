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
						<?php /*foreach ($childRegion->routs as $rout) : ?>
							<div class="ap-block ap-group rout<?=$rout->active ? ' active' : ''?>">
								<div class="ap-block-header">
									<i class="ap-caret fa fa-caret-right fa-2x"></i>
									<div class="title">
										<i class="fa fa-check fa-2x"></i>
										<h3><?=$rout->title?></h3>
									</div>
									<a href="/routs/edit/id/<?=$rout->id?>"><i class="fa fa-pencil fa-2x"></i></a>
									<i class="fa fa-times fa-2x"></i>
								</div>
								<div class="ap-block-body hide">
									<div class="ap-blocks-list">
										<div class="ap-border-block">
											<?php foreach ($group->marks as $mark) : ?>
												<div class="ap-blocks-block mark<?=$mark->active ? ' active' : ''?>" data-id="<?=$mark->id?>">
													<i class="fa fa-flag fa-2x"></i>
													<i class="fa fa-times fa-2x"></i>
													<?php if (count($mark->markPhotoses)) : ?>
														<?=$mark->markPhotoses[0]->getImage('small')?>
													<?php else : ?>
														<span class="fa-stack fa-2x no-photo">
															<i class="fa fa-camera fa-stack-1x"></i>
															<i class="fa fa-ban fa-stack-2x text-danger"></i>
														</span>
													<?php endif; ?>
													<span class="title"><i class="fa <?=$mark->type->icon?> fa-fw"></i> <?=$mark->title?></span>
													<i class="fa fa-check fa-2x"></i>
												</div>
											<?php endforeach; ?>
											<div class="ap-blocks-block mark add">
												<i class="fa fa-flag fa-2x"></i>
												<i class="fa fa-plus fa-3x"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach;*/ ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endforeach; ?>