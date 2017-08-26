<?php

/**
 * This is the model class for table "charge".
 *
 * The followings are the available columns in table 'charge':
 * @property integer $charge_id
 * @property integer $charge_money
 * @property string $charge_date
 * @property integer $charge_man_id
 * @property integer $charge_to
 * @property string $charge_comment
 */
class Charge extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'charge';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('charge_money', 'required'),
			array('charge_money', 'numerical', 'integerOnly'=>true, 'min' => 0, 'max'=>User::model() -> getMoney()),
			array('charge_comment', 'length', 'max'=>45),
			array('charge_to, charge_man_id, charge_date, charge_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('charge_id, charge_money, charge_date, charge_man_id, charge_to, charge_type, charge_comment', 'safe', 'on'=>'search'),
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
			'charge_id' => 'Charge',
			'charge_money' => '金额',
			'charge_date' => '充值日期',
			'charge_man_id' => '操作员',
			'charge_to' => '用户',
			'charge_comment' => '备注',
			'charge_type' => '类型',
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
        $roles = Yii::app() -> user -> roles;
        $uid = Yii::app() -> user -> id;

        if($roles == 3) {
            $criteria -> addCondition('charge_man_id = '.$uid);
        } else if ($roles == 4) {
            $criteria -> addCondition('charge_to = '.$uid);
        }

        $criteria -> order = 'charge_id DESC';
		$criteria->compare('charge_id',$this->charge_id);
		$criteria->compare('charge_money',$this->charge_money);
		$criteria->compare('charge_date',$this->charge_date,true);
		$criteria->compare('charge_man_id',$this->charge_man_id);
		$criteria->compare('charge_to',$this->charge_to);
		$criteria->compare('charge_comment',$this->charge_comment,true);
		$criteria->compare('charge_type',$this->charge_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Charge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this -> charge_date = date('Y/m/d H:m:s');
            $this -> charge_man_id = Yii::app() -> user -> id;
            return true;
        } else {
            return false;
        }
    }

    public function getType($id) {
        $id == 1 ? $type = '充值' : $type = '回退';
        return $type;
    }

    public function getTypeList() {
        return array('1' => '充值', '2' => '回退');
    }

    public function getMoney($type, $money) {
        if ($type == 1) {
            ;
        } else if ($type == 2) {
            $money = -$money;
        } else {
            $money = 'ERROR!';
        }

        return $money;
    }
}
