<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'添加', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理公告</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '35px')),
        array('header' => '公告标题', 'name' => 'news_title', 'value' => 'CHtml::link($data -> news_title, $data -> news_id)', 'type' => 'html', 'htmlOptions' => array('width' => '160px')),
		'news_content',
        array('header' => '发表日期', 'name' => 'news_date', 'filter' => Controller::getYear('news_date', 'news'), 'htmlOptions' => array('width' => '80px')),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
