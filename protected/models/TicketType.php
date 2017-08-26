<?php

/**
 * This is the model class for table "ticket_type".
 *
 * The followings are the available columns in table 'ticket_type':
 * @property integer $ticket_type_id
 * @property integer $ticket_type_areaid
 * @property string $ticket_type_name
 * @property integer $ticket_type_cost
 * @property integer $ticket_type_market_price
 * @property integer $ticket_type_agent_price
 */
class TicketType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ticket_type_name, ticket_type_areaid, ticket_ttype_id', 'required'),
			array('ticket_type_cost, ticket_type_market_price', 'numerical', 'integerOnly'=>true),
			array('ticket_type_name', 'length', 'max'=>64),
			array('ticket_type_name', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            array('ticket_type_id', 'safe'),
			array('ticket_type_id, ticket_type_areaid, ticket_type_name, ticket_type_cost, ticket_type_market_price', 'safe', 'on'=>'search'),
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
			'ticket_type_id' => 'Ticket Type',
			'ticket_type_areaid' => '景区',
			'ticket_ttype_id' => '付款类型',
			'ticket_type_name' => ' 票务名称',
			'ticket_type_cost' => '成本价',
			'ticket_type_market_price' => '市场价',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ticket_type_id',$this->ticket_type_id);
		$criteria->compare('ticket_type_areaid',$this->ticket_type_areaid);
		$criteria->compare('ticket_ttype_id',$this->ticket_ttype_id);
		$criteria->compare('ticket_type_name',$this->ticket_type_name,true);
		$criteria->compare('ticket_type_cost',$this->ticket_type_cost);
		$criteria->compare('ticket_type_market_price',$this->ticket_type_market_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TicketType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getTicketType($areaId) {
        if ($areaId != '') {
            $ticketType = $this -> findAllByAttributes(array('ticket_type_areaid' => $areaId));
            return CHtml::listData($ticketType, 'ticket_type_areaid', 'ticket_type_name');
        } else {
            $ticketType = $this -> findAll();
            return CHtml::listData($ticketType, 'ticket_type_id', 'ticket_type_name');
        }
    }

    public function getArea($tid) {
        $ticket = $this -> find('ticket_type_id = :tid', array(':tid' => $tid));
        return $ticket['ticket_type_areaid'];
    }

    /*public function beforeSave() {
        if (parent::beforeSave()) {
            return true;
        } else {
            return false;
        }
    }*/
    
    /**
     * 用于admin页面显示票类型名称
     * 传入参数为 ticket_type_id
     */
    public function getTicketName($id) {
        $name = $this -> findByPk($id);
        return $name['ticket_type_name']; 
    }

    public function getTicketCost($id) {
        $cost = $this -> findByPk($id);
        return $cost['ticket_type_cost'];
    }
}
