<?php
/* @var $this LogController */
/* @var $model Log */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'log-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'log_user'); ?>
		<?php echo $form->textField($model,'log_user',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'log_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_order'); ?>
		<?php echo $form->textField($model,'log_order',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'log_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_uget'); ?>
		<?php echo $form->textField($model,'log_uget'); ?>
		<?php echo $form->error($model,'log_uget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_aget'); ?>
		<?php echo $form->textField($model,'log_aget'); ?>
		<?php echo $form->error($model,'log_aget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_time'); ?>
		<?php echo $form->textField($model,'log_time'); ?>
		<?php echo $form->error($model,'log_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_admin'); ?>
		<?php echo $form->textField($model,'log_admin',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'log_admin'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->