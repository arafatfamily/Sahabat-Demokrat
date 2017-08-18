<?php

/**
 * This is the model class for table "kabupaten".
 *
 * The followings are the available columns in table 'kabupaten':
 * @property string $id_kab
 * @property string $id_prov
 * @property string $nama
 * @property integer $id_jenis
 *
 * The followings are the available model relations:
 * @property Provinsi $idProv
 * @property Users[] $users
 */
class Kabupaten extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kabupaten';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_kab, id_prov, id_jenis', 'required'),
			array('id_jenis', 'numerical', 'integerOnly'=>true),
			array('id_kab', 'length', 'max'=>4),
			array('id_prov', 'length', 'max'=>2),
			array('nama', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_kab, id_prov, nama, id_jenis', 'safe', 'on'=>'search'),
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
			'idProv' => array(self::BELONGS_TO, 'Provinsi', 'id_prov'),
			'users' => array(self::HAS_MANY, 'Users', 'id_kab'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_kab' => 'Id Kab',
			'id_prov' => 'Id Prov',
			'nama' => 'Nama',
			'id_jenis' => 'Id Jenis',
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

		$criteria->compare('id_kab',$this->id_kab,true);
		$criteria->compare('id_prov',$this->id_prov,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('id_jenis',$this->id_jenis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kabupaten the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
