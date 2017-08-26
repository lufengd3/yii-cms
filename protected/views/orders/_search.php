<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'orders_id'); ?>
		<?php echo $form->textField($model,'orders_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_order_id'); ?>
		<?php echo $form->textField($model,'orders_order_id',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_agent_uid'); ?>
		<?php echo $form->textField($model,'orders_agent_uid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_customer_name'); ?>
		<?php echo $form->textField($model,'orders_customer_name',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_customer_phone'); ?>
		<?php echo $form->textField($model,'orders_customer_phone',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_area_id'); ?>
		<?php echo $form->textField($model,'orders_area_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_ticket_id'); ?>
		<?php echo $form->textField($model,'orders_ticket_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_num'); ?>
		<?php echo $form->textField($model,'orders_num'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_price'); ?>
		<?php echo $form->textField($model,'orders_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_money_status'); ?>
		<?php echo $form->textField($model,'orders_money_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_agent_comment'); ?>
		<?php echo $form->textField($model,'orders_agent_comment',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_admin_comment'); ?>
		<?php echo $form->textField($model,'orders_admin_comment',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_time'); ?>
		<?php echo $form->textField($model,'orders_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_go_date'); ?>
		<?php echo $form->textField($model,'orders_go_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'orders_status'); ?>
		<?php echo $form->textField($model,'orders_status',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->