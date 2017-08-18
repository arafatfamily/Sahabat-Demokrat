<?php
class Merchant extends CActiveRecord {
	public function tableName() {
		return 'merchant';
	}
	public function rules() {
		return array(
			array('member_id, nama, subdistrict', 'required'),
			array('idm, member_id', 'numerical', 'integerOnly'=>true),
			array('subdistrict', 'length', 'max'=>10),
			array('latitude, longitude', 'length', 'max'=>15),
			array('keterangan, alamat, date_join', 'safe'),
			array('idm, member_id, nama, keterangan, alamat, subdistrict, latitude, longitude, date_join', 'safe', 'on'=>'search'),
		);
	}
	public function relations() {
		return array(
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'merchantImgs' => array(self::HAS_MANY, 'MerchantImg', 'merchant'),
			'merchantServices' => array(self::HAS_MANY, 'MerchantServices', 'merchant_id'),
		);
	}
	public function attributeLabels() {
		return array(
			'idm' => 'Idm',
			'member_id' => 'PEMILIK',
			'nama' => 'NAMA MERCHANT',
			'keterangan' => 'KETERANGAN',
			'alamat' => 'ALAMAT',
			'subdistrict' => 'KELURAHAN',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'date_join' => 'BERGABUNG',
		);
	}
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('idm',$this->idm);
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('subdistrict',$this->subdistrict,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('date_join',$this->date_join,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function loadMerchant($filter, $pagination) {
		$criteria=new CDbCriteria;
		
		$criteria->join = "LEFT JOIN kelurahan kl ON kl.id_kel=t.subdistrict ";
		$criteria->join .= "LEFT JOIN kecamatan kc ON kc.id_kec=kl.id_kec ";
		$criteria->join .= "LEFT JOIN kabupaten kb ON kb.id_kab=kc.id_kab ";
		$criteria->join .= "LEFT JOIN provinsi pv ON pv.id_prov=kb.id_prov ";
		$criteria->condition = "t.member_id IS NOT NULL {$filter}";
		
		$dataProvider = new CActiveDataProvider('Merchant', array(
			'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 'date_join DESC',
        )));

        return $dataProvider;
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
