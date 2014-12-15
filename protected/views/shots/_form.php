<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shots-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'row', 'enctype'=>'multipart/form-data'),
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="image col-xs-6">
		<div class="drop">
			<div class="cont">
				<i class="fa fa-cloud-upload"></i>
				<div class="tit">Drag &amp; Drop</div>
				<div class="desc">or</div>
				<div><strong>Click Here to Browse</strong></div>
				<p><small>Only 800x600 pixels.</small></p>
			</div>
			<output id="review"></output>
			<?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		</div>
	</div>
	<div class="texts col-xs-6">
		<div class="block">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
		<div class="block">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
		<div class="block buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Layup' : 'Save',array('class' => 'btn btn-primary btn-fill btn-lg')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->