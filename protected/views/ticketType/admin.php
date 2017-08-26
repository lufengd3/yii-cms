<?php
/* @var $this TicketTypeController */
/* @var $model TicketType */

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
	$('#ticket-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>票务类型管理</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticket-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
/*        array('header'=>'Sr #', 'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)'),*/
        array('header' => '序号', 'value' => '++$row'),
		array('name' => 'ticket_type_name', 'htmlOptions' => array('width' => '180px'),),
        array('header' => '票种', 'name' => 'ticket_ttype_id', 'value' => 'Ttype::model() -> getTtypeName($data -> ticket_ttype_id)', 'filter' => Ttype::model() -> getTtype()),
		array('header' => '所属官方', 'name' => 'ticket_type_areaid', 'value' => 'Area::model() -> getAreaName($data -> ticket_type_areaid)', 'filter' => Area::model() -> getArea()),
		array('name' => 'ticket_type_cost', 'filter' => ''),
		array('name' => 'ticket_type_market_price', 'filter' => ''),
		array(
			'class'=>'CButtonColumn',
            //'htmlOptions' => array('width' => '150px'),
            'template' => '{update}{delete}',
		),
	),
)); ?>
