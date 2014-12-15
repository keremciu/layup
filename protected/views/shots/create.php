<?php
$this->breadcrumbs=array(
	'Shots'=>array('index'),
	'Create',
);
?>
<h3 class="formtitle">What is the your best shot?</h3>
<p class="subtitle">You have only 2 shot remaining in this platform.</p>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
