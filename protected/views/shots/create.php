<h3 class="formtitle">What is the your best shot?</h3>
<p class="subtitle">You have only <?php echo 2-$shots_count;?> remaining in this platform.</p>
<?php 
	if ($shots_count<2) { 
		echo $this->renderPartial('_form', array('model'=>$model));
	} else {
		echo "Sorry, you don't have shot remaining.";
	} 
?>
