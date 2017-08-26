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
$baseUrl = Yii::app() -> baseUrl;
?>

<h1>订单管理</h1>

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

<?php $this->widget('ext.EExcelView', array( //zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
    'htmlOptions' => array('style' => 'width: 1200px'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'pager'=>array(
        'class'=>'CLinkPager',
    ),
    // 'summaryText'=>'页数：{page}/{pages}页',
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '26px')),
		array('name' => 'orders_order_id', 'htmlOptions' => array('width' => '75px')),
		array('name' => 'orders_customer_name', 'htmlOptions' => array('width' => '70px')),
		array('name' => 'orders_customer_phone', 'htmlOptions' => array('width' => '85px')),
        array('name' => 'orders_ticket_id', 'value' => 'TicketType::model() -> getTicketName($data -> orders_ticket_id)', 'filter' => TicketType::model() -> getTicketType(''),'htmlOptions' => array('width' => '90px')),
		array('name' => 'orders_num', 'htmlOptions' => array('width' => '55px'), 'filter' => ''),
		array('name' => 'orders_price', 'header' => '售价', 'htmlOptions' => array('width' => '55px'), 'filter' => ''),
//        array('header' => '金额', 'value' => '$data -> orders_num * $data -> orders_price', 'htmlOptions' => array('width' => '55px')),
		array('name' => 'orders_money_status', 'value' => 'Orders::model() -> getMoneyStatus($data -> orders_money_status)', 'filter' => Orders::model() -> getMoneyStatusFilter(), 'htmlOptions' => array('width' => '55px')),
        array('header' => '一级代理', 'filter' => '', 'value' => 'User::model() -> getUserName($data -> orders_agent_uid)'),
        array('header' => '二级代理', 'filter' => '', 'value' => 'User::model() -> getUserName($data -> orders_user_id)'),
        //'orders_agent_comment',
        //'orders_admin_comment',
		array('name' => 'orders_time', 'htmlOptions' => array('width' => '130px')),
		array('name' => 'orders_go_date', 'htmlOptions' => array('width' => '80px')),
		array('name' => 'orders_status','value' => 'Orders::model() -> getStatus($data -> orders_status, $data -> orders_num)', 'filter' => Orders::model() -> getStatusFilter(), 'type' => 'html', 'htmlOptions' => array('width' => '90px')),
	
		array(
			'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '100px'),
            'header' => '操作',
            'template' => '{view}&nbsp;&nbsp;&nbsp;{gettime}&nbsp;&nbsp;&nbsp;{resend}',
            'buttons' => array(
                'view' => array(
                    'imageUrl' => false,
                ),

                'resend' => array(
                    'label' => '重发',
                    'url' => 'Yii::app() -> createUrl("orders/resend/", array("id" => $data -> orders_id))',
                ),
                
                'gettime' => array(
                    'label' => '取票',
                    'url' => 'Yii::app() -> createUrl("orders/time/", array("id" => $data -> orders_id))',
                    'visible' => '$data->orders_status != "-1" && $data -> orders_status != $data -> orders_num && Yii::app() -> user -> roles == 1',
                    /*'click' => 'function(){
                                if (confirm("确认取票")) {
                                    
                                } else {
                                    return false;
                                }
                            }',
                     */
                ),
            ),
		),
	),
)); ?>
