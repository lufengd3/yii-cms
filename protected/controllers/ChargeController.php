<?php

class ChargeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

    public function accessRules() {
        $rules = parent::accessRules();

        $rules['agents'] = array('allow',
                'actions' => array('create', 'tui'),
                'roles' => array('1', '2', '3'),
        );
        $rules['online'] = array('allow',
                'actions' => array('admin'),
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
        $roles = Yii::app() -> user -> roles;
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: '.Yii::app() -> baseUrl.'/index.php/charge/admin');
            exit;
        }

        $user = User::model() -> findByPk($_GET['id']);
        if ($roles >= $user['user_level']) {
            header('Location: '.Yii::app() -> baseUrl.'/index.php/charge/admin');
            exit;
        }

		$model=new Charge;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Charge']))
		{
			$model->attributes=$_POST['Charge'];
            $model -> charge_to = $_GET['id'];
            $model -> charge_type = 1;

			if($model->save()) {
                if (User::model() -> updateMoney($model -> charge_to, 1, $model -> charge_money)) {
                    $this->redirect(Yii::app() -> baseUrl.'/index.php/charge/admin');
                } else {
                    echo "ERROR!";exit;
                }
            }
        }
        //    $roles = Yii::app() -> user -> roles;
        //    $getrole = User::model() -> getUserRoles($_GET['id']);

        $model -> charge_to = $_GET['id'];

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionTui()
	{
		$model=new Charge;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Charge']))
		{
			$model->attributes=$_POST['Charge'];
            $model -> charge_to = $_GET['id'];
            $model -> charge_type = 2;

			if($model->save()){
                if (User::model() -> updateMoney($model -> charge_to, 2, $model -> charge_money)) {
                    $this->redirect(Yii::app() -> baseUrl.'/index.php/charge/admin');
                } else {
                    echo "ERROR!";exit;
                }
            }
		}

        $model -> charge_to = $_GET['id'];

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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Charge']))
		{
			$model->attributes=$_POST['Charge'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->charge_id));
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
		$dataProvider=new CActiveDataProvider('Charge');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Charge('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Charge'])) {
            $model->attributes=$_GET['Charge'];
            if ($model -> charge_to != '') {
                $user = User::model() -> find('user_name LIKE :uname', array(':uname' => $_GET['Charge']['charge_to'].'%'));
                $user['user_id'] == '' ? '' : $model -> charge_to = $user['user_id'];
            }
            if ($model -> charge_man_id != '') {
                $admin = User::model() -> find('user_name LIKE :uname', array(':uname' => $_GET['Charge']['charge_man_id'].'%'));
                $admin['user_id'] == '' ? '' : $model -> charge_man_id = $admin['user_id'];
            }
        }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Charge the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Charge::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Charge $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='charge-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    //充值消费记录
    public function actionCharge() {
        echo "充值消费记录"; 
        exit;
    }
}
