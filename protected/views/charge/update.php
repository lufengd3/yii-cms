<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=array(
	'Charges'=>array('index'),
	$model->charge_id=>array('view','id'=>$model->charge_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Charge', 'url'=>array('index')),
	array('label'=>'Create Charge', 'url'=>array('create')),
	array('label'=>'View Charge', 'url'=>array('view', 'id'=>$model->charge_id)),
	array('label'=>'Manage Charge', 'url'=>array('admin')),
);
?>

<h1>Update Charge <?php echo $model->charge_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>