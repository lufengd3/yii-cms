<?php
/* @var $this PriceController */
/* @var $model Price */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo '票务类型：'.TicketType::model() -> getTicketName($model -> price_ticket); ?>
	</div>

	<div class="row">
		<?php echo '成本价：'.$ticket -> ticket_type_cost; ?>
	</div>

	<div class="row">
		<?php echo '市场价：'.$ticket -> ticket_type_market_price; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_money'); ?>
        <?php /*echo $form->textField($model,'price_money', array(
                'ajax' => array(
                    'type' => 'post',
                    'url' => Ccontroller::createUrl('price/compare_price'),
                    'update' => '#price_money_em',
                ),
            ));*/ ?>
        <?php echo $form->textField($model,'price_money'); ?>
		<?php echo $form->error($model,'price_money'); ?>
	</div>
	<div class="row">
        <?php echo $form->hiddenField($model,'price_ticket'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
