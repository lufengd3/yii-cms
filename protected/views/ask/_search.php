<?php
/* @var $this AskController */
/* @var $model Ask */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ask_id'); ?>
		<?php echo $form->textField($model,'ask_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ask_title'); ?>
		<?php echo $form->textField($model,'ask_title',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ask_content'); ?>
		<?php echo $form->textArea($model,'ask_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ask_date'); ?>
		<?php echo $form->textField($model,'ask_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ask_uid'); ?>
		<?php echo $form->textField($model,'ask_uid',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ask_response'); ?>
		<?php echo $form->textArea($model,'ask_response',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->