<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create')),
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>更新# <?php echo $model->ticket_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
