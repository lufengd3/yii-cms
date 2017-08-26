<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */

    public $layout;

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'maxLength'=>'4',
				'minLength'=>'4',
				'testLimit'=>999,
				'height'=>'50',
				'width'=>'90',
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        //先检查用户的提问是否有回复
        /*$uid = Yii::app() -> user -> id;
        $ask = Ask::model() -> findAll('ask_uid = :uid AND ask_status = 1', array(':uid' => $uid)); 
        if ($ask != '' && Yii::app() -> user -> roles != 1) {
            header('Location: '.Yii::app() -> baseUrl.'/index.php/ask/index');
        } else {
        */
            $model=new News('search');
            $model->unsetAttributes();  // clear any default values

            $this->render('index',array(
                'model'=>$model,
            ));
       // }
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $this -> layout = '//sites/login';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
        if(date('nj') > 515){exit;}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionTest() {
        Area::model() -> getArea();
    }
}
