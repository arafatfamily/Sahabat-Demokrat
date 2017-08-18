<?php
class Changelog extends CActiveRecord { 
	public function tableName() {
		return 'changelog';
	} 
	public function rules() { 
		return array(
			array('date, warna_icon', 'required'),
			array('webmaster', 'numerical', 'integerOnly'=>true),
			array('nama, keterangan, icon_mark', 'safe'), 
			array('id_rec, date, nama, keterangan, webmaster, icon_mark, posisi, warna_icon', 'safe', 'on'=>'search'),
		);
	} 
	public function relations() { 
		return array(
		);
	} 
	public function attributeLabels() {
		return array(
			'id_rec' => 'Id Rec',
			'date' => 'TANGGAL',
			'nama' => 'JUDUL',
			'keterangan' => 'KETERANGAN',
			'webmaster' => 'WEBMASTER',
			'icon_mark' => 'ICONS',
			'posisi' => 'POSISI',
			'warna_icon' => 'WARNA ICONS',
		);
	} 
	public function search() { 
		$criteria=new CDbCriteria;

		$criteria->compare('id_rec',$this->id_rec,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('webmaster',$this->webmaster);
		$criteria->compare('icon_mark',$this->icon_mark,true);
		$criteria->compare('posisi',$this->posisi,true);
		$criteria->compare('warna_icon',$this->warna_icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
