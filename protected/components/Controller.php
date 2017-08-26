<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}
	

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$rules = array();

		$rules['guest'] = array('allow',  // allow all guests to perform 'index' and 'view' actions
				'actions'=>array('login', 'logout', 'Error', 'captcha'),
				'users'=>array('*'),
		);
        
		$rules['superAdmin'] = array('allow', // allow admin
				'actions'=>array('', 'create'),
				'roles'=>array('1'),
		);
        
		$rules['admins'] = array('allow', // allow admin
				'actions'=>array(''),
				'roles'=>array('2'),
		);

		$rules['agents'] = array('allow', // allow admin
				'actions'=>array(''),
				'roles'=>array('3'),
		);
        
		$rules['users'] = array('allow', // allow admin
				'actions'=>array(''),
				'roles'=>array('4'),
		);

        $rules['online'] = array('allow',
                'actions' => array('index', 'view'),
                'users' => array('@'), 
        );

        $rules['deny'] = array('deny',  // deny all users
				'users'=>array('*'),
		);
		return $rules;
    }

    /**
     * 用于admin表中的filter
     */
    public function getYear($column, $table) {
        $sql = "SELECT SUBSTRING($column, 1, 4) AS year FROM $table ORDER BY year DESC";
        $year = Yii::app() -> db -> createCommand($sql) -> queryAll();
        return CHtml::listData($year, 'year', 'year');
    }

    public function getBread() {
        $bread = array(
        '用户名:'.Yii::app() -> user -> name,
        '权限：'.User::model() -> getRolesName(Yii::app() -> user -> roles),
        '余额：'.User::model() -> find('user_id = :uid', array(':uid' => Yii::app() -> user -> id)) -> user_money.'元',
 );
        if (Yii::app() -> user -> roles < 3) {
            array_pop($bread);
        }
        return $bread;
    }

}
