<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_type_areaid'); ?>
		<?php echo $form -> dropDownList($model, 'ticket_type_areaid', Area::model() -> getArea(), array('prompt' => '选择景区')); ?>
		<?php echo $form->error($model,'ticket_type_areaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_ttype_id'); ?>
		<?php echo $form -> dropDownList($model, 'ticket_ttype_id', Ttype::model() -> getTtype(), array('prompt' => '付款类型')); ?>
		<?php echo $form->error($model,'ticket_ttype_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_type_name'); ?>
		<?php echo $form->textField($model,'ticket_type_name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'ticket_type_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_type_cost'); ?>
		<?php echo $form->textField($model,'ticket_type_cost'); ?>
		<?php echo $form->error($model,'ticket_type_cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ticket_type_market_price'); ?>
		<?php echo $form->textField($model,'ticket_type_market_price'); ?>
		<?php echo $form->error($model,'ticket_type_market_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
