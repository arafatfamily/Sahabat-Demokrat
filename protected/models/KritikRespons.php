<?php

/**
 * This is the model class for table "kritik_respons".
 *
 * The followings are the available columns in table 'kritik_respons':
 * @property integer $resp_id
 * @property integer $kritik_id
 * @property string $admin_id
 * @property string $konten
 * @property string $reply_date
 *
 * The followings are the available model relations:
 * @property KritikSaran $kritik
 * @property Users $admin
 */
class KritikRespons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kritik_respons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admin_id', 'required'),
			array('kritik_id', 'numerical', 'integerOnly'=>true),
			array('admin_id', 'length', 'max'=>10),
			array('konten, reply_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resp_id, kritik_id, admin_id, konten, reply_date', 'safe', 'on'=>'search'),
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
			'kritik' => array(self::BELONGS_TO, 'KritikSaran', 'kritik_id'),
			'admin' => array(self::BELONGS_TO, 'Users', 'admin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resp_id' => 'Resp',
			'kritik_id' => 'Kritik',
			'admin_id' => 'Admin',
			'konten' => 'Konten',
			'reply_date' => 'Reply Date',
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

		$criteria->compare('resp_id',$this->resp_id);
		$criteria->compare('kritik_id',$this->kritik_id);
		$criteria->compare('admin_id',$this->admin_id,true);
		$criteria->compare('konten',$this->konten,true);
		$criteria->compare('reply_date',$this->reply_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KritikRespons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
