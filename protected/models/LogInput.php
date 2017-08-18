<?php

/**
 * This is the model class for table "log_input".
 *
 * The followings are the available columns in table 'log_input':
 * @property integer $log_id
 * @property integer $member_id
 * @property string $date_time
 * @property string $users_id
 * @property string $act_info
 * @property string $act_type
 * @property string $ip_address
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Users $users
 */
class LogInput extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_input';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, users_id, act_type, ip_address', 'required'),
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('users_id', 'length', 'max'=>10),
			array('act_type', 'length', 'max'=>6),
			array('date_time, act_info', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('log_id, member_id, date_time, users_id, act_info, act_type, ip_address', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'log_id' => 'Log',
			'member_id' => 'Member',
			'date_time' => 'Date Time',
			'users_id' => 'Users',
			'act_info' => 'Act Info',
			'act_type' => 'Act Type',
			'ip_address' => 'Ip Address',
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

		$criteria->compare('log_id',$this->log_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('date_time',$this->date_time,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('act_info',$this->act_info,true);
		$criteria->compare('act_type',$this->act_type,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogInput the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
