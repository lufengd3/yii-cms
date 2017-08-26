<?php
/* @var $this PriceController */
/* @var $data Price */
?>

<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('price_ticket')); ?>:</b>
	<?php echo CHtml::encode(TicketType::model() -> getTicketName($data->price_ticket)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_money')); ?>:</b>
	<?php echo CHtml::encode($data->price_money); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_agent')); ?>:</b>
	<?php echo CHtml::encode($data->price_agent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_user')); ?>:</b>
	<?php echo CHtml::encode($data->price_user); ?>
	<br />


</div>
