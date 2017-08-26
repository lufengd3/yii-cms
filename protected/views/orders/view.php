<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>View Orders #<?php echo $model->orders_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'orders_order_id',
		array('name' => 'orders_user_uid', 'value' => User::model() -> getUserName($model -> orders_user_id), 'label' => '代理商'),
		'orders_customer_name',
		'orders_customer_phone',
		array('name' => 'orders_area_id', 'value' => Area::model() -> getAreaName($model -> orders_area_id)),
		array('name' => 'orders_ticket_id', 'value' => TicketType::model() -> getTicketName($model -> orders_ticket_id)),
		'orders_num',
		'orders_price',
		array('name' => 'orders_money_status', 'value' => Orders::model() -> getMoneyStatus($model -> orders_money_status)),
		'orders_agent_comment',
		'orders_admin_comment',
		'orders_time',
		'orders_go_date',
		array('name' => 'orders_status', 'type' => 'html', 'value' => Orders::model() -> getStatus($model -> orders_status, $model -> orders_num)),
	),
)); ?>
