<?php

/**
 * This is the model class for table "phonebook".
 *
 * The followings are the available columns in table 'phonebook':
 * @property string $ph_id
 * @property integer $member_id
 * @property string $Name
 * @property string $ph_number
 * @property string $ph_grup
 * @property string $other_number
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class Phonebook extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'phonebook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ph_id, ph_number', 'required'),
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('ph_id', 'length', 'max'=>10),
			array('ph_number', 'length', 'max'=>12),
			array('Name, ph_grup, other_number', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ph_id, member_id, Name, ph_number, ph_grup, other_number', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ph_id' => 'Ph',
			'member_id' => 'Member',
			'Name' => 'Name',
			'ph_number' => 'Ph Number',
			'ph_grup' => 'Ph Grup',
			'other_number' => 'Other Number',
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

		$criteria->compare('ph_id',$this->ph_id,true);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('ph_number',$this->ph_number,true);
		$criteria->compare('ph_grup',$this->ph_grup,true);
		$criteria->compare('other_number',$this->other_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Phonebook the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
