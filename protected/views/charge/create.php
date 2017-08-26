<?php
/* @var $this ChargeController */
/* @var $model Charge */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
