<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<br>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
//    'enableClientValidation' => true,
)); ?>


<?php 
    //更改密码时不显示此项
    if (Yii::app() -> controller -> action -> id != 'pwChange') {
?>
	<div class="row">
		<?php echo $form->labelEx($model,'user_level'); ?>
		<?php echo $form->dropDownList($model,'user_level', User::model() -> getLevel(), array('prompt' => '选择用户级别')); ?>
		<?php echo $form->error($model,'user_level'); ?>
	</div>
<?php } ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_passwd'); ?>
		<?php echo $form->passwordField($model,'user_passwd',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'user_passwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_passwd_repeat'); ?>
		<?php echo $form->passwordField($model,'user_passwd_repeat',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'user_passwd_repeat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
