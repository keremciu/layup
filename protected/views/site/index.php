<div class="rules close-element">
	<p><strong>What've you done?</strong> This is a quick draft platform. Only prospects can upload shots. Only dribbble players can like the shots. <a href="<?php echo Yii::app()->createUrl('site/about'); ?>">Learn more.</a><span class="close-it"><i class="fa fa-times"></i></span></p>
</div>
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#shots" aria-controls="shots" role="tab" data-toggle="tab">Shots</a></li>
    <li role="presentation"><a href="#drafted" aria-controls="drafted" role="tab" data-toggle="tab">Drafted</a></li>
    <li role="presentation"><a href="#shares" aria-controls="shares" role="tab" data-toggle="tab">Shares</a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="shots">
		<ol class="shots row">
		<?php foreach ($shots as $shot) { ?>
			<li class="shot col-xs-6 col-sm-3">
				<div class="image">
					<a href="<?php echo Yii::app()->createUrl('shots/view',array('id'=>$shot->id)); ?>-<?php echo $this->cleaner(trim($shot->title));?>">
						<img src="<?php echo Yii::app()->baseUrl.'/images/shots/'.$shot->image; ?>" alt="<?php echo $shot->title; ?>" />
					</a>
				</div>
				<h2>
					<span class="attribution-user">
		      			<a href="http://dribbble.com/<?php echo $shot->user->username; ?>" target="_blank" class="url" rel="contact" title="<?php echo $shot->user->name; ?>"><img alt="<?php echo $shot->user->name; ?>" class="photo" src="<?php echo $shot->user->avatar_url; ?>"> <?php echo $shot->user->name; ?>
						</a>
		    		</span>
		    		<span class="attribution-likes">
						<i class="fa fa-heart"></i> <?php echo $shot->likes_count; ?>
		    		</span>
		    	</h2>
			</li>
		<?php } ?>
		</ol>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="drafted">
		<ol class="shots row">
		<?php foreach ($drafts as $shot) { ?>
			<li class="shot col-xs-6 col-sm-3">
				<div class="image">
					<a href="<?php echo Yii::app()->createUrl('shots/view',array('id'=>$shot->id)); ?>-<?php echo $this->cleaner(trim($shot->title));?>">
						<img src="<?php echo Yii::app()->baseUrl.'/images/shots/'.$shot->image; ?>" alt="<?php echo $shot->title; ?>" />
					</a>
				</div>
				<h2>
					<span class="attribution-user">
		      			<a href="http://dribbble.com/<?php echo $shot->user->username; ?>" target="_blank" class="url" rel="contact" title="<?php echo $shot->user->name; ?>"><img alt="<?php echo $shot->user->name; ?>" class="photo" src="<?php echo $shot->user->avatar_url; ?>"> <?php echo $shot->user->name; ?>
						</a>
						<?php if ($shot->user->activate == 3) {
							$drafter = Users::model()->findByAttributes(array('player_id'=>$shot->user->drafted_by_player_id));
							$drafter_name = "";
							if (isset($drafter)) {
								$drafter_name = $drafter->name;
							}
						?>
						<a href="http://dribbble.com/<?php echo $shot->user->drafted_by_player_id;?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Drafted by <?php echo $drafter_name; ?>" class="badge-layup badge badge-small">Drafted</a>
						<?php } ?>
		    		</span>
		    		<span class="attribution-likes">
						<i class="fa fa-heart"></i> <?php echo $shot->likes_count; ?>
		    		</span>
		    	</h2>
			</li>
		<?php } ?>
		</ol>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="shares">
    	<ol class="shots row">
		<?php foreach ($shares as $shot) { ?>
			<li class="shot col-xs-6 col-sm-3">
				<div class="image">
					<a target="_blank" href="https://dribbble.com/shots/<?php echo $shot->shot_id . '-'. $this->cleaner(trim($shot->title));?>">
						<img src="<?php echo $shot->image_url; ?>" alt="<?php echo $shot->title; ?>" />
					</a>
				</div>
				<h2>
					<span class="attribution-user">
		      			<a href="http://dribbble.com/<?php echo $shot->user->username; ?>" target="_blank" class="url" rel="contact" title="<?php echo $shot->user->name; ?>"><img alt="<?php echo $shot->user->name; ?>" class="photo" src="<?php echo $shot->user->avatar_url; ?>"> <?php echo $shot->user->name; ?></a>
						</a>
		    		</span>
		    	</h2>
			</li>
		<?php } ?>
		</ol>
    </div>
  </div>
</div>