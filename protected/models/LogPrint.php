<?php

/**
 * This is the model class for table "log_print".
 *
 * The followings are the available columns in table 'log_print':
 * @property integer $log_id
 * @property integer $member_id
 * @property string $date_print
 * @property string $users_id
 * @property string $print_type
 * @property string $status
 * @property string $ip_address
 *
 * The followings are the available model relations:
 * @property Users $users
 */
class LogPrint extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_print';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, users_id, print_type, ip_address', 'required'),
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('users_id, print_type', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7),
			array('date_print', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('log_id, member_id, date_print, users_id, print_type, status, ip_address', 'safe', 'on'=>'search'),
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
			'date_print' => 'Date Print',
			'users_id' => 'Users',
			'print_type' => 'Print Type',
			'status' => 'Status',
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
		$criteria->compare('date_print',$this->date_print,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('print_type',$this->print_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogPrint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
