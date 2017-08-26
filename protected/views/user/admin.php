<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=Controller::getBread();

$this->menu=array(
	array('label'=>'新建用户', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>代理管理</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
    'htmlOptions' => array('style' => 'width: 1000px'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row'),
		'user_name',
        array('name' => 'user_level', 'header' => '用户身份', 'filter' => User::model() -> getLevel(), 'value' => 'User::model() -> getRolesName($data -> user_level)'),
        array('name' => 'user_father', 'header' => '上级渠道', 'value' => 'User::model() -> getUserName($data -> user_father)', 'filter' => ''),
		array('name' => 'user_money', 'header' => '账户余额', 'filter' => ''),
		array(
            'header' => '操作',
            'htmlOptions' => array('width' => '160px'),
			'class'=>'CButtonColumn',
            'template' => '{update} {ticketType} {chong} {tui}',
            'buttons' => array(
                'update' => array(
                    'label' => '编辑',
                    'imageUrl' => false,
                ),

                'ticketType' => array(
                    'label' => '票种管理',
                    'visible' => '$data -> user_level == 4 && Yii::app() -> user -> roles == 3',
                    'url' => 'Yii::app() -> createUrl("price/admin/", array("id" => $data -> user_id))',
                ),

                'chong' => array(
                    'label' => '充值',
                    'url' => 'Yii::app() -> createUrl("charge/create", array("id" => $data -> user_id))',
                    'visible' => '$data -> user_level > 2',

                ),

                'tui' => array(
                    'label' => '退回',
                    'url' => 'Yii::app() -> createUrl("charge/tui", array("id" => $data -> user_id))',
                    'visible' => '$data -> user_level > 2',
                ),
            ),
		),
	),
)); ?>
