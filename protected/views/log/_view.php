<?php
/* @var $this LogController */
/* @var $data Log */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->log_id), array('view', 'id'=>$data->log_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_user')); ?>:</b>
	<?php echo CHtml::encode($data->log_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_order')); ?>:</b>
	<?php echo CHtml::encode($data->log_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_uget')); ?>:</b>
	<?php echo CHtml::encode($data->log_uget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_aget')); ?>:</b>
	<?php echo CHtml::encode($data->log_aget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_time')); ?>:</b>
	<?php echo CHtml::encode($data->log_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_admin')); ?>:</b>
	<?php echo CHtml::encode($data->log_admin); ?>
	<br />


</div>