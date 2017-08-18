<?php
class KritikSaran extends CActiveRecord {
	public function tableName() {
		return 'kritik_saran';
	}
	public function rules() {
		return array(
			array('member_id, update_time, judul, konten', 'required'),
			array('member_id', 'numerical', 'integerOnly'=>true),
			array('administrator, tipe_pesan, tipe_app, status', 'length', 'max'=>1),
			array('judul, konten', 'safe'),
			array('id, member_id, administrator, tipe_pesan, tipe_app, judul, konten, status, update_time', 'safe', 'on'=>'search'),
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
			'member_id' => 'Kader ID',
			'administrator' => 'ADMINISTRATOR',
			'tipe_pesan' => 'TIPE PENGADUAN',
			'tipe_app' => 'JENIS APLIKASI',
			'judul' => 'NAMA MENU/MODUL',
			'konten' => 'ISI KRITIK ATAU SARAN',
			'status' => 'STATUS',
			'update_time' => 'Update Time',
		);
	}
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('administrator',$this->administrator,true);
		$criteria->compare('tipe_pesan',$this->tipe_pesan,true);
		$criteria->compare('tipe_app',$this->tipe_app,true);
		$criteria->compare('judul',$this->judul,true);
		$criteria->compare('konten',$this->konten,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
