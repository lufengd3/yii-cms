<?php
/* @var $this UserController */
/* @var $model User */



$this->breadcrumbs=array(
	'用户名:'.Yii::app() -> user -> name,
    '权限：'.User::model() -> getRolesName(Yii::app() -> user -> roles),
    '余额：'.User::model() -> find('user_id = :uid', array(':uid' => Yii::app() -> user -> id)) -> user_money.'元',
);

$this->menu=array(
	array('label'=>'代理管理', 'url'=>array('admin')),
);
?>

<h1>新建用户</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
