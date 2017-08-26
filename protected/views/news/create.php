<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=Controller::getBread();
$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
);

?>

<h1>添加公告</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
