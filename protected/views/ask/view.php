<?php
/* @var $this AskController */
/* @var $model Ask */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'列表', 'url'=>array('index')),
	array('label'=>'新建', 'url'=>array('create'), 'visible' => Yii::app() -> user -> roles != 1),
	array('label'=>'管理', 'url'=>array('admin'), 'visible' => Yii::app() -> user -> roles == 1),
);
?>

<h1>查看 #<?php echo $model->ask_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ask_title',
		'ask_content',
		'ask_date',
        array('name' => 'ask_uid', 'value' => User::model() -> getUserName($model -> ask_uid)),
		array('name' => 'ask_response', 'value' => Ask::model() -> getResponse($model -> ask_response, $model -> ask_id), 'type' => 'html'),
	),
)); ?>
