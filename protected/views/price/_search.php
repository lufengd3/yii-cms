<?php
/* @var $this PriceController */
/* @var $model Price */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'price_id'); ?>
		<?php echo $form->textField($model,'price_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_ticket'); ?>
		<?php echo $form->textField($model,'price_ticket'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_money'); ?>
		<?php echo $form->textField($model,'price_money'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_agent'); ?>
		<?php echo $form->textField($model,'price_agent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_user'); ?>
		<?php echo $form->textField($model,'price_user'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->