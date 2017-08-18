<?php
class EventAkses extends CActiveRecord {
	public function tableName() {
		return 'event_akses';
	}
	
	public function rules() {
		return array(
			array('sesi_id, member_id', 'numerical', 'integerOnly'=>true),
			array('akses_code, status', 'length', 'max'=>1),
			array('auth_use', 'length', 'max'=>10),
			array('timestamp', 'safe'),
			array('aks_id, sesi_id, member_id, timestamp, akses_code, status, auth_use', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'sesi' => array(self::BELONGS_TO, 'EventSesi', 'sesi_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'aks_id' => 'Aks',
			'sesi_id' => 'Sesi',
			'member_id' => 'Member',
			'timestamp' => 'Timestamp',
			'akses_code' => 'Akses Code',
			'status' => 'Status',
			'auth_use' => 'Auth Use',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('aks_id',$this->aks_id);
		$criteria->compare('sesi_id',$this->sesi_id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('akses_code',$this->akses_code,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('auth_use',$this->auth_use,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
