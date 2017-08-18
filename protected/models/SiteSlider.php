<?php

/**
 * This is the model class for table "site_slider".
 *
 * The followings are the available columns in table 'site_slider':
 * @property integer $id_slide
 * @property string $nama
 * @property string $heading
 * @property string $paragraph
 * @property string $images
 * @property string $img_type
 * @property string $status
 * @property integer $nomor
 * @property string $date_add
 */
class SiteSlider extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_slider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor', 'numerical', 'integerOnly'=>true),
			array('img_type', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('nama, heading, paragraph, images, date_add', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_slide, nama, heading, paragraph, images, img_type, status, nomor, date_add', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_slide' => 'Id Slide',
			'nama' => 'Nama',
			'heading' => 'Heading',
			'paragraph' => 'Paragraph',
			'images' => 'Images',
			'img_type' => 'Img Type',
			'status' => 'Status',
			'nomor' => 'Nomor',
			'date_add' => 'Date Add',
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

		$criteria->compare('id_slide',$this->id_slide);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('heading',$this->heading,true);
		$criteria->compare('paragraph',$this->paragraph,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('img_type',$this->img_type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('nomor',$this->nomor);
		$criteria->compare('date_add',$this->date_add,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteSlider the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
