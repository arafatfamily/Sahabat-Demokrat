<?php
class MerchantServices extends CActiveRecord {
	public function tableName() {
		return 'merchant_services';
	}
	public function rules() {
		return array(
			array('merchant_id, produk_name', 'required'),
			array('merchant_id, keterangan', 'numerical', 'integerOnly'=>true),
			array('tampil_slide, adm_approved', 'length', 'max'=>1),
			array('start_promo, end_promo', 'safe'),
			array('services_id, merchant_id, produk_name, keterangan, start_promo, end_promo, tampil_slide, adm_approved', 'safe', 'on'=>'search'),
		);
	}
	public function relations() {
		return array(
			'merchantImgs' => array(self::HAS_MANY, 'MerchantImg', 'services'),
			'merchant' => array(self::BELONGS_TO, 'Merchant', 'merchant_id'),
		);
	}
	public function attributeLabels() {
		return array(
			'services_id' => 'Services',
			'merchant_id' => 'Merchant',
			'produk_name' => 'Produk Name',
			'keterangan' => 'Keterangan',
			'start_promo' => 'Start Promo',
			'end_promo' => 'End Promo',
			'tampil_slide' => 'Tampil Slide',
			'adm_approved' => 'Adm Approved',
		);
	}
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('services_id',$this->services_id);
		$criteria->compare('merchant_id',$this->merchant_id);
		$criteria->compare('produk_name',$this->produk_name,true);
		$criteria->compare('keterangan',$this->keterangan);
		$criteria->compare('start_promo',$this->start_promo,true);
		$criteria->compare('end_promo',$this->end_promo,true);
		$criteria->compare('tampil_slide',$this->tampil_slide,true);
		$criteria->compare('adm_approved',$this->adm_approved,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
