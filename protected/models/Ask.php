<?php

/**
 * This is the model class for table "ask".
 *
 * The followings are the available columns in table 'ask':
 * @property integer $ask_id
 * @property string $ask_title
 * @property string $ask_content
 * @property string $ask_date
 * @property string $ask_uid
 * @property string $ask_response
 */
class Ask extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ask';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ask_title, ask_content', 'required'),
			array('ask_title', 'length', 'max'=>64),
			array('ask_response', 'length', 'max'=>64000),
			array('ask_uid, ask_date, ask_id, ask_status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ask_id, ask_title, ask_content, ask_uid, ask_date, ask_response, ask_status', 'safe', 'on'=>'search'),
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
			'ask_title' => '提问标题',
			'ask_content' => '提问内容',
			'ask_date' => '提问时间',
			'ask_uid' => '提问者',
			'ask_response' => '回复',
            'ask_status' => '回复状态',
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

       // $criteria -> order = 'ask_date DESC';

		$criteria->compare('ask_id',$this->ask_id);
		$criteria->compare('ask_title',$this->ask_title,true);
		$criteria->compare('ask_content',$this->ask_content,true);
		$criteria->compare('ask_date',$this->ask_date,true);
		$criteria->compare('ask_uid',$this->ask_uid,true);
		$criteria->compare('ask_status',$this->ask_status,true);
		$criteria->compare('ask_response',$this->ask_response,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (Yii::app() -> controller -> action -> id == 'reply') {
                $this -> ask_status = '1'; 
            } else {
                $this -> ask_date = date('Y/m/d');
                $this -> ask_uid = Yii::app() -> user -> id;
                $this -> ask_status = '0';
            }
            return true;
        } else {
            return false;
        }
    }


    public function getStatus() {
        $status = $this -> findAllBySql('SELECT * FROM ask GROUP BY ask_status');
        foreach ($status as $key => $val) {
            $val['ask_status'] == 0 ? $val['ask_title'] = '未回复' : $val['ask_title'] = '已回复';
        }
        return CHtml::listData($status, 'ask_status','ask_title');
    }

    public function getStatusName($status, $id) {
        $status == 1 ? $status = '已回复' : $status = CHtml::link('现在回复', 'reply/'.$id);
        return $status;
    }

    /**
     *  在_view中确定显示回复链接还是回复内荣
     */
    public function getResponse($data, $askid) {
        if (Yii::app() -> user -> roles == 1) {
            if ($data == '') {
                return CHtml::link('现在回复', Yii::app() -> baseUrl.'/index.php/ask/reply/'.$askid); 
            } else {
                return CHtml::encode($data);
            } 
        } else {
            return CHtml::encode($data);
        }
    }
}
