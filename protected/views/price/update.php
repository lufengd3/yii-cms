<h2>更新<b>'<?php echo TicketType::model() -> getTicketName($model->price_ticket); ?>'</b>票对二级代理<b>'<?php echo User::model() -> getUserName($model -> price_user) ?>'</b>的价格</h2>

<?php
    $this -> breadcrumbs = Controller::getBread();
    $this -> menu = array(
        array('label' => '票种管理', 'url' => array('price/admin/'.$model -> price_user)),
    );
?>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'ticket' => $ticket)); ?>
