<?php
/* @var $this OrdersController */
/* @var $model Orders */
$this -> breadcrumbs = Controller::getBread();
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#orders-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$footerstyle = array('style' => 'background-color: #EFEFEF');
$cost = array();
$agent = array();
$roles = Yii::app() -> user -> roles;
$display = array('style' => 'display: none');

if ($roles == 4) {
    $cost['header'] = $display;
    $cost['filter'] = $display; 
    $cost['html'] = $display; 
    $cost['footer'] = $display;
    $agent['header'] = $display;
    $agent['filter'] = $display;
    $agent['html'] = $display; 
    $agent['footer'] = $display;
} else {
    $cost['header'] = array('width' => '30px',);
    $cost['filter'] = array('width' => '30px', );
    $cost['html'] = array('width' => '30px', );
    $cost['footer'] = $footerstyle;
    $agent['header'] = array('width' => '60px');
    $agent['filter'] = array('width' => '60px',);
    $agent['html'] = array('width' => '60px',);
    $agent['footer'] = $footerstyle;
}
?>
<h1>销售管理</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'page-form',
            'enableAjaxValidation'=>true,
        )); ?>
 
<b>从:</b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'language' => 'zh_cn',
        'name'=>'from_date',  // name of post parameter
        'value'=> isset(Yii::app()->request->cookies['from_date']) ? Yii::app() -> request -> cookies['from_date'] : '',
        'options'=>array(
             'showAnim'=>'fold',
             'dateFormat'=>'yy-mm-dd',
         ),
         'htmlOptions'=>array(
             'style'=>'height:20px;'
         ),
     ));
?>
<b>到:</b>
<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'language' => 'zh_cn',
        'name'=>'to_date',
        'value'=> isset(Yii::app()->request->cookies['to_date']) ? Yii::app() -> request -> cookies['to_date'] : '',
        //'value'=>Yii::app()->request->cookies['to_date']->value,
             'options'=>array(
             'showAnim'=>'fold',
             'dateFormat'=>'yy-mm-dd',
             'language' => 'zh_cn'
         ),
         'htmlOptions'=>array(
             'style'=>'height:20px;'
         ),
     ));
?>
<?php echo CHtml::submitButton('Go'); ?> 
<?php $this->endWidget(); ?>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
    'htmlOptions' => array('style' => 'width: 1220px'),
	'dataProvider'=>$model->search(1),
	'filter'=>$model,
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '26px'),
            'footer' => '总计',
            'footerHtmlOptions' => $footerstyle,
        ),
		array('name' => 'orders_order_id', 'htmlOptions' => array('width' => '75px'),'footerHtmlOptions' => $footerstyle,),
		array('name' => 'orders_customer_name', 'htmlOptions' => array('width' => '70px'),'footerHtmlOptions' => $footerstyle,),
		array('name' => 'orders_customer_phone', 'htmlOptions' => array('width' => '90px'),'footerHtmlOptions' => $footerstyle,),
        array('name' => 'orders_ticket_id', 'value' => 'TicketType::model() -> getTicketName($data -> orders_ticket_id)', 'filter' => TicketType::model() -> getTicketType(''),'htmlOptions' => array('width' => '79px'), 'footerHtmlOptions' => $footerstyle,),
        array('header' => '一级代理', 'filter' => '', 'value' => 'User::model() -> getUserName($data -> orders_agent_uid)', 'footerHtmlOptions' => $footerstyle,),
        array('name' => 'orders_userid', 'header' => '二级代理', 'filter' => '', 'value' => 'User::model() -> getUserName($data -> orders_user_id)', 'footerHtmlOptions' => $footerstyle,),
        array('name' => 'orders_num', 
            'htmlOptions' => array('width' => '55px'), 
            'filter' => '',
            'footer' => '<b>'.$model -> getTotal($model -> search(1) -> getData(), 'orders_num').'</b>',
            'htmlOptions' => array('width' => '30px'),
            'footerHtmlOptions' => $footerstyle,
        ),
        array('header' => '成本', 
            'value' => 'TicketType::model() -> getTicketCost($data -> orders_ticket_id)', 
            //'htmlOptions' => ,
            'footer' => '<b>'.$model -> getCost($model -> search(1) -> getData(), 1).'</b>',
            'htmlOptions' => $cost['html'],
            'headerHtmlOptions' => $cost['header'],
            'footerHtmlOptions' => $cost['footer'],
            'filterHtmlOptions' => $cost['filter'],
        ),
        array(
            'header' => '代理价',
            'value' => 'Price::model() -> getPrice($data -> orders_ticket_id, $data -> orders_user_id)',
            'footer' => '<b>'.$model -> getCost($model -> search(1) -> getData(), 2).'</b>',
            'footerHtmlOptions' => $footerstyle,
        ),
        array(
            'name' => 'orders_price', 
            'header' => '售价', 
            'htmlOptions' => array('width' => '55px'), 
            'filter' => '',
            'footer' => '<b>'.$model -> getSellTotal($model -> search(1) -> getData()).'</b>',
            'footerHtmlOptions' => $footerstyle,
        ),

        array(
            'header' => '一级利润',
            'value' => 'Orders::model() -> getEachLirun($data -> orders_id, 1)',
            'footer' => '<b>'.$model -> getLirun($model -> search(1) -> getData(), 1).'</b>',
            'htmlOptions' => $agent['html'],
            'headerHtmlOptions' => $agent['header'],
            'footerHtmlOptions' => $agent['footer'],
            'filterHtmlOptions' => $agent['filter'],
        ),

        array(
            'header' => '二级利润',
            'value' => 'Orders::model() -> getEachLirun($data -> orders_id, 2)',
            'footer' => '<b>'.$model -> getLirun($model -> search(1) -> getData(), 2).'</b>',
            'footerHtmlOptions' => $footerstyle,
        ),
        array('header' => '总售价', 'value' => '$data -> orders_num * $data -> orders_price', 'htmlOptions' => array('width' => '55px'), 'footerHtmlOptions' => $footerstyle,),
		array('name' => 'orders_money_status', 'value' => 'Orders::model() -> getMoneyStatus($data -> orders_money_status)', 'filter' => Orders::model() -> getMoneyStatusFilter(), 'htmlOptions' => array('width' => '60px'),'footerHtmlOptions' => $footerstyle,),
        array(
            'name' => 'orders_gettime',
            'footerHtmlOptions' => $footerstyle,
            'htmlOptions' => array('width' => '90px'),
        ),
		array('name' => 'orders_go_date', 'filter' => '', 'htmlOptions' => array('width' => '70px'),'footerHtmlOptions' => $footerstyle,),
//		array('name' => 'orders_status','value' => 'Orders::model() -> getStatus($data -> orders_status)', 'type' => 'html', 'filter' => Orders::model() -> getStatusFilter(), 'htmlOptions' => array('width' => '50px')),
	
		array(
			'class'=>'CButtonColumn',
            'header' => '查看',
            'template' => '{view}',
            'footerHtmlOptions' => $footerstyle,
		),

	),
)); ?>

<hr>
