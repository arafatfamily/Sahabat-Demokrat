<?php
class SiteNews extends CActiveRecord {
	public function tableName() {
		return 'site_news';
	}
	
	public function rules() {
		return array(
			array('admin, kategori, judul', 'required'),
			array('admin', 'length', 'max'=>10),
			array('sticky', 'length', 'max'=>1),
			array('isi_berita, news_img, tgl_post', 'safe'),
			array('news_id, status, admin, kategori, judul, isi_berita, news_img, sticky, tgl_post', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'admin0' => array(self::BELONGS_TO, 'Users', 'admin'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'news_id' => 'Berita',
			'admin' => 'Admin',
			'kategori' => 'Kategori',
			'judul' => 'Judul',
			'isi_berita' => 'Isi Berita',
			'news_img' => 'Fitur Foto',
			'sticky' => 'Fitur Berita',
			'status' => 'Status Berita',
			'tgl_post' => 'Tanggal Post',
		);
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('admin',$this->admin,true);
		$criteria->compare('kategori',$this->kategori,true);
		$criteria->compare('judul',$this->judul,true);
		$criteria->compare('isi_berita',$this->isi_berita,true);
		$criteria->compare('news_img',$this->news_img,true);
		$criteria->compare('sticky',$this->sticky,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('tgl_post',$this->tgl_post,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function apiLoad() {
		$criteria = new CDbCriteria;
		$criteria->select = "t.news_id";
		$criteria->condition = "t.status='P'";
		
		$dataProvider = new CActiveDataProvider('SiteNews', array('criteria' => $criteria,
            'pagination' => array('pageSize' => 5),
            'sort' => array(
                'defaultOrder' => 'tgl_post DESC',
        )));
		
		return $dataProvider;
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
