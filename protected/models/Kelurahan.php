<?php

/**
 * This is the model class for table "kelurahan".
 *
 * The followings are the available columns in table 'kelurahan':
 * @property string $id_kel
 * @property string $id_kec
 * @property string $nama
 * @property integer $id_jenis
 * @property string $latitude
 * @property string $longitude
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property Member[] $members1
 */
class Kelurahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelurahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_kel, id_jenis', 'required'),
			array('id_jenis', 'numerical', 'integerOnly'=>true),
			array('id_kel', 'length', 'max'=>10),
			array('id_kec', 'length', 'max'=>6),
			array('nama', 'length', 'max'=>40),
			array('latitude, longitude', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_kel, id_kec, nama, id_jenis, latitude, longitude', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Member', 'sub_district_id'),
			'members1' => array(self::HAS_MANY, 'Member', 'member_sub_district_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_kel' => 'Id Kel',
			'id_kec' => 'Id Kec',
			'nama' => 'Nama',
			'id_jenis' => 'Id Jenis',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
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

		$criteria->compare('id_kel',$this->id_kel,true);
		$criteria->compare('id_kec',$this->id_kec,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('id_jenis',$this->id_jenis);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kelurahan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
