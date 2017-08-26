<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=Controller::getBread();
?>

<h1>公告</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
