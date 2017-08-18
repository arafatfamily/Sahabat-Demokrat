<?php
class UsersImg extends CActiveRecord {
	public function tableName() {
		return 'users_img';
	}
	
	public function rules() {
		return array(
			array('users_id', 'required'),
			array('users_id, photo_type, tdpn_type, tblk_type', 'length', 'max'=>10),
			array('img_photo, template_dpn, template_blk', 'safe'),
			array('users_id, img_photo, photo_type, template_dpn, tdpn_type, template_blk, tblk_type', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'users_id' => 'Users',
			'img_photo' => 'Img Photo',
			'photo_type' => 'Photo Type',
			'template_dpn' => 'Template Dpn',
			'tdpn_type' => 'Tdpn Type',
			'template_blk' => 'Template Blk',
			'tblk_type' => 'Tblk Type',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('img_photo',$this->img_photo,true);
		$criteria->compare('photo_type',$this->photo_type,true);
		$criteria->compare('template_dpn',$this->template_dpn,true);
		$criteria->compare('tdpn_type',$this->tdpn_type,true);
		$criteria->compare('template_blk',$this->template_blk,true);
		$criteria->compare('tblk_type',$this->tblk_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
