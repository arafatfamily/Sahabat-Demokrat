<?php

/**
 * This is the model class for table "member_doc".
 *
 * The followings are the available columns in table 'member_doc':
 * @property integer $id_dok
 * @property integer $member_id
 * @property string $nama_dok
 * @property string $no_dok
 * @property integer $dok_oleh
 * @property string $oleh_non
 * @property string $tahun_dok
 * @property string $description
 * @property string $lampiran
 * @property integer $lamp_type
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class MemberDoc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_doc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, dok_oleh, lamp_type', 'numerical', 'integerOnly'=>true),
			array('tahun_dok', 'length', 'max'=>4),
			array('nama_dok, no_dok, oleh_non, description, lampiran', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dok, member_id, nama_dok, no_dok, dok_oleh, oleh_non, tahun_dok, description, lampiran, lamp_type', 'safe', 'on'=>'search'),
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
			'id_dok' => 'Id Dok',
			'member_id' => 'Member',
			'nama_dok' => 'Nama SK',
			'no_dok' => 'Nomor SK',
			'dok_oleh' => 'Dikeluarkan Oleh',
			'oleh_non' => 'Oleh Non',
			'tahun_dok' => 'Tahun Dok',
			'description' => 'Description',
			'lampiran' => 'File SK',
			'lamp_type' => 'Lamp Type',
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

		$criteria->compare('id_dok',$this->id_dok);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('nama_dok',$this->nama_dok,true);
		$criteria->compare('no_dok',$this->no_dok,true);
		$criteria->compare('dok_oleh',$this->dok_oleh);
		$criteria->compare('oleh_non',$this->oleh_non,true);
		$criteria->compare('tahun_dok',$this->tahun_dok,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('lampiran',$this->lampiran,true);
		$criteria->compare('lamp_type',$this->lamp_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberDoc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
