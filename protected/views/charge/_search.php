<?php
/* @var $this ChargeController */
/* @var $model Charge */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'charge_id'); ?>
		<?php echo $form->textField($model,'charge_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'charge_money'); ?>
		<?php echo $form->textField($model,'charge_money'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'charge_date'); ?>
		<?php echo $form->textField($model,'charge_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'charge_man_id'); ?>
		<?php echo $form->textField($model,'charge_man_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'charge_comment'); ?>
		<?php echo $form->textField($model,'charge_comment',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->