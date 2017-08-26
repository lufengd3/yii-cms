<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
    'enableClientValidation' => true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_area_id'); ?>
        <?php echo $form->dropDownList($model,'orders_area_id', Price::model() -> getMyArea(), array('prompt' => '选择景区',
        'ajax' => array(
                'type' => 'POST',
                'url' => Ccontroller::createUrl('orders/ajaxTicket'),
                'update' => '#'.CHtml::activeId($model, 'orders_ticket_id'),
            ),        
)); ?>
		<?php echo $form->error($model,'orders_area_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_ticket_id'); ?>
        <?php echo $form -> dropDownList($model, 'orders_ticket_id', array(),
              array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Ccontroller::createUrl('orders/ajaxMoneyStatus'),
                    'update' => '#'.CHtml::activeId($model, 'orders_money_status'),
                ),        
)); ?>
		<?php echo $form->error($model,'orders_ticket_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_money_status'); ?>
        <?php echo $form -> dropDownList($model, 'orders_money_status',  array(), 
            array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Controller::createUrl('orders/ajaxMessage'),
                    //'update' => '#orders_messages',
                    'success' => 'function(data) {
                        $("#orders_message").val(data["message"]);
                        if (data["price"] != null) {
                            $("#Orders_orders_price").val(data["price"]);
                        } else {
                            $("#Orders_orders_price").val("");
                        }
                        $("#Orders_orders_num").val("");
                        $("#money").val("");
                    }',
                    'dataType' => 'json',
                ),
 )); ?>
		<?php echo $form->error($model,'orders_money_status'); ?>
	</div>

    <!-- 附加信息 -->
		<?php echo $form->label($model,'orders_message'); ?>
	<div class="row" id="orders_messages">
		<?php echo CHtml::textField('orders_message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_customer_name'); ?>
		<?php echo $form->textField($model,'orders_customer_name',array('size'=>20,'maxlength'=>40, )); ?>
		<?php echo $form->error($model,'orders_customer_name'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'orders_customer_phone'); ?>
		<?php echo $form->textField($model,'orders_customer_phone',array('size'=>20,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'orders_customer_phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_num'); ?>
        <?php echo $form->textField($model,'orders_num', array(
        'ajax' => array(
                'type' => 'POST',
                'url' => Ccontroller::createUrl('orders/ajaxCount'),
                'update' => '#money_message',
            ),                  
)); ?>
		<?php echo $form->error($model,'orders_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_price'); ?>
        <?php echo $form->textField($model,'orders_price', array(
        'ajax' => array(
                'type' => 'POST',
                'url' => Ccontroller::createUrl('orders/ajaxCount'),
                'update' => '#money_message',
            ),                  
)); ?>
		<?php echo $form->error($model,'orders_price'); ?>
	</div>

<?php echo '<b>总计</b>'; ?>
<div class="row" id="money_message">
    <?php echo '<input id="money" />'; ?>
</div>

	<div class="row">
        <?php //echo $form -> radioButtonList($model, 'orders_money_status', array('1' => '已付款', '2' =>'未付款'), array('labelOptions'=>array('style'=>'display:inline'), 'separator' => "  " )); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_go_date'); ?>
		<?php //echo $form->textField($model,'orders_go_date'); ?>
        <!-- 日期控件 -->
        <?php
            $this -> widget('zii.widgets.jui.CJuiDatePicker', array(
		'language' => 'zh_cn',
                'model' => $model,
                'attribute' => 'orders_go_date',
                'options' => array(
                    'showAnim' => 'fold', 
                    'dateFormat' => 'yy-mm-dd',
                    'minDate' => '%y-$M-%d',
                ),
                'htmlOptions' => array(
                    //'style' => 'height: 30px',
                ),
            ));
        ?>
		<?php echo $form->error($model,'orders_go_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orders_agent_comment'); ?>
		<?php echo $form->textArea($model,'orders_agent_comment',array('rows'=>'8', 'cols' => '40')); ?>
		<?php echo $form->error($model,'orders_agent_comment'); ?>
	</div>

    <!-- 详细信息 -->
	<div class="row">
		<?php //echo $form->labelEx($model,'orders_info'); ?>
		<?php //echo $form->textArea($model,'orders_info', array('cols' => '40', 'rows' => '8')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    var money = document.getElementById("Orders_orders_money_status");
    var num = document.getElementById("Orders_orders_num");

//    money.addEventListener("blur", listen);

    function listen() {
        if (money.value == 1) {
            num.addEventListener("blur", count);
        }
    }

    function count() {
        var price = $("#Orders_orders_price").val();
        var all = num.value * price;
        $("#money").val(all);
    }
</script>
