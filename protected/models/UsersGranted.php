<?php

class UsersGranted extends CActiveRecord {
	public function tableName() {
		return 'users_granted';
	}
	
	public function rules() {
		return array(
			array('users_id, menu_id, by_users, akses_id, date_add', 'required'),
			array('menu_id, akses_id', 'numerical', 'integerOnly'=>true),
			array('users_id, by_users', 'length', 'max'=>10),
			array('grand_id, users_id, menu_id, by_users, akses_id, date_add', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'akses' => array(self::BELONGS_TO, 'UsersAkses', 'akses_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'grand_id' => 'Grand',
			'users_id' => 'Users',
			'menu_id' => 'Menu',
			'by_users' => 'By Users',
			'akses_id' => 'Akses',
			'date_add' => 'Date Add',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('grand_id',$this->grand_id);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('by_users',$this->by_users,true);
		$criteria->compare('akses_id',$this->akses_id);
		$criteria->compare('date_add',$this->date_add,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
