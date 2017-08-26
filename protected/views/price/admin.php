<?php
/* @var $this PriceController */
/* @var $model Price */
$this -> breadcrumbs = Controller::getBread();
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#price-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>票种管理</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'price-grid',
	'dataProvider'=>$model->search($id),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row'),
		array('name' => 'price_ticket', 'value' => 'TicketType::model() -> getTicketName($data -> price_ticket)',),
		'price_money',
		array('filter' => '', 'name' => 'price_user', 'value' => 'User::model() -> getUserName($data -> price_user)'),
		array(
			'class'=>'CButtonColumn',
            'template' => '{update}',
		'buttons' => array(
			'update' => array(
				'imagUrl' => false,
				'label' => '编辑',
			),
		),
		),
	),
)); ?>
