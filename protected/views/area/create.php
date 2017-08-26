<?php
/* @var $this AreaController */
/* @var $model Area */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'管理景区', 'url'=>array('admin')),
);
?>

<h1>添加景区</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
