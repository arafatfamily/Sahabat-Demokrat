<?php
class SiteGalery extends CActiveRecord {
	public function tableName() {
		return 'site_galery';
	}
	
	public function rules() {
		return array(
			array('admin, album', 'required'),
			array('album', 'numerical', 'integerOnly'=>true),
			array('admin', 'length', 'max'=>10),
			array('images, img_type, keterangan, tgl_upload, status', 'safe'),
			array('galeri_id, admin, album, images, img_type, keterangan, tgl_upload, status', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'album0' => array(self::BELONGS_TO, 'SiteAlbum', 'album'),
			'admin0' => array(self::BELONGS_TO, 'Users', 'admin'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'galeri_id' => 'Galeri',
			'admin' => 'Admin',
			'album' => 'Album',
			'images' => 'Images',
			'img_type' => 'img_type',
			'keterangan' => 'Keterangan',
			'tgl_upload' => 'Tgl Upload',
			'status' => 'Status',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('galeri_id',$this->galeri_id);
		$criteria->compare('admin',$this->admin,true);
		$criteria->compare('album',$this->album);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('img_type',$this->img_type,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('tgl_upload',$this->tgl_upload,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
