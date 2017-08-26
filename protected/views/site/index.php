<?php
/* @var $this SiteController */
$this -> breadcrumbs = Controller::getBread();
$this->pageTitle=Yii::app()->name;
?>
<div class="span-19">
<h1 style="margin-top: 20px; margin-left: 20px">最新公告</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
    'htmlOptions' => array('style' => 'width: 950px; margin-left: 20px'),
	'columns'=>array(
        array('header' => '序号', 'value' => '++$row', 'htmlOptions' => array('width' => '35px')),
        array('header' => '公告标题', 'name' => 'news_title', 'value' => 'CHtml::link($data -> news_title, Yii::app() -> baseUrl."/index.php/news/view/".$data -> news_id)', 'type' => 'html', 'htmlOptions' => array('width' => '160px')),
		array('name' => 'news_content', 'value' => 'News::model() -> getSummary($data -> news_content)'),
        array('header' => '发表日期', 'name' => 'news_date', 'filter' => Controller::getYear('news_date', 'news'), 'htmlOptions' => array('width' => '80px')),
	),
)); ?>

