<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $log_id
 * @property string $log_user
 * @property string $log_order
 * @property integer $log_uget
 * @property integer $log_aget
 * @property string $log_time
 * @property string $log_admin
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
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
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('log_id, log_order_id, log_user, log_order, log_uget, log_aget, log_time, log_admin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('log_id, log_user, log_order, log_uget, log_aget, log_time, log_admin', 'safe', 'on'=>'search'),
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
			'log_id' => 'Log',
			'log_user' => '用户',
			'log_order' => '说明',
			'log_uget' => '二级代理利润',
			'log_aget' => '一级代理利润',
			'log_time' => '时间',
			'log_admin' => '操作员',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $uid = Yii::app() -> user -> id;
        $allUser = array();

        if (Yii::app() -> user -> roles == 4) {
            $criteria -> addCondition('log_user = '.$uid);
        } else if (Yii::app() -> user -> roles == 3) {
            $users = User::model() -> findAll('user_father = :uid', array(':uid' => $uid));

            foreach ($users as $key => $val) {
                $allUser[]  = $val -> user_id;
            }
            
            $criteria -> addInCondition('log_user', $allUser);
        }

		$criteria->compare('log_id',$this->log_id);
		$criteria->compare('log_order_id',$this->log_order_id);
		$criteria->compare('log_user',$this->log_user,true);
		$criteria->compare('log_order',$this->log_order,true);
		$criteria->compare('log_uget',$this->log_uget);
		$criteria->compare('log_aget',$this->log_aget);
		$criteria->compare('log_time',$this->log_time,true);
		$criteria->compare('log_admin',$this->log_admin,true);

        $criteria -> order = 'log_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * The log of orders
     * $id means the orders_id
     * $type == 1 means hadn't paid
     * $type == 2 means have paid
     */
    public function createLog($id, $type) {
        $order = Orders::model() -> findByPk($id);

        $tid = $order['orders_ticket_id'];
        $uid = $order['orders_user_id'];
        $aid = $order['orders_agent_uid'];

        //成本价 
        $cost = TicketType::model() -> find('ticket_type_id = :tid', array(':tid' => $tid)) -> ticket_type_cost;
        //一级代理价
        $price = Price::model() -> find('price_ticket = :tid AND price_user = :uid', array(':tid' => $tid, ':uid' => $uid)) -> price_money;
        //二级代理价
        $sell = $order['orders_price'];
        $num = $order['orders_num'];

        // 下单时已付款订单
        if ($type == 1) {
            $typeName = '已付款';
        } else if ($order['orders_money_status'] == 2) {
            $typeName = '未付款';
        }

        // 取票时判断是否为已付款订单
        // 已付款订单更新记录
        // 未付款订单创建新记录
        if ($type == 2 && $order['orders_money_status'] == 1) {
            $log = $this -> find('log_order_id = :id', array(':id' => $order['orders_order_id']));
        } else {
            $log = new Log;
            $log -> log_order_id = $order['orders_order_id'];
            $log -> log_user = $order['orders_user_id'];
            $log -> log_order = $typeName.'订单'.$order['orders_order_id']."#".TicketType::model() -> getTicketName($order['orders_ticket_id']);
            $log -> log_uget = $num * ($sell - $price);
            $log -> log_aget = $num * ($price - $cost);

            if ($type == 1) {
                $sql1 = 'UPDATE user SET user_money = user_money - '.$num * $price.' WHERE user_id = '.$uid;
            } else {
                $sql1 = 'UPDATE user SET user_money = user_money + '.$log -> log_uget.' WHERE user_id = '.$uid;
            }
                
            $sql2 = 'UPDATE user SET user_money = user_money + '.$log -> log_aget.' WHERE user_id = '.$aid;
        
            Yii::app() -> db -> createCommand($sql1) -> execute();
            Yii::app() -> db -> createCommand($sql2) -> execute();
        }

            $log -> log_time = $order['orders_gettime'];
            $log -> log_admin = $order['orders_getadmin'];

            $log -> save();
    }

}
