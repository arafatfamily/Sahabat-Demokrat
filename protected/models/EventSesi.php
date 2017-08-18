<?php
class EventSesi extends CActiveRecord {
	public function tableName() {
		return 'event_sesi';
	}
	
	public function rules() {
		return array(
			array('ev_id', 'numerical', 'integerOnly'=>true),
			array('nama, lokasi, mulai, akhir', 'safe'),
			array('ses_id, ev_id, nama, lokasi, mulai, akhir', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'eventAkses' => array(self::HAS_MANY, 'EventAkses', 'sesi_id'),
			'eventMembers' => array(self::HAS_MANY, 'EventMember', 'sesi_id'),
			'ev' => array(self::BELONGS_TO, 'Event', 'ev_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'ses_id' => 'Ses',
			'ev_id' => 'Ev',
			'nama' => 'NAMA SESI',
			'lokasi' => 'GEDUNG/RUANG SESI',
			'mulai' => 'Mulai',
			'akhir' => 'Akhir',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('ses_id',$this->ses_id);
		$criteria->compare('ev_id',$this->ev_id);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('lokasi',$this->lokasi,true);
		$criteria->compare('mulai',$this->mulai,true);
		$criteria->compare('akhir',$this->akhir,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
