<?php

/**
 * This is the model class for table "users_akses".
 *
 * The followings are the available columns in table 'users_akses':
 * @property integer $akses_id
 * @property string $akses_name
 *
 * The followings are the available model relations:
 * @property UsersMenu[] $usersMenus
 */
class UsersAkses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_akses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('akses_name', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('akses_id, akses_name', 'safe', 'on'=>'search'),
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
			'usersMenus' => array(self::HAS_MANY, 'UsersMenu', 'akses'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'akses_id' => 'Akses',
			'akses_name' => 'Akses Name',
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

		$criteria->compare('akses_id',$this->akses_id);
		$criteria->compare('akses_name',$this->akses_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersAkses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
