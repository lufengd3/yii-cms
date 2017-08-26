<?php
/* @var $this ChargeController */
/* @var $data Charge */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->charge_id), array('view', 'id'=>$data->charge_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_money')); ?>:</b>
	<?php echo CHtml::encode($data->charge_money); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_date')); ?>:</b>
	<?php echo CHtml::encode($data->charge_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_man_id')); ?>:</b>
	<?php echo CHtml::encode($data->charge_man_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_comment')); ?>:</b>
	<?php echo CHtml::encode($data->charge_comment); ?>
	<br />


</div>