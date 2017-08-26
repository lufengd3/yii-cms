<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=Controller::getBread();

if (Yii::app() -> controller -> action -> id != 'pwChange') {
    $this->menu=array(
        array('label'=>'Create User', 'url'=>array('create')),
        array('label'=>'Manage User', 'url'=>array('admin')),
    );
}
?>

<h1>Update User <?php echo $model->user_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
