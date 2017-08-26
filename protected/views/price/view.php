<?php
/* @var $this PriceController */
/* @var $model Price */

$this->breadcrumbs=Controller::getBread();

$this -> menu = array(
   array('label' => '票种管理', 'url' => array('/price/admin/'.$model -> price_user)),
)
?>

<h1>查看 #<?php echo $model->price_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name' => 'price_ticket', 'value' => TicketType::model() -> getTicketName($model -> price_ticket)),
		'price_money',
//		array('name' => 'price_agent', 'value' => User::model() -> getUserName($model -> price_agent)),
		array('name' => 'price_user', 'value' => User::model() -> getUserName($model -> price_user)),
	),
)); ?>
