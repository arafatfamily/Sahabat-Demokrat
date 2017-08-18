<?php
class EventMember extends CActiveRecord {
	public function tableName() {
		return 'event_member';
	}
	
	public function rules() {
		return array(
			array('member_id, sesi_id', 'numerical', 'integerOnly'=>true),
			array('member_id, sesi_id', 'safe', 'on'=>'search'),
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
			'member_id' => 'Member',
			'sesi_id' => 'Sesi',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('sesi_id',$this->sesi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
