<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>添加票务类型</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
