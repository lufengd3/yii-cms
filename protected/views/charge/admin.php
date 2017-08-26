<?php
/* @var $this ChargeController */
/* @var $model Charge */
$this -> breadcrumbs = Controller::getBread();

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#charge-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>充值/回退记录</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'charge-grid',
    'htmlOptions' => array('style' => 'width: 1100px'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('header' => '账户', 'name' => 'charge_to', 'value' => 'User::model() -> getUserName($data -> charge_to)' ),
		array('name' => 'charge_money', 'value' => 'Charge::model() -> getMoney($data -> charge_type, $data -> charge_money)',),
		'charge_date',
        array('name' => 'charge_man_id', 'value' => 'User::model() -> getUserName($data -> charge_man_id)'),
		'charge_comment',
        array('name' => 'charge_type', 'value' => 'Charge::model() -> getType($data -> charge_type)', 'filter' => Charge::model() -> getTypeList()),
	),
)); ?>
