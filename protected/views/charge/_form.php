<?php
/* @var $this ChargeController */
/* @var $model Charge */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'charge-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'enableClientValidation' => true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<?php 
$action = Yii::app() -> controller -> action -> id;
$user = User::model() -> getUserName($model -> charge_to);
        if ($action == 'create') {
            echo "<h1>为 <b>",$user,"</b> 充值</h1>";
        } else {
            echo "<h1>从 <b>",$user,"</b> 回退</h1>";
        }

?>

	<div class="row">
		<?php echo $form->labelEx($model,'charge_money'); ?>
		<?php echo $form->textField($model,'charge_money'); ?>
		<?php echo $form->error($model,'charge_money'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'charge_comment'); ?>
		<?php echo $form->textField($model,'charge_comment',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'charge_comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
