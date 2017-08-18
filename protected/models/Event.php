<?php
class Event extends CActiveRecord {
	public function tableName() {
		return 'event';
	}
	
	public function rules() {
		return array(
			array('Nama, timestamp, lokasi, mulai', 'required'),
			array('subdistrict', 'length', 'max'=>10),
			array('Nama, keterangan, lokasi, mulai, akhir', 'safe'),
			array('ev_id, Nama, keterangan, lokasi, subdistrict, mulai, akhir, timestamp', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'subdistrict0' => array(self::BELONGS_TO, 'Kelurahan', 'subdistrict'),
			'eventSesis' => array(self::HAS_MANY, 'EventSesi', 'ev_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'ev_id' => 'Ev',
			'Nama' => 'NAMA ACARA',
			'keterangan' => 'KETERANGAN',
			'lokasi' => 'LOKASI',
			'subdistrict' => 'KELURAHAN',
			'mulai' => 'WAKTU MULAI ACARA',
			'akhir' => 'WAKTU BERAKHIR ACARA',
			'timestamp' => 'Timestamp',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('ev_id',$this->ev_id);
		$criteria->compare('Nama',$this->Nama,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('lokasi',$this->lokasi,true);
		$criteria->compare('subdistrict',$this->subdistrict,true);
		$criteria->compare('mulai',$this->mulai,true);
		$criteria->compare('akhir',$this->akhir,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
