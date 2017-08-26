<?php

/**
 * This is the model class for table "price".
 *
 * The followings are the available columns in table 'price':
 * @property integer $price_id
 * @property integer $price_ticket
 * @property integer $price_money
 * @property integer $price_agent
 * @property integer $price_user
 */
class Price extends CActiveRecord
{
//    public $tid;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Price the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('tid', 'safe'),
			//array('price_ticket, price_money, price_agent, price_user', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('price_id, price_ticket, price_money, price_agent, price_user, price_area', 'safe'),
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
			'price_id' => 'Price',
            'price_area' => ' 所属官方',
			'price_ticket' => '票务类型',
			'price_money' => '票价',
			'price_agent' => '一级代理',
			'price_user' => '二级代理',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('price_id',$this->price_id);
		$criteria->compare('price_ticket',$this->price_ticket);
		$criteria->compare('price_money',$this->price_money);
		$criteria->compare('price_agent',$this->price_agent);
		$criteria->compare('price_user',$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    // set the initial price
    public function setInitPrice($ticket_id) {
        $area = TicketType::model() -> getArea($ticket_id);
        $allValue = '';

        //foreach user and agent
        $agent = User::model() -> findAll('user_level = :level', array('level' => 3));

        foreach ($agent as $key => $val) {
            $user = User::model() -> findAll('user_father = :father', array('father' => $val -> user_id));

            foreach ($user as $name => $value) {
                  $allValue .= "('".$area."', '".$ticket_id."', '0', '".$val -> user_id."', '".$value -> user_id."'),";
            }
        } 

        $allValue = subStr($allValue, 0, -1);

        if ($allValue != '') {
            $sql = 'INSERT INTO price (price_area, price_ticket, price_money, price_agent, price_user) VALUES '.$allValue;
            Yii::app() -> db -> createCommand($sql) -> execute(); 
        }
    }

    public function changeAll($money, $tid) {
        $price = $this -> findAll('price_agent = :uid AND price_ticket = :tid', array(':uid' => Yii::app() -> user -> id, ':tid' => $tid));
        foreach ($price as $key => $val) {
            $val -> price_money = $money;
            //print_r($val -> attributes);
            $val -> save(); 
        }

        return true;
    }

    public function getMyArea() {
        $area = $this -> findAll('price_money != 0 AND price_user = :uid', array(':uid' => Yii::app() -> user -> id));
        foreach ($area as $key => $val) {
            $val -> price_agent = Area::model() -> getAreaName($val -> price_area);
        }
        return CHtml::listData($area, 'price_area', 'price_agent');
    }

    public function getPrice($tid, $uid) {
        $data = $this -> find('price_ticket = :tid AND price_user = :uid AND price_money != 0',
            array(':tid' => $tid, ':uid' => $uid)
        ); 

        return $data['price_money'];
    }

    public function newUserPrice($uid) {
        $aid = User::model() -> find('user_id = :uid', array(':uid' => $uid)) -> user_father;
        $area = Area::model() -> findAll();
        $allValue = '';
                
        foreach ($area as $key => $val) {
            $allTicket = TicketType::model() -> findAll('ticket_type_areaid = :father', array('father' => $val -> area_id));

            foreach ($allTicket as $name => $value) {
                  $allValue .= "('".$val -> area_id."', '".$value -> ticket_type_id."', '0', '".$aid."', '".$uid."'),";
            }
        } 

        $allValue = subStr($allValue, 0, -1);

        if ($allValue != '') {
            $sql = 'INSERT INTO price (price_area, price_ticket, price_money, price_agent, price_user) VALUES '.$allValue;
            Yii::app() -> db -> createCommand($sql) -> execute(); 
        }

    }

    function del($id) {
        $price = $this -> findAll('price_ticket = :tid', array(':tid' => $id));
        foreach ($price as $key => $val) {
            $val -> delete(); 
        }

    }

}
