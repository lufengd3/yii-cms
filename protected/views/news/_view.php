<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_title')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->news_title), 'view/'.$data -> news_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_date')); ?>:</b>
	<?php echo CHtml::encode($data->news_date); ?>
	<br />


</div>
