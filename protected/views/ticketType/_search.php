<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ticket_type_id'); ?>
		<?php echo $form->textField($model,'ticket_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_type_areaid'); ?>
		<?php echo $form->textField($model,'ticket_type_areaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_type_name'); ?>
		<?php echo $form->textField($model,'ticket_type_name',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_type_cost'); ?>
		<?php echo $form->textField($model,'ticket_type_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ticket_type_market_price'); ?>
		<?php echo $form->textField($model,'ticket_type_market_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
