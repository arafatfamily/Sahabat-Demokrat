<?php
class Sekretariat extends CActiveRecord {
	public function tableName() {
		return 'sekretariat';
	}
	
	public function rules() {
		return array(
			array('name, sub_district', 'required'),
			array('sub_district', 'length', 'max'=>10),
			array('no_telp', 'length', 'max'=>12),
			array('latitude, longitude', 'length', 'max'=>15),
			array('address, email, website', 'safe'),
			array('num, name, address, sub_district, no_telp, email, website, latitude, longitude', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'subDistrict' => array(self::BELONGS_TO, 'Kelurahan', 'sub_district'),
			'sekretariatImages' => array(self::HAS_MANY, 'SekretariatImages', 'sekretariat'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'num' => 'NO.',
			'name' => 'NAMA',
			'address' => 'ALAMAT',
			'sub_district' => 'KELURAHAN',
			'no_telp' => 'NO TELP.',
			'email' => 'EMAIL',
			'website' => 'WEBSITE',
			'latitude' => 'LATITUDE',
			'longitude' => 'LONGITUDE',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('num',$this->num);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('sub_district',$this->sub_district,true);
		$criteria->compare('no_telp',$this->no_telp,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
