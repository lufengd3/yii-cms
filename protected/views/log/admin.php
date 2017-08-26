<?php
/* @var $this LogController */
$this -> breadcrumbs = Controller::getBread();

$roles = Yii::app() -> user -> roles;
$roles == 4 ? $hide = array('style' => 'display: none') : $hide = array('');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>帐目明细</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array('header' => '用户', 'value' => 'User::model() -> getUserName($data -> log_user)'),
		'log_order',
		'log_uget',
        array(
            'name' => 'log_aget',
            'htmlOptions' => $hide,
            'headerHtmlOptions' => $hide,
            'footerHtmlOptions' => $hide,
        ),
		'log_time',
        array('name' => 'log_admin', 'value' => 'User::model() -> getUserName($data -> log_admin)'),
		/*
		'log_admin',
		*/
	),
)); ?>
