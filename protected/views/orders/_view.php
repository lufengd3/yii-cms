<?php
/* @var $this OrdersController */
/* @var $data Orders */
?>

<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->orders_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_agent_uid')); ?>:</b>
	<?php echo CHtml::encode($data->orders_agent_uid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_customer_name')); ?>:</b>
	<?php echo CHtml::encode($data->orders_customer_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_customer_phone')); ?>:</b>
	<?php echo CHtml::encode($data->orders_customer_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_area_id')); ?>:</b>
	<?php echo CHtml::encode($data->orders_area_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_ticket_id')); ?>:</b>
	<?php echo CHtml::encode($data->orders_ticket_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_num')); ?>:</b>
	<?php echo CHtml::encode($data->orders_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_price')); ?>:</b>
	<?php echo CHtml::encode($data->orders_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_money_status')); ?>:</b>
	<?php echo CHtml::encode($data->orders_money_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_agent_comment')); ?>:</b>
	<?php echo CHtml::encode($data->orders_agent_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_admin_comment')); ?>:</b>
	<?php echo CHtml::encode($data->orders_admin_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_time')); ?>:</b>
	<?php echo CHtml::encode($data->orders_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_go_date')); ?>:</b>
	<?php echo CHtml::encode($data->orders_go_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orders_status')); ?>:</b>
	<?php echo CHtml::encode($data->orders_status); ?>
	<br />

	*/ ?>

</div>
