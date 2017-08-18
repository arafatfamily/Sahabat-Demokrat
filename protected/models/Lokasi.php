<?php 
class Lokasi extends CActiveRecord {
	public function tableName() {
		return 'lokasi';
	}
	
	public function rules() {
		return array(
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('mobile_lat, mobile_lon, address_lat, address_lon', 'length', 'max'=>15),
			array('member_id, mobile_lat, mobile_lon, address_lat, address_lon', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'member_id' => 'Member',
			'mobile_lat' => 'Mobile Lat',
			'mobile_lon' => 'Mobile Lon',
			'address_lat' => 'Address Lat',
			'address_lon' => 'Address Lon',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('mobile_lat',$this->mobile_lat,true);
		$criteria->compare('mobile_lon',$this->mobile_lon,true);
		$criteria->compare('address_lat',$this->address_lat,true);
		$criteria->compare('address_lon',$this->address_lon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
