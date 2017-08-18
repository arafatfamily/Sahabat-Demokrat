<?php

/**
 * This is the model class for table "users_chat".
 *
 * The followings are the available columns in table 'users_chat':
 * @property string $stat_id
 * @property string $time
 * @property string $users_id
 * @property string $message
 * @property string $to_users
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Users $toUsers
 * @property Users $users
 */
class UsersChat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, to_users', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('time, message', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('stat_id, time, users_id, message, to_users, status', 'safe', 'on'=>'search'),
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
			'toUsers' => array(self::BELONGS_TO, 'Users', 'to_users'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stat_id' => 'Stat',
			'time' => 'Time',
			'users_id' => 'Users',
			'message' => 'Message',
			'to_users' => 'To Users',
			'status' => 'Status',
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

		$criteria->compare('stat_id',$this->stat_id,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('to_users',$this->to_users,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersChat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
