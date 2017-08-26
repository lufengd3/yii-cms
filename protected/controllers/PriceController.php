<?php

class PriceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function accessRules()
	{
        $rules = parent::accessRules();
        
        $rules['superUsers'] = array('allow',
                'actions' => array('admin', 'create'),
                'roles' => array('1'),
            
        );

        $rules['agents'] = array('allow',
                'actions' => array('admin', 'create', 'update', 'changeAll', 'compare_price'),
                'roles' => array('3'),
            
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
		$model=new Price;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Price']))
		{
			$model->attributes=$_POST['Price'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->price_id));
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
		$model=$this->loadModel($id);

        if ($model -> price_agent != Yii::app() -> user -> id) {
	   echo "<meta charset='UTF-8' />";
           echo "<script>alert('非法操作');window.history.go(-1);</script>";
           exit;
        }
        $ticket = TicketType::model() -> findByPk($model -> price_ticket);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Price']))
		{
			$model->attributes=$_POST['Price'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->price_id));
		}

		$this->render('update',array(
			'model'=>$model,
            'ticket' => $ticket,
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
		$dataProvider=new CActiveDataProvider('Price');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{
        $user = User::model() -> findByPk($id);
        if ($user -> user_father != Yii::app() -> user -> id) {
            echo "<script>window.history.go(-1);</script>";
            exit;
        }
		$model=new Price('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Price'])) {
            $model->attributes=$_GET['Price'];
            if ($model -> price_ticket != '') {
                $ticket = TicketType::model() -> find('ticket_type_name LIKE :tname', array(':tname' => $_GET['Price']['price_ticket'].'%'));
                $ticket['ticket_type_id'] == '' ? '' :$model -> price_ticket = $ticket['ticket_type_id'];
            }
        }

		$this->render('admin',array(
			'model'=>$model,
            'id' => $id,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Price the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Price::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Price $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='price-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * 统一代理价格
     * $id means ticket_type_id
     */
	public function actionChangeAll($id)
	{
        $ticket = TicketType::model() -> findByPk($id);
        $agent_id = Yii::app() -> user -> id;
		$model=Price::model() -> find('price_ticket = :id AND price_agent = :aid', array(':id' => $id, ':aid' => $agent_id));

        if ($model -> price_agent !=  $agent_id) {
	   echo "<meta charset='UTF-8' />";
           echo "<script>alert('非法操作');window.history.go(-1);</script>";
           exit;
        }
        $model -> price_user = '';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Price']))
		{
            $tid = $_POST['Price']['price_ticket'];
            $change = Price::model() -> changeAll($_POST['Price']['price_money'], $tid);
            if ($change) {
                $this->redirect(Yii::app() -> baseUrl.'/index.php/ticketType/tongyi');
            } else {
                echo "ERROR!";
            }
		}

		$this->render('update',array(
			'model'=>$model,
            'ticket' => $ticket,
		));
	}

    public function actionCompare_price() {
        $price = $_POST['Price']['price_money'];
        
        if (0) {
            echo "票价不能低于成本价";
        }
    }
}
