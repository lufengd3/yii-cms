<?php
/* @var $this TtypeController */
/* @var $model Ttype */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'管理票种', 'url'=>array('admin')),
);
?>

<h1>添加票种</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
