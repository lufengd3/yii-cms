<?php
/* @var $this AskController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=Controller::getBread();
$this->menu=array(
	array('label'=>'添加', 'url'=>array('create'), 'visible' => Yii::app() -> user -> roles != 1),
	array('label'=>'管理', 'url'=>array('admin'), 'visible' => Yii::app() -> user -> roles == 1),
);
?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
