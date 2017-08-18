<?php
class MerchantImg extends CActiveRecord {
	public function tableName() {
		return 'merchant_img';
	}
	public function rules() {
		return array(
			array('taken', 'required'),
			array('merchant, services', 'numerical', 'integerOnly'=>true),
			array('img_as', 'length', 'max'=>6),
			array('images, img_type', 'safe'),
			array('img_id, merchant, services, img_as, images, img_type, taken', 'safe', 'on'=>'search'),
		);
	}
	public function relations() {
		return array(
			'merchant0' => array(self::BELONGS_TO, 'Merchant', 'merchant'),
			'services0' => array(self::BELONGS_TO, 'MerchantServices', 'services'),
		);
	}
	public function attributeLabels() {
		return array(
			'img_id' => 'Img',
			'merchant' => 'Merchant',
			'services' => 'Services',
			'img_as' => 'Img As',
			'images' => 'Images',
			'img_type' => 'Img Type',
			'taken' => 'Taken',
		);
	}
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('img_id',$this->img_id);
		$criteria->compare('merchant',$this->merchant);
		$criteria->compare('services',$this->services);
		$criteria->compare('img_as',$this->img_as,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('img_type',$this->img_type,true);
		$criteria->compare('taken',$this->taken,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
