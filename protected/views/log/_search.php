<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'log_id'); ?>
		<?php echo $form->textField($model,'log_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_user'); ?>
		<?php echo $form->textField($model,'log_user',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_order'); ?>
		<?php echo $form->textField($model,'log_order',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_uget'); ?>
		<?php echo $form->textField($model,'log_uget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_aget'); ?>
		<?php echo $form->textField($model,'log_aget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_time'); ?>
		<?php echo $form->textField($model,'log_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_admin'); ?>
		<?php echo $form->textField($model,'log_admin',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->