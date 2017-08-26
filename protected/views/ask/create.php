<?php
/* @var $this AskController */
/* @var $model Ask */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'列表', 'url'=>array('index')),
	array('label'=>'管理', 'url'=>array('admin'), 'visible' => Yii::app() -> user -> roles == 1),
);
?>

<h1>提问</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
