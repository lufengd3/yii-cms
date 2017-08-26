<?php
/* @var $this TtypeController */
/* @var $model Ttype */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create')),
	array('label'=>'更新', 'url'=>array('update', 'id'=>$model->ttype_id)),
	array('label'=>'删除', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ttype_id),'confirm'=>'确定删除')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>查看票种 #<?php echo $model->ttype_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ttype_id',
		'ttype_name',
	),
)); ?>
