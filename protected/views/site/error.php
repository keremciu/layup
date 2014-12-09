<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Hata';
$this->breadcrumbs=array(
	'Hata',
);
?>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>