<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $orders_id
 * @property string $orders_order_id
 * @property integer $orders_agent_uid   一级代理id
 * @property string $orders_customer_name
 * @property string $orders_customer_phone
 * @property integer $orders_area_id
 * @property integer $orders_ticket_id
 * @property integer $orders_num
 * @property integer $orders_price
 * @property integer $orders_money_status
 * @property string $orders_agent_comment
 * @property string $orders_admin_comment
 * @property string $orders_time
 * @property string $orders_go_date
 * @property string $orders_status
 * $orders_status 0---未取票， -1 ---- 已取票， >0 --- 已取票张数
 *
 * string $orders_user_id  二级代理id
 */
class Orders extends CActiveRecord
{
    public $orders_message; //附加信息
    public $orders_info; //详细信息
    public $from_date;
    public $to_date;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('orders_customer_name, orders_customer_phone, orders_ticket_id, orders_area_id, orders_num, orders_price, orders_money_status, orders_go_date', 'required'),
			array('orders_status, orders_user_id, orders_customer_phone, orders_area_id, orders_ticket_id, orders_num, orders_price, orders_money_status', 'numerical', 'integerOnly'=>true),
            array('orders_num', 'numerical', 'min' => 1),
			array('orders_customer_name', 'length', 'max'=>40),
			array('orders_customer_phone', 'length', 'is'=>11),
			array('orders_agent_comment, orders_admin_comment', 'length', 'max'=>256),
            array('orders_go_date', 'date', 'format' => 'yyyy-mm-dd'),
			array('orders_getadmin, orders_order_id, orders_agent_uid, orders_id, orders_gettime, orders_status, orders_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('from_date, to_date, orders_id, orders_order_id, orders_agent_uid, orders_customer_name, orders_customer_phone, orders_area_id, orders_ticket_id, orders_num, orders_price, orders_money_status, orders_agent_comment, orders_admin_comment, orders_time, orders_go_date, orders_status', 'safe', 'on'=>'search'),
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
            'orders_order_id' => '订单号',
			'orders_customer_name' => '客户姓名',
			'orders_customer_phone' => '客户电话',
			'orders_area_id' => '景区',
			'orders_ticket_id' => '票务类型',
			'orders_num' => '张数',
			'orders_price' => '单价',
			'orders_money_status' => '付款状态',
			'orders_agent_comment' => '代理商备注',
			'orders_admin_comment' => '管理员备注',
			'orders_time' => '下单时间',
            'orders_gettime' => '取票时间',
            'orders_getadmin' => '操作员',
			'orders_go_date' => '预定游玩时间',
			'orders_status' => '订单状态',
            'orders_message' => '附加信息',
            'orders_info' => '详细信息',
		);
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
	public function search($status='')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $role = Yii::app() -> user -> roles;
        $uid = Yii::app() -> user -> id;


        if ($status != '' && $status != 0) {
            $criteria -> addCondition('orders_status != 0'); 
        }

        if(!empty($this->from_date) && empty($this->to_date)) {
            $criteria->condition = "orders_gettime >= '$this->from_date'";  // date is database date column field
        } elseif(!empty($this->to_date) && empty($this->from_date)) {
            $criteria->condition = "orders_gettime <= '$this->to_date'";
        }elseif(!empty($this->to_date) && !empty($this->from_date)) {
            $criteria->condition = "orders_gettime  >= '$this->from_date' AND orders_gettime <= '$this->to_date'";
        }

        if ($role == 3) {
            $criteria -> addCondition('orders_agent_uid = '.$uid);
        } else if ($role == 4) {
            $criteria -> addCondition('orders_user_id = '.$uid);
        
        }

