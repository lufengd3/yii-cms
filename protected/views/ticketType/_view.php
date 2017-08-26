<?php
/* @var $this TicketTypeController */
/* @var $data TicketType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ticket_type_id), array('view', 'id'=>$data->ticket_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_type_areaid')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_type_areaid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_type_name')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_type_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_type_cost')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_type_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ticket_type_market_price')); ?>:</b>
	<?php echo CHtml::encode($data->ticket_type_market_price); ?>
	<br />

</div>
