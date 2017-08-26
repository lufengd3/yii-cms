<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'List Charge', 'url'=>array('index')),
	array('label'=>'Create Charge', 'url'=>array('create')),
	array('label'=>'Update Charge', 'url'=>array('update', 'id'=>$model->charge_id)),
	array('label'=>'Delete Charge', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->charge_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Charge', 'url'=>array('admin')),
);
?>

<h1>View Charge #<?php echo $model->charge_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'charge_id',
		'charge_money',
		'charge_date',
		'charge_man_id',
		'charge_comment',
	),
)); ?>
