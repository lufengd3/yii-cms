<?php

$this->breadcrumbs=Controller::getBread();

?>

<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<h2>确认取票</h2>
<table class="items" style="width: 1050px">
<thead>
<tr>
<th>订单号</th><th id="orders-grid_c2">客户姓名</th><th>客户电话</th><th id="orders-grid_c4">票务类型</th><th id="orders-grid_c5">张数</th><th id="orders-grid_c6">售价</th><th id="orders-grid_c8">一级代理</th><th id="orders-grid_c9">二级代理</th><th id="orders-grid_c12">订单状态</th><th id="orders-grid_c10">下单时间</th><th id="orders-grid_c11">预定游玩时间</th>

<tbody>

<td width="75px"><?php echo $model -> orders_id; ?></td>
<td width="70px"><?php echo $model -> orders_customer_name; ?></td>
<td width="85px"><?php echo $model -> orders_customer_phone; ?></td>
<td width="90px"><?php echo TicketType::model() -> getTicketName($model -> orders_ticket_id); ?></td>
<td width="55px"><?php echo $model -> orders_num; ?></td>
<td width="55px"><?php echo $model -> orders_price; ?></td>
<td width=60px><?php echo User::model() -> getUserName($model -> orders_agent_uid); ?></td>
<td width=60px><?php echo User::model() -> getUserName($model -> orders_user_id); ?></td>
<td width="80px"><?php echo "已取票".$model -> orders_status."张"; ?></td>
<td width="130px"><?php echo $model -> orders_time; ?></td>
<td width="82px"><?php echo $model -> orders_go_date; ?></td>
</tr>

</tbody>
</table>
<hr style="width: 1050px">

<?php echo "输入取票张数:"." 1---".($model -> orders_num - $model -> orders_status); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true,
            'afterValidate' => 'js:check',
     ),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
        
		<?php echo "取票张数: ".$form->textField($model,'orders_num', array('value' => $model -> orders_num - $model -> orders_status)); ?>
		<?php echo $form->error($model,'orders_num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : '提交'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
function check() {
    var num = document.getElementById('Orders_orders_num').value;
    var orders_num = <?php echo $model -> orders_num - $model -> orders_status; ?>;

    if (num <= orders_num) {
        if (confirm('确定取票'+num+'张')) {
            return true;
        } else {
            return false;
        }
    } else {
        alert('张数不能大于'+orders_num);
        return false;
    }
}
</script>
