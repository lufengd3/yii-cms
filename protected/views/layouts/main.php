<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
        <?php 
            $role = Yii::app() -> user -> roles;
            if ($role == 4) {
                $orders = array('label' => '订单管理', 'url' => array('/orders/admin'), 
                        'items' => array(
                            array('label' => '创建订单', 'url' => array('/orders/create')),
                        ),
                ); 
            } else {
				$orders = array('label'=>'订单管理', 'url'=>array('/orders/admin'));
            }

            $role != 1 ? $ask = '/ask/index' : $ask = '/ask/admin';
        ?>

		<?php $this->widget('ext.emenu.EMenu',array(
			'items'=>array(
                array('label'=>'我的面板', 'url'=>array('/site/index'),
                    'items' => array(
                        array('label'=>'提问', 'url'=>array($ask)),
                        array('label'=>'更改密码', 'url'=>array('/user/pwChange/'.Yii::app() -> user -> id)),
                ),
            ),
            array('label'=>'代理管理', 'url'=>array('/user/admin'), 
                'items' => array(
                    array('label' => '添加代理', 'url' => array('/user/create')),
                ),
                'visible' => Yii::app() -> user -> roles < 4
                ),
                array('label' => '渠道价格管理', 'url' => array('/ticketType/tongyi'), 'visible' => Yii::app() -> user -> roles == 3),
                $orders,
				array('label'=>'销售管理', 'url'=>array('/orders/sell')),
                array('label' => '充值记录', 'url' => array('charge/admin')),
				array('label'=>'帐目明细', 'url'=>array('/log/admin')),
                array('label'=>'票务类型管理', 'url'=>array('/ticketType/admin'), 
                    'items' => array(
                        array('label'=>'景区管理', 'url'=>array('/area/admin')),
            //            array('label' => '票种管理', 'url' => array('/ttype/admin')),
                    ),
                    'visible' => Yii::app() -> user -> roles == 1
            ),
            array('label'=>'公告', 'url'=>array('/news/admin'),
                    'items' => array(
                        array('label' => '新建公告', 'url' => array('/news/create')),
                    ),
                    'visible' => Yii::app() -> user -> roles == 1
            ),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'安全退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
 
            ),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
