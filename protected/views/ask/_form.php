<?php
/* @var $this AskController */
/* @var $model Ask */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ask-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation' => true,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ask_title'); ?>
		<?php echo $form->textField($model,'ask_title',array('size'=>50,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'ask_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ask_content'); ?>
		<?php echo $form->textArea($model,'ask_content',array('rows'=>12, 'cols'=>60)); ?>
		<?php echo $form->error($model,'ask_content'); ?>
	</div>

<?php 
    if (Yii::app() -> controller -> action -> id == 'reply') {
?>
	<div class="row">
		<?php echo $form->labelEx($model,'ask_response'); ?>
		<?php echo $form->textArea($model,'ask_response',array('rows'=>12, 'cols'=>60)); ?>
		<?php echo $form->error($model,'ask_response'); ?>
	</div>
<?php } ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
