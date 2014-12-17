<h3 class="formtitle">Share your invitation shot!</h3>
<p class="subtitle">To reach more designers.</p>

<ol class="shots row">
<?php foreach ($myshots as $shot) { ?>
	<li class="shot col-xs-3">
		<div class="image">
			<img src="<?php echo $shot->image_url; ?>" alt="<?php echo $shot->title; ?>" />
		</div>
		<h2>
			<?php
			// Ajax like stage
			$class = "";
			$record=Shares::model()->findByAttributes(array('shot_id'=>$shot->id));
			// Chech share situation like
			if (isset($record)) {
				$class = " activate";
				$text = "Shared";
			} else {
				$text = "Share this!";
			}
			echo CHtml::ajaxLink('<i class="fa fa-share"></i> <span>'.$text.'</span>',Yii::app()->createUrl('shots/shareit'),
                    array('type'=>'POST','data'=> 'js:
                    	{
                    		"shot_id": "'.$shot->id.'",
                    		"title":"'.$shot->title.'",
							"image_url":"'.$shot->image_url.'",
							"player_id":"'.$shot->player->id.'",
							"created_at":"'.$shot->created_at.'",
							"is_finished":0
                    	}',
                    	'success'=>'js:function(string){
                    		if(string=="success") {
                    			$("#sharebtn'.$shot->id.'").addClass("activate").find("span").html("Shared");
                    			$("#getmessage'.$shot->id.'").html("Shared.").fadeIn().delay(2000).slideUp();
                    		} else {
                    			$("#sharebtn'.$shot->id.'").removeClass("activate").find("span").html("Share this!");
                    			$("#getmessage'.$shot->id.'").html("Sharing ended.").fadeIn().delay(2000).slideUp();
                    		}
                    	}'
                    ),array('id'=>'sharebtn'.$shot->id,'class'=>'btn btn-share'.$class));
			?> <span id="getmessage<?php echo $shot->id;?>" class="getmessage"></span>
    	</h2>
	</li>
<?php } ?>
</ol>