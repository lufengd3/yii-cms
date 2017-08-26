<?php
/* @var $this AskController */
/* @var $data Ask */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_title')); ?>:</b>
	<?php echo CHtml::link($data->ask_title, 'view/'.$data -> ask_id); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_date')); ?>:</b>
	<?php echo CHtml::encode($data->ask_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_uid')); ?>:</b>
	<?php echo CHtml::encode(User::model() -> getUserName($data->ask_uid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_content')); ?>:</b>
	<?php echo CHtml::encode($data->ask_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_response')); ?>:</b>
	<?php echo Ask::model() -> getResponse($data -> ask_response, $data -> ask_id); ?>
	<br />

</div>
