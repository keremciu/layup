<?php 
	$this->pageTitle=$model->title . ' by ' . $model->user->name . ' - '. Yii::app()->name;
?>
<div class="detailpage row">
	<div class="shot col-xs-6">
		<div class="image">
			<img width="400" src="<?php echo Yii::app()->baseUrl.'/images/shots/'.$model->image; ?>" alt="<?php echo $model->title; ?>" />
		</div>
	</div>
	<div class="details col-xs-3">
		<h1><?php echo $model->title; ?></h1>
		<p><?php echo $model->description; ?></p>
		<h5 class="author">by <a href="http://dribbble.com/<?php echo $model->user->username;?>" target="_blank"><?php echo $model->user->name; ?></a> at <?php echo Yii::app()->dateFormatter->format("MMM dd, yyyy",$model->created_at); ?></h5>
		<?php
			$class="";
			$record=Likes::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'shot_id'=>$model->id));
			// Chech user's like
			if (isset($record)) {
				$class = " activate";
				$text = "Liked";
			} else {
				$text = "Like";
			}
			// Ajax like stage
			echo CHtml::ajaxLink('<i class="fa fa-heart"></i> <span>'.$text.'</span>',Yii::app()->createUrl('shots/like'),
                    array('type'=>'POST','data'=> 'js:{"id": "'.$model->id.'"}',
                    	'success'=>'js:function(string){
                    		if(string=="success") {
                    			$(".btn-like").addClass("activate").find("span").html("Liked");
                    			var count = parseInt($(".meta.likes .counts").html());
                    			$(".meta.likes .counts").html(count+1);
                    		} else {
                    			$(".getmessage").html(string).fadeIn();
                    		}
                    	}'
                    ),array('class'=>'btn btn-dribbble btn-like'.$class));
		?> <span class="getmessage"></span>
		<?php 
			if ((!Yii::app()->user->isGuest) && (Yii::app()->user->type == "Player")) {
		?>
		<?php if ($model->user->type != "Player") { ?>
		<a href="http://dribbble.com/<?php echo $model->user->username;?>" class="btn btn-dribbble" target="_blank">Draft</a>
		<?php } ?>
		<?php 
			}
		?>
		<div class="metainfo">
			<div class="meta likes">
				<span class="metatitle"><i class="fa fa-heart"></i> Like</span>
				<span class="counts"><?php echo $model->likes_count; ?></span>
			</div>
			<div class="meta views">
				<span class="metatitle"><i class="fa fa-eye"></i> Views</span>
				<span class="counts"><?php echo $model->views_count; ?></span>
			</div>
			<div class="meta share">
				<span class="metatitle"><i class="fa fa-share-square-o"></i> Share</span>
			</div>
		</div>
	</div>
</div>
<?php
Yii::app()->clientScript->registerScript('keyboardlikefunction','
	$(window).keypress(function(e) {
       var key = e.which;
       if (key == 108) {
			$(".btn-like").trigger("click");
       }
   });
',CClientScript::POS_END);
?>

