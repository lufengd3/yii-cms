<?php
/* @var $this AreaController */
/* @var $model Area */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加景区', 'url'=>array('create')),
	array('label'=>'更新景区信息', 'url'=>array('update', 'id'=>$model->area_id)),
	array('label'=>'管理景区', 'url'=>array('admin')),
);
?>

<h1>查看景区 #<?php echo $model->area_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'area_id',
		'area_name',
	),
)); ?>
