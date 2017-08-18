<?php

/**
 * This is the model class for table "site_config".
 *
 * The followings are the available columns in table 'site_config':
 * @property integer $config_id
 * @property string $params
 * @property string $options
 * @property string $konten
 * @property string $bg_color
 * @property string $date_change
 */
class SiteConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('params, date_change', 'required'),
			array('options', 'length', 'max'=>5),
			array('konten, bg_color', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('config_id, params, options, konten, bg_color, date_change', 'safe', 'on'=>'search'),
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
			'config_id' => 'Config',
			'params' => 'Params',
			'options' => 'Options',
			'konten' => 'Konten',
			'bg_color' => 'Bg Color',
			'date_change' => 'Date Change',
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

		$criteria->compare('config_id',$this->config_id);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('konten',$this->konten,true);
		$criteria->compare('bg_color',$this->bg_color,true);
		$criteria->compare('date_change',$this->date_change,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SiteConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
