<?php
/* @var $this TtypeController */
/* @var $model Ttype */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加票种', 'url'=>array('create')),
	array('label'=>'管理票种', 'url'=>array('admin')),
);
?>

<h1>更新票种# <?php echo $model->ttype_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
