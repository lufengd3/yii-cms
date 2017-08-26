<?php
/* @var $this TtypeController */
/* @var $model Ttype */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ttype_id'); ?>
		<?php echo $form->textField($model,'ttype_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ttype_name'); ?>
		<?php echo $form->textField($model,'ttype_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->