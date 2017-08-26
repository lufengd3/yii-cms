<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_passwd
 * @property integer $user_level
 * @property string $user_father
 * @property integer $user_money
 */
class User extends CActiveRecord
{
    protected $salt = 'fcku';
    public $user_passwd_repeat;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_level, user_name, user_passwd, user_passwd_repeat', 'required'),
            array('user_name', 'unique'),
			array('user_level, user_money', 'numerical', 'integerOnly'=>true),
			array('user_name', 'length', 'max'=>32),
			array('user_passwd', 'length', 'min'=>6, 'max'=>32),
            array('user_passwd', 'compare'),
            array('user_id, user_father, user_passwd_repeat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_name, user_level, user_father, user_money', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'user_id' => '用户id',
			'user_name' => '用户名',
			'user_passwd' => '密码',
            'user_passwd_repeat' => '确认密码',
			'user_level' => '用户级别',
		);
    }
    
    /**
     * 添加用户和admin界面搜索用户时使用
     * 返回低于当前角色的其它角色的下拉框
     */
    public function getLevel() {
        
        $roles = Yii::app() -> user -> roles;
        $level = array();
        $level['1'] = '超级管理员';
        $level['2'] = '二级管理员';
        $level['3'] = '一级代理';
        $level['4'] = '二级代理';

        if ($roles != 1) {
            for ($i = 0; $i <= $roles; $i++) {
                unset($level[$i]);
            }
        } else if (Yii::app() -> controller -> action -> id != 'admin') {
            unset($level['4']);
        }

        return $level;
    }

    /**
     * admin界面显示每个等级的名称
     * 传入参数为等级id
     */
    public function getRolesName($roleid) {
        switch($roleid) {
            case 1: $roleName = '超级管理员'; break;
           // case 2: $roleName = '二级管理员'; break;
            case 3: $roleName = '一级代理'; break;
            case 4: $roleName = '二级代理'; break;
        }

        return $roleName;
    }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        /**
         * 如果是超级管理员，显示全部用户
         * 如果是二级管理员，显示除超级管理员的其他用户
         * 如果是一级代理，只显示他添加的用户
         * 二级代理无权限访问此页面
         */
        $role = Yii::app() -> user -> roles;

        if ($role == 2) {
//            $criteria -> addInCondition('user_level', array('4','3'));
            $criteria -> addCondition('user_level > 2');
        } elseif ($role == 3) {
            $criteria -> addCondition('user_father = '.Yii::app() -> user -> id);
        }

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_passwd',$this->user_passwd,true);
		$criteria->compare('user_level',$this->user_level);
		$criteria->compare('user_father',$this->user_father,true);
		$criteria->compare('user_money',$this->user_money);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function validatePasswd($user_passwd) {
        return $this -> hashPasswd($user_passwd, $this -> salt) === $this -> user_passwd;
    }
    
    public function hashPasswd($user_passwd, $salt) {
        return md5($user_passwd.$salt);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            $actionId =  Yii::app() -> controller -> action -> id;
            $uid = Yii::app() -> user -> id;

            /**
             * 添加及更新用户的时候新用户角色只能为当前角色的下级
             */
            if ($actionId == 'create' ) {
                $this -> user_passwd = self::hashPasswd($this -> user_passwd, $this -> salt);
                $this -> user_father = $uid;
                if ($this -> user_level > 2) {
                    $this -> user_money = 0;
                }

                if ($this -> user_level <= Yii::app() -> user -> roles && $this -> user_level != 1) {
                    echo "<script>alert('非法操作');</script>";
                    return false;
                }
            } else if ($actionId == 'update') {
                    $this -> user_passwd = self::hashPasswd($this -> user_passwd, $this -> salt);
                if ($this -> user_level < Yii::app() -> user -> roles) {
                    echo "<script>alert('非法操作');</script>";
                    return false;
                }
            } else {
                //更新密码的时候视图中不显示用户级别，这里给其赋值，等级不变
                //user_father不能改变
                //if ($actionId == 'pwChange') {
                $this -> user_level = Yii::app() -> user -> roles;
                $user = User::model() -> find('user_id = :uid', array(':uid' => $uid));
                $this -> user_father = $user['user_father'];
                $this -> user_passwd = self::hashPasswd($this -> user_passwd, $this -> salt);
            }

            return true;
        } else {
            return false;
        }
    }

    public function getUserName($uid) {
        $uname = $this -> find('user_id = :uid', array(':uid' => $uid)); 
        return $uname['user_name'];
    }

    public function getUserRoles($uid) {
        $uname = $this -> find('user_id = :uid', array(':uid' => $uid)); 
        return $uname['user_level'];
    }

    /**
     * chongzhi & huitui
     * $type = 1, user_money + $money
     * $type = 2, user_money - $money
     */
	public function UpdateMoney($id, $type, $money){
        $roles = Yii::app() -> user -> roles;
        $uid = Yii::app() -> user -> id;
        if ($type == 1) {
            $sql = 'UPDATE user SET user_money = user_money + '.$money.' WHERE user_id = '.$id;
            if ($roles = 3) {
                $sql2 = 'UPDATE user SET user_money = user_money - '.$money.' WHERE user_id = '.$uid;
                Yii::app() -> db -> createCommand($sql2) -> execute();
            }
        } else {
            $sql = 'UPDATE user SET user_money = user_money - '.$money.' WHERE user_id = '.$id;
            if ($roles = 3) {
                $sql2 = 'UPDATE user SET user_money = user_money + '.$money.' WHERE user_id = '.$uid;
                Yii::app() -> db -> createCommand($sql2) -> execute();
            }
        }

        if (Yii::app() -> db -> createCommand($sql) -> execute()) {
            return true;
        } else {
            return false;
        }
	}
    
    public function getMoney() {
        $actionId = Yii::app() -> controller -> action -> id;
        
        if ($actionId == 'tui') {
            $uid = $_GET['id'];
            $user = $this -> find('user_id = :uid', array(':uid' => $uid));
            return $user['user_money'];
        } else {
            $uid = Yii::app() -> user -> id;
            $user = $this -> find('user_id = :uid', array(':uid' => $uid));

            if (Yii::app() -> user -> roles != 1) {
                return $user['user_money'];
            } else {
                return 1000000;
            }
        }
    }

}

