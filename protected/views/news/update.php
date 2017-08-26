<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>更新公告# <?php echo $model->news_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
