<?php
/* @var $this AreaController */
/* @var $model Area */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加景区', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#area-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>景区管理</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'area-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '35px')),
        'area_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
