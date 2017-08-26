<?php
/* @var $this TtypeController */
/* @var $data Ttype */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ttype_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ttype_id), array('view', 'id'=>$data->ttype_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ttype_name')); ?>:</b>
	<?php echo CHtml::encode($data->ttype_name); ?>
	<br />


</div>