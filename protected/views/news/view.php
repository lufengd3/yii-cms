<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=COntroller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create'), 'visible' => Yii::app() -> user -> roles == 1),
	array('label'=>'管理', 'url'=>array('admin'), 'visible' => Yii::app() -> user -> roles == 1),
	array('label'=>'更新', 'url'=>array('update', 'id'=>$model->news_id), 'visible' => Yii::app() -> user -> roles == 1),
);
?>

<h1>查看公告</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'news_title',
		'news_content',
		'news_date',
	),
)); ?>
