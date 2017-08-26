<?php
/* @var $this AreaController */
/* @var $model Area */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'新建景区', 'url'=>array('create')),
	array('label'=>'管理景区', 'url'=>array('admin')),
);
?>

<h1>更新景区# <?php echo $model->area_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
