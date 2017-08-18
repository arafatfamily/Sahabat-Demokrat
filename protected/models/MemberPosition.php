<?php
class MemberPosition extends CActiveRecord {
	public function tableName() {
		return 'member_position';
	}
	
	public function rules() {
		return array(
			array('member_id, position, position_as, level', 'numerical', 'integerOnly'=>true),
			array('id, member_id, position, position_as, level', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'member_id' => 'Member ID',
			'position' => 'Posisi Pengurus',
			'position_as' => 'Jabatan',
			'level' => 'Tingkat Pengurus',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('position_as',$this->position_as);
		$criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
