<?php
/* @var $this TtypeController */
/* @var $model Ttype */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加票种', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ttype-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理票种</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ttype-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '35px')),
		'ttype_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
