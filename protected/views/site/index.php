<div class="rules close-element">
	<p><strong>What've you done?</strong> This is a quick draft platform. Only prospects can upload shots. Only dribbble players can like the shots. <a href="<?php echo Yii::app()->createUrl('site/about'); ?>">Learn more.</a><span class="close-it"><i class="fa fa-times"></i></span></p>
</div>
<ol class="shots row">
<?php foreach ($shots as $shot) { ?>
	<li class="shot col-xs-3">
		<div class="image">
			<a href="<?php echo Yii::app()->createUrl('shots/view',array('id'=>$shot->id)); ?>-<?php echo $this->cleaner(trim($shot->title));?>">
				<img src="<?php echo Yii::app()->baseUrl.'/images/shots/'.$shot->image; ?>" alt="<?php echo $shot->title; ?>" />
			</a>
		</div>
		<h2>
			<span class="attribution-user">
      			<a href="http://dribbble.com/<?php echo $shot->user->username; ?>" class="url" rel="contact" title="<?php echo $shot->user->name; ?>"><img alt="<?php echo $shot->user->name; ?>" class="photo" src="<?php echo $shot->user->avatar_url; ?>"> <?php echo $shot->user->name; ?></a>
				</a>
    		</span>
    		<span class="attribution-likes">
				<i class="fa fa-heart"></i> <?php echo $shot->likes_count; ?>
    		</span>
    	</h2>
	</li>
<?php } ?>
</ol>