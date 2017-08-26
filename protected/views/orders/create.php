<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'订单管理', 'url'=>array('admin')),
);
?>

<h1>创建订单</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
