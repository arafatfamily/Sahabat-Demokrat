<?php
class SiteAlbum extends CActiveRecord {
	public function tableName() {
		return 'site_album';
	}
	
	public function rules() {
		return array(
			array('nama, keterangan, tgl_dibuat, thumbnail, thumb_type', 'safe'),
			array('album_id, nama, keterangan, tgl_dibuat, thumbnail, thumb_type', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'siteGaleries' => array(self::HAS_MANY, 'SiteGalery', 'album'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'album_id' => 'AlbumID',
			'nama' => 'Nama Album',
			'keterangan' => 'Keterangan',
			'tgl_dibuat' => 'Tgl Dibuat',
			'thumbnail' => 'Thumbnail Album',
			'thumb_type' => 'thumb_type'
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('album_id',$this->album_id);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('tgl_dibuat',$this->tgl_dibuat,true);
		$criteria->compare('thumbnail',$this->thumbnail,true);
		$criteria->compare('thumb_type',$this->thumb_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
