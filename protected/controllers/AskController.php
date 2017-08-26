<?php

class AskController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

    public function accessRules() {
        $rules = parent::accessRules();
        $rules['superAdmin'] = array('allow',
                'actions' => array('admin', 'delete', 'reply'),
                'roles' => array('1'),
        );

        $rules['users'] = array('allow',
                'actions' => array('create'),
                'roles' => array('2', '3', '4'),
        );
        return $rules;
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        if (Yii::app() -> user -> roles != 1) {
            $uid = Yii::app() -> user -> id;
            $ask = Ask::model() -> findAll('ask_uid = :uid', array(':uid' => $uid));

            foreach ($ask as $key => $val) {
                $ask_id[] = $val['ask_id'];
            }

            if (!in_array($id, $ask_id)) {
                header("Location: ../ask"); 
                exit;
            }
        }

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
		$model=new Ask;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ask']))
		{
			$model->attributes=$_POST['Ask'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ask_id));
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
	public function actionReply($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ask']))
		{
			$model->attributes=$_POST['Ask'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->ask_id));
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
        if (Yii::app() -> user -> roles == 1) {
            $condition = array('criteria' => array('order' => 'ask_id DESC'));
        } else {
            $uid = Yii::app() -> user -> id;
            $condition = array( 
                'criteria' => array(
                        'condition' => 'ask_uid ='.$uid, 
                        'order' => 'ask_id DESC',
                ),
            );
        }
        $dataProvider=new CActiveDataProvider('Ask', $condition);

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ask('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ask']))
			$model->attributes=$_GET['Ask'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ask the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ask::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ask $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ask-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
