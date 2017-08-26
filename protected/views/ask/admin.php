<?php
/* @var $this AskController */
/* @var $model Ask */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'列表', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ask-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理提问</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ask-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '35px')),
        array('name' => 'ask_title', 'value' => 'CHtml::link($data -> ask_title, $data -> ask_id)', 'type' => 'html'),
		'ask_content',
        array('header' => '提问时间', 'name' => 'ask_date', 'filter' => Controller::getYear('ask_date', 'ask'), 'htmlOptions' => array('width' => '80px')),
        array('header' => '提问用户', 'name' => 'ask_uid', 'value' => 'User::model() -> getUserName($data -> ask_uid)'),
        array('name' => 'ask_status', 'filter' => ask::model() -> getStatus(), 'value' => 'Ask::model() -> getStatusName($data -> ask_status, $data -> ask_id)', 'type' => 'html'),
	),
)); ?>
