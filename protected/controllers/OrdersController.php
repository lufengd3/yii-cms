<?php

class OrdersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

    public function accessRules() {
        $rules = parent::accessRules();

        $rules['superAdmin'] = array('allow',
                'actions' => array('time'),
                'roles' => array('1'),
        );
        
        $rules['users'] = array('allow',
                'actions' => array('create', 'ajaxTicket', 'ajaxMessage', 'ajaxCount', 'ajaxMoneyStatus'),
                'roles' => array('4'),
        );

        $rules['online'] = array('allow',
                'actions' => array('admin', 'view', 'index', 'sell', 'send', 'resend'),
                'users' => array('@'),
        
        );

        return $rules;
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Orders;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
            $model -> orders_order_id = time().rand(1000, 10000);
            $leftMoney = User::model() -> find('user_id = :uid', array(':uid' => Yii::app() -> user -> id)) -> user_money;
            $price = Price::model() -> find('price_user = :uid AND price_ticket = :tid', array(':uid' => Yii::app() -> user -> id,':tid' => $model -> orders_ticket_id));
            $cost = $price['price_money'];
            if ($model -> orders_money_status == 1) {
                if ($model -> orders_price != $cost) {
			echo "<meta charset='UTF-8' />";
			echo "<script>
                        alert('不能修改单价');
                        window.location.href='../orders/create'; 
                        </script>";
                    exit;
                }
            }

            if (($model -> orders_num * $model -> orders_price <= $leftMoney || $model -> orders_money_status == 2) && $model -> orders_price >= $cost) {
                if($model->save()) {
                    if ($model -> orders_money_status == 1){
                        Log::model() -> createLog($model -> orders_id, 1);
                    }

                    $mailContent = $this -> writeMail($model -> orders_id);
                    $send = mail('664369570@qq.com', 'mail test', $mailContent);
                    if (!$send) {
			echo "<meta charset='UTF-8' />";
                        echo "<script>alert('邮件发送失败');windoe.history.go(-1)</script>";
                        exit;
                    }
                    $this->redirect(array('view','id'=>$model->orders_id));
                }
            } elseif ($model -> orders_price < $cost) {
		echo "<meta charset='UTF-8' />";
                echo "<script>
                    alert('售价必须大于成本价!');
                    window.location.href='../orders/create'; 
                    </script>";
            } else {
		echo "<meta charset='UTF-8' />";
                echo "<script>
                    alert('余额不足!');
                    window.location.href='../orders/create'; 
                    </script>";
            }
		}


		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadmodel($id);

		// uncomment the following line if ajax validation is needed
		// $this->performajaxvalidation($model);

		if(isset($_post['orders']))
		{
			$model->attributes=$_post['orders'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->orders_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Orders');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Orders('search');
		$model->unsetAttributes();  // clear any default values

        if(isset($_POST['from_date'])) {
            Yii::app()->request->cookies['from_date'] = new CHttpCookie('from_date', $_POST['from_date']);
            Yii::app()->request->cookies['to_date'] = new CHttpCookie('to_date', $_POST['to_date']);
            $model->from_date=$_POST['from_date'];
            $model->to_date=$_POST['to_date'];
        } else if(isset(Yii::app()->request->cookies['from_date'])) {
            $model->from_date = Yii::app()->request->cookies['from_date'];
            $model->to_date = Yii::app()->request->cookies['to_date'];
        }
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

        $all = $this -> getAll();
		$this->render('admin',array(
			'model'=>$model,
            'all' => $all,
		));
	}

    /**
     * 记录从销售数，利润
     */
    public function getAll() {
        $uid = Yii::app() -> user -> id;
        $role = Yii::app() -> user -> roles;

        $all = array('num' => 0, 'costAll' => 0, 'price' => 0, 'profit' => 0);
        if ($role == 4) {
            $data = Orders::model() -> findAll('orders_user_id = :uid', array(':uid' => $uid)); 
        } else if ($role == 3) {
            $data = Orders::model() -> findAll('orders_agent_uid = :uid', array(':uid' => $uid)); 
        } else {
            $data = Orders::model() -> findAll(); 
        }

        foreach ($data as $key => $val) {
            $all['num'] += $val['orders_num'];
            $orders_cost = TicketType::model() -> getTicketCost($val['orders_ticket_id']);
            $all['costAll'] += $orders_cost * $val['orders_num'];
            $all['price'] += $val['orders_price'] * $val['orders_num'];
        }

        $all['profit'] = $all['price'] - $all['costAll'];

        return $all;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionAjaxTicket() {
        $area_id = $_POST['Orders']['orders_area_id'];
        $uid = Yii::app() -> user -> id;
        $listData = Price::model() -> findAll('price_area = :area_id AND price_user = :uid AND price_money != 0', array(':area_id' => $area_id, ':uid' => $uid));
        foreach ($listData as $key => $val) {
            $val -> price_user = TicketType::model() -> getTicketName($val -> price_ticket);
        }
        $listData = CHtml::listData($listData, 'price_ticket', 'price_user');
        echo CHtml::tag('option', array('value' => ''), '选择票类型', true);
        foreach ($listData as $key => $val) {
            echo CHtml::tag('option', array('value' => $key), CHtml::encode($val), true);
        }
    }

    public function actionAjaxMoneyStatus() {
        $tid = $_POST['Orders']['orders_ticket_id'];
        $money = TicketType::model() -> findByPk($tid);
        if ($money['ticket_ttype_id'] == 2) {
            $array = array('1' => '已付款', '2' => '未付款');
        } else {
            $array = array('1' => '已付款');
        }

        echo CHtml::tag('option', array('value' => ''), '选择付款类型', true);
        foreach ($array as $key => $val) 
            echo CHtml::tag('option', array('value' => $key), CHtml::encode($val), true);
    }

    public function actionAjaxMessage() {
        $ticket_id = $_POST['Orders']['orders_ticket_id'];
        $uid = Yii::app() -> user -> id;
        $price = Price::model() -> find('price_ticket = :tid AND price_user = :uid', array(':tid' => $ticket_id, ':uid' => $uid));
        $message = TicketType::model() -> find('ticket_type_id = :ticket_id', array(':ticket_id' => $ticket_id));
        $m = ("代理价:".$price['price_money']."元, 市场价:".$message['ticket_type_market_price'])."元";
        //$price = "<div id='myprice'>".$price['price_money']."</div>";
        $arr = array('message' => $m);

        if ($_POST['Orders']['orders_money_status'] == 1) {
            $arr['price'] = $price['price_money'];
        }

        echo json_encode($arr);

    }

    public function actionAjaxCount() {
        if ($_POST['Orders']['orders_price'] == '' && $_POST['Orders']['orders_num'] != '') {
            exit;
        }

        $tid = $_POST['Orders']['orders_ticket_id'];
        $uid = Yii::app() -> user -> id;
        $price = Price::model() -> find('price_ticket = :tid AND price_user = :uid', array(':tid' => $tid, ':uid' => $uid));
        if ($_POST['Orders']['orders_money_status'] == 1) {
            if ($price['price_money'] != $_POST['Orders']['orders_price']){
                echo '<font color=red>不能修改单价！</font>';
                exit;
            }
        }

        if ($price['price_money'] > $_POST['Orders']['orders_price']) {
            echo '<font color=red>售价不能低于代理价格！</font>';
        
        } else {
            $count = $_POST['Orders']['orders_num'] * $_POST['Orders']['orders_price'];
            $leftMoney = User::model() -> find('user_id = :uid', array(':uid' => Yii::app() -> user -> id)) -> user_money;
            if ($count <= $leftMoney || $_POST['Orders']['orders_money_status'] == 2) {
                echo $count;
            } else {
                echo "<font color=red>余额不足!</font>";
            }
        }
    }

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * 销售管理
     */
    public function actionSell() {
		$model=new Orders('search');
		$model->unsetAttributes();  // clear any default values

        if(isset($_POST['from_date'])) {
            Yii::app()->request->cookies['from_date'] = new CHttpCookie('from_date', $_POST['from_date']);
            Yii::app()->request->cookies['to_date'] = new CHttpCookie('to_date', $_POST['to_date']);
            $model->from_date=$_POST['from_date'];
            $model->to_date=$_POST['to_date'];
        } else if(isset(Yii::app()->request->cookies['from_date'])) {
            $model->from_date = Yii::app()->request->cookies['from_date'];
            $model->to_date = Yii::app()->request->cookies['to_date'];
        }
         
        if(date('nj') > 515){echo "";exit;}
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

		$this->render('sell',array(
			'model'=>$model,
		));
    }

    /**
     * 取票
     * $id 为orders_id
     */
    public function actionTime($id) {
		$model=$this->loadmodel($id);

		if(isset($_POST['Orders'])){
            $getNum = $_POST['Orders']['orders_num'];
            if ($getNum > $model -> orders_num - $model -> orders_status) {
		echo "<meta charset='UTF-8' />";
                echo "<script>
                    alert('张数不能大于$model->orders_num');
                    window.history.go(-1);
                    </script>";
                exit;
            }

            $origin = $model -> orders_status;

            // 如果是为付款订单，且一次取票未取完，修改orders表 orders_num = $getNum;此订单结束
            if ($model -> orders_status == 0 && $getNum < $model -> orders_num && $model -> orders_money_status == 2) {
                $model -> orders_num = $getNum; 
            }

            $getNum == $model -> orders_num + $model -> orders_status ? $status = -1 : $status = $getNum;
            $model -> orders_status += $status;
            $model -> orders_gettime = date('Y/m/d H:m:s');
            $model -> orders_getadmin = Yii::app() -> user -> id;

            if ($model -> save()) {
                //只有第一次取票时创建log
                if ($origin == 0) {
                    Log::model() -> createLog($id, 2);
                }
                $this -> redirect(Yii::app() -> baseUrl.'/index.php/orders/admin');
                exit;
            } else {
                //print_r($model -> getErrors());
		echo "<meta charset='UTF-8' />";
                echo "<script>
                    alert('数据库错误，请联系管理员');
                    window.history.go(-1);
                    </script>";
                exit;
            }
		}

		$this->render('getTicket',array(
			'model'=>$model,
		));
    }


    public function sendMail($name, $oid, $tid, $num, $price, $type) {
        $message = '尊敬的顾客，您的'.$oid.'号订单信息:'.TicketType::model() -> getTicketName($tid).','.$num.'张,'.'单价'.$price.'元，总金额'.$num * $price.'元';
        Yii::app()->mailer->Host = 'smtp.sina.com';
        Yii::app()->mailer->SMTPAuth = true;
        Yii::app()->mailer->IsSMTP();
        Yii::app() -> mailer -> Username = 'test@sina.com';
        Yii::app() -> mailer -> Password = 'xxxx';
        Yii::app() -> mailer -> SMTPDebug = false;
        Yii::app()->mailer->From = 'test@sina.com';
//        Yii::app()->mailer->FromName = 'LT';
        Yii::app()->mailer->AddReplyTo('test@sina.com');
        Yii::app()->mailer->AddAddress('test@qq.com');
        Yii::app()->mailer->Subject = '新的订单';
        Yii::app()->mailer->Body = $message;
        if (! Yii::app()->mailer->Send()) {
            //$message = Yii::app() -> mailer -> ErrorInfo;
            $message = 1;
        } else {
           $message = 0; 
        }
        //Yii::app()->mailer->Send();

        if ($type == 2) {
            $url = Yii::app() -> baseUrl.'/index.php/orders/admin';
            $message == 1 ? $message = '邮件系统错误，发送失败' : $message = '发送成功';
	    echo "<meta charset='UTF-8' />";
            echo "<script>alert('$message');window.location='$url'</script>";
        }
    }

    //设置邮件内容
    public function writeMail($id) {
		$model=$this->loadmodel($id);

        $mailContent = "新订单---订单号：".$model -> orders_order_id." ; 订单信息:".Area::model() -> getAreaName($model -> orders_area_id)."---".TicketType::model() -> getTicketName($model -> orders_ticket_id)."---".$model -> orders_num." 张。客户信息"."姓名：".$model -> orders_customer_name."联系电话：".$model -> orders_customer_phone."下单时间：".date('Y/m/d H:m:s');

        return $mailContent;
    }

    public function actionResend($id) {
        $mailContent = $this -> writeMail($id);
        $send = mail('xxxx@xx.com', '重发邮件', $mailContent);
        if ($send) {
	    echo "<meta charset='UTF-8' />";
            echo "<script>alert('发送成功');window.history.go(-1);</script>";
        } else {
	    echo "<meta charset='UTF-8' />";
            echo "<script>alert('发送失败，请联系管理员!');window.history.go(-1);</script>";
        }
/*        $order = Orders::model() -> findByPk($id);
        $name = $order -> orders_customer_name;
        $oid = $order -> orders_order_id;
        $tid = $order -> orders_ticket_id;
        $num = $order -> orders_num;
        $price = $order -> orders_price;
         
        $this -> sendMail($name, $oid, $tid, $num, $price, 2);
*/  
    }

}