        $criteria -> order = 'orders_id DESC';
		$criteria->compare('orders_id',$this->orders_id);
		$criteria->compare('orders_order_id',$this->orders_order_id,true);
		$criteria->compare('orders_agent_uid',$this->orders_agent_uid);
		$criteria->compare('orders_customer_name',$this->orders_customer_name,true);
		$criteria->compare('orders_customer_phone',$this->orders_customer_phone,true);
		$criteria->compare('orders_area_id',$this->orders_area_id);
		$criteria->compare('orders_ticket_id',$this->orders_ticket_id);
		$criteria->compare('orders_num',$this->orders_num);
		$criteria->compare('orders_price',$this->orders_price);
		$criteria->compare('orders_money_status',$this->orders_money_status);
		$criteria->compare('orders_agent_comment',$this->orders_agent_comment,true);
		$criteria->compare('orders_admin_comment',$this->orders_admin_comment,true);
		$criteria->compare('orders_gettime',$this->orders_gettime,true);
		$criteria->compare('orders_time',$this->orders_time,true);
		$criteria->compare('orders_go_date',$this->orders_go_date,true);
		$criteria->compare('orders_status',$this->orders_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (Yii::app() -> controller -> action -> id == 'create') {
                //订单号由时间戳加3位数字
                //$this -> orders_order_id = time().rand(1000, 10000);

                $uid = Yii::app() -> user -> id;
                $this -> orders_user_id = $uid;
                $this -> orders_status = 0;
                $user = User::model() -> find('user_id = :uid', array(':uid' => $uid));
                $this -> orders_agent_uid = $user['user_father'];
                $this -> orders_time = date('Y/m/d H:m:s');
            }

            return true;
        } else {
            return false;
        }
    }

    public function getMoneyStatus($status) {
        $status == 1 ? $status = '已付款' : $status = '未付款';
        return $status;
    }

    public function getMoneyStatusFilter() {
        $status = $this -> findAllBySql('SELECT * FROM orders GROUP BY orders_money_status');
        foreach ($status as $key => $val) {
            $val['orders_money_status'] == 1 ? $val['orders_id'] = '已付款' : $val['orders_id'] = '未付款';
        }

        return CHtml::listData($status, 'orders_money_status', 'orders_id');
    
    }

    public function getStatus($status, $num) {
        if ($status == -1 || $status == $num) {
            $status = '已取票';
        } elseif ($status == 0) { 
            $status = "<font color=red>未取票</font>"; 
        } else {
            $status = "已取票".$status."张";
        }
        
        return $status;
    }

    public function getStatusFilter() {
        $status = $this -> findAllBySql('SELECT * FROM orders GROUP BY orders_status');
        foreach ($status as $key => $val) {
            $val['orders_status'] == 1 ? $val['orders_id'] = '已取票' : $val['orders_id'] = '未取票';
        }

        return CHtml::listData($status, 'orders_status', 'orders_id');
    
    }

    public function getTotal($records, $column) {
        $total = 0;
        foreach ($records as $record) {
            $total += $record->$column;
        }
        return $total;
    }

    public function getLirun($records, $type) {
        $total = 0;
        foreach ($records as $record) {
            $tid = $record -> orders_ticket_id;
            $num = $record -> orders_num;
            $uid = $record -> orders_user_id;
            $cost = TicketType::model() -> getTicketCost($tid);
            $sell = $record -> orders_price;
            $price = Price::model() -> getPrice($tid, $uid);

            if ($type == 1) {
                $total += $num * ($price - $cost); 
            } else {
                $total += $num * ($sell - $price);
            }
        }
        return $total;
    }

    public function getEachLirun($orderid, $type) {
        $record = $this -> findByPk($orderid);
        $tid = $record['orders_ticket_id'];
        $num = $record['orders_num'];
        $uid = $record['orders_user_id'];
        $sell = $record['orders_price'];
        $cost = TicketType::model() -> getTicketCost($tid);
        $price = Price::model() -> getPrice($tid, $uid);

        if ($type == 1) {
            $lirun = $num * ($price - $cost);
        } else {
            $lirun = $num * ($sell - $price);
        }

        return $lirun;
    }

    public function getCost($records, $type) {
        $total = 0;
        foreach ($records as $record) {
            $uid = $record -> orders_user_id;
            $tid = $record -> orders_ticket_id;
            $num = $record -> orders_num;
            if ($type == 1) {
                $cost = TicketType::model() -> getTicketCost($tid);
                $total += $num * $cost; 
            } else {
                $price = Price::model() -> getPrice($tid, $uid);
                $total += $num * $price; 
            }
        }

        return $total;
    }

    public function getSellTotal($records) {
        $total = 0;
        foreach ($records as $record) {
            $total += $record -> orders_num * $record -> orders_price; 
        }

        return $total;
    }

}
