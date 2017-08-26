<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create')),
	array('label'=>'更新', 'url'=>array('update', 'id'=>$model->ticket_type_id)),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>查看 #<?php echo $model->ticket_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name' => 'ticket_type_areaid','value' => Area::model() -> getAreaName($model -> ticket_type_areaid)),
		'ticket_type_name',
		'ticket_type_cost',
		'ticket_type_market_price',
	),
)); ?>
