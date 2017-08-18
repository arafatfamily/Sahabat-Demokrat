<?php

/**
 * This is the model class for table "member_track".
 *
 * The followings are the available columns in table 'member_track':
 * @property integer $rekam_id
 * @property integer $member_id
 * @property string $judul
 * @property string $konten
 * @property string $lampiran
 * @property string $lamp_type
 *
 * The followings are the available model relations:
 * @property Member $member
 */
class MemberTrack extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('judul, konten, lampiran, lamp_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rekam_id, member_id, judul, konten, lampiran, lamp_type', 'safe', 'on'=>'search'),
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
			'rekam_id' => 'Rekam',
			'member_id' => 'Member',
			'judul' => 'Judul',
			'konten' => 'Konten',
			'lampiran' => 'Lampiran',
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

		$criteria->compare('rekam_id',$this->rekam_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('judul',$this->judul,true);
		$criteria->compare('konten',$this->konten,true);
		$criteria->compare('lampiran',$this->lampiran,true);
		$criteria->compare('lamp_type',$this->lamp_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberTrack the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
