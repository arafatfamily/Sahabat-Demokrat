<?php
class Member extends CActiveRecord {
	public function tableName() {
		return 'member';
	}
	
	public function rules() {
		return array(
			array('last_education_id, rt, rw, member_rt, member_rw, member_type_id', 'numerical', 'integerOnly'=>true),
			array('membership_id, religion, sub_district_id, home_number, member_sub_district_id, member_home_number, home_phone_number, CARD_UID, reference', 'length', 'max'=>10),
			array('gender, is_married, member_status, is_domisili, is_have_position, is_other_position', 'length', 'max'=>1),
			array('blood_type', 'length', 'max'=>2),
			array('postal_code, member_postal_code', 'length', 'max'=>5),
			array('cellular_phone_number, member_active_number', 'length', 'min'=>10,'max'=>15, 'message' => '{attribute} Tidak dikenal !'),
			array('identity_number', 'length', 'min'=>16, 'max'=>16),
			array('mobile_auth', 'length', 'max'=>50),
			array('member_name, birth_place, date_of_birth, occupation, address, member_address, couple_name, children_name, email, facebook, twitter, registered_time, last_print', 'safe'),
            array('identity_number', 'duplicatektp'),
            array('cellular_phone_number', 'duplicatehp'),
            array('cellular_phone_number', 'CRegularExpressionValidator', 'pattern' => '/^[0-9]+$/', 'message' => 'Harus diisi dengan Angka!'),
            array('cellular_phone_number', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Harus diisi dengan Angka!'),
			array('member_name, gender, birth_place, is_married, blood_type, occupation, religion, last_education_id, sub_district_id, cellular_phone_number, identity_number, date_of_birth', 'required', 'message' => 'Anda harus melengkapi data {attribute}.'),
			array('id, membership_id, member_name, gender, birth_place, date_of_birth, is_married, blood_type, occupation, religion, last_education_id, sub_district_id, address, home_number, rt, rw, postal_code, member_sub_district_id, member_address, member_home_number, member_rt, member_rw, member_postal_code, couple_name, children_name, home_phone_number, cellular_phone_number, email, facebook, twitter, member_type_id, member_status, member_active_number, registered_time, identity_number, CARD_UID, last_print, last_update, is_domisili, is_have_position, is_other_position, reference, mobile_auth', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'logPrints' => array(self::HAS_MANY, 'LogPrint', 'member_id'),
			'lokasis' => array(self::HAS_MANY, 'Lokasi', 'member_id'),
			'subDistrict' => array(self::BELONGS_TO, 'Kelurahan', 'sub_district_id'),
			'memberSubDistrict' => array(self::BELONGS_TO, 'Kelurahan', 'member_sub_district_id'),
			'lastEducation' => array(self::BELONGS_TO, 'LastEducation', 'last_education_id'),
			'memberCards' => array(self::HAS_MANY, 'MemberCard', 'member_id'),
			'memberDocs' => array(self::HAS_MANY, 'MemberDoc', 'member_id'),
			'memberIdentities' => array(self::HAS_MANY, 'MemberIdentity', 'member_id'),
			'memberPhotos' => array(self::HAS_MANY, 'MemberPhoto', 'member_id'),
			'memberTracks' => array(self::HAS_MANY, 'MemberTrack', 'member_id'),
			'phonebooks' => array(self::HAS_MANY, 'Phonebook', 'member_id'),
			'strukturs' => array(self::HAS_MANY, 'Struktur', 'member_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'membership_id' => 'NO. KTA',
			'member_name' => 'NAMA LENGKAP',
			'gender' => 'JENIS KELAMIN',
			'birth_place' => 'TEMPAT LAHIR',
			'date_of_birth' => 'TANGGAL LAHIR',
			'is_married' => 'STATUS PERNIKAHAN',
			'blood_type' => 'GOLONGAN DARAH',
			'occupation' => 'PEKERJAAN',
			'religion' => 'AGAMA',
			'last_education_id' => 'PENDIDIKAN TERAKHIR',
			'sub_district_id' => 'KELURAHAN (sesuai Kartu Identitas)',
			'address' => 'ALAMAT (sesuai Kartu Identitas)',
			'home_number' => 'NO. RUMAH',
			'rt' => 'RT. (sesuai Kartu Identitas)',
			'rw' => 'RW. (sesuai Kartu Identitas)',
			'postal_code' => 'KODE POS (sesuai Kartu Identitas)',
			'member_sub_district_id' => 'KELURAHAN (sesuai Domisili)',
			'member_address' => 'ALAMAT TINGGAL (sesuai Domisili)',
			'member_home_number' => 'NO. RUMAH',
			'member_rt' => 'RT. (sesuai Domisili)',
			'member_rw' => 'RW. (sesuai Domisili)',
			'member_postal_code' => 'KODE POS',
			'couple_name' => 'NAMA PASANGAN',
			'children_name' => 'NAMA ANAK',
			'home_phone_number' => 'NO. TELP.',
			'cellular_phone_number' => 'NO. SELULER',
			'email' => 'E-MAIL',
			'facebook' => 'FACEBOOK PROFIL',
			'twitter' => 'TWITTER PROFIL',
			'member_type_id' => 'MEMBER TYPE',
			'member_status' => 'STATUS KADER',
			'member_active_number' => 'NO. HP. APLIKASI',
			'registered_time' => 'TANGGAL DAFTAR',
			'identity_number' => 'NO. KTP / NO. SIM / NO. PASPOR',
			'CARD_UID' => 'UID KTA',
			'last_print' => 'TANGGAL CETAK',
			'last_update' => 'TERAKHIR DIUBAH',
			'is_domisili' => 'DOMISILI SESUAI ?',
			'is_have_position' => 'POSISI',
			'is_other_position' => 'POSISI LAIN',
			'reference' => 'NO. REFERENSI',
			'mobile_auth' => 'AUTH APP',
		);
	}

    public function duplicatektp($attributes, $params) {
        if (isset($_POST['Member']['identity_number'])) {
            if ($_POST['Member']['identity_number'] != "" && Yii::app()->user->getUser("role_id") != 1) {
                if ($this->isNewRecord) {
					$noKTP = $_POST['Member']['identity_number'];
					$district = substr($noKTP, 0, 4);
					$cDistrict = Yii::app()->db->createCommand("SELECT id_kab AS district FROM kabupaten WHERE id_kab='$district'")->queryRow();
					$cDouble = Yii::app()->db->createCommand("SELECT COUNT(*) AS count, UPPER(member_name) AS nama FROM member WHERE identity_number='$noKTP'")->queryRow();
					if ($cDistrict['district'] == NULL) {
						$this->addError("identity_number", "Nomor KTP Tidak Dikenal Harap Periksa Kembali !!!");
					} else if ($cDouble['count'] == 1) {
						$this->addError("identity_number", "No KTP Ini sudah pernah terdaftar a/n $cDouble[nama] !!!");
					}
                }
            }
        }
    }

    public function duplicatehp($attributes, $params) {
        if (isset($_POST['Member']['cellular_phone_number'])) {
            if ($_POST['Member']['cellular_phone_number'] != "") {
                if ($this->isNewRecord) {
                    $nomorHP = $_POST['Member']['cellular_phone_number'];
					$noTelkomsel = array('0852', '0853', '0811', '0812', '0813', '0821', '0822', '0823', '0851');
					$noIndosat = array('0856', '0857', '0815', '0816', '0858');
					$noXL = array('0817', '0818', '0819', '0859', '0877', '0878');
					$noThree = array('0896', '0897', '0898', '0899');
					$noAxis = array('0831', '0838');
					$prefix = array_merge($noTelkomsel, $noIndosat, $noXL, $noThree, $noAxis);
					if (in_array(substr($nomorHP, 0, 4), $prefix)) {
						$cDouble = Yii::app()->db->createCommand("select count(*) as count, UPPER(member_name) as nama from member where cellular_phone_number='$nomorHP'")->queryRow();
						if ($cDouble['count'] >= 1) {
							$this->addError("cellular_phone_number", "Terdaftar a/n  $cDouble[nama] !");
						}						
					} else {
						$this->addError("cellular_phone_number", "No. Seluler Tidak Valid !");
					}
                }
            }
        }
    }
	
    public static function getKabProvKec($kelid, $param) {
		$sql = "SELECT DISTINCT B.id_kec,B.id_kab,C.id_prov,A.nama as kelurahannama,B.nama as kecamatannama,C.nama as kabupatennama,D.nama as provnama FROM kelurahan A "
			 . "INNER JOIN kecamatan B ON A.id_kec=B.id_kec "
			 . "INNER JOIN kabupaten C ON B.id_kab=C.id_kab "
			 . "INNER JOIN provinsi D ON C.id_prov=D.id_prov "
			 . "WHERE A.id_kel='$kelid'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_kec = "";
        $id_kab = "";
        $id_prov = "";

        $nama_kel = "";
        $nama_kec = "";
        $nama_kab = "";
        $nama_prov = "";
        foreach ($rows as $result) {
            $id_kec = $result['id_kec'];
            $id_kab = $result['id_kab'];
            $id_prov = $result['id_prov'];

            $nama_kel = strtoupper($result['kelurahannama']);
            $nama_kec = strtoupper($result['kecamatannama']);
            $nama_kab = strtoupper($result['kabupatennama']);
            $nama_prov = strtoupper($result['provnama']);
        }

        if ($param == "id_prov") {
            return $id_prov;
        } else if ($param == "id_kab") {
            return $id_kab;
        } else if ($param == "id_kec") {
            return $id_kec;
        } else if ($param == "nama_kel") {
            return $nama_kel;
        } else if ($param == "nama_kec") {
            return $nama_kec;
        } else if ($param == "nama_kab") {
            return $nama_kab;
        } else if ($param == "nama_prov") {
            return $nama_prov;
        } else {
            return "";
        }
    }
	
	public static function getKabProvKecID($kelid) {
        $sql = "SELECT DISTINCT B.id_kec,B.id_kab,C.id_prov,A.nama as kelurahannama,B.nama as kecamatannama,C.nama as kabupatennama,D.nama as provnama FROM kelurahan A "
			 . "INNER JOIN kecamatan B ON A.id_kec=B.id_kec "
			 . "INNER JOIN kabupaten C ON B.id_kab=C.id_kab "
			 . "INNER JOIN provinsi D ON C.id_prov=D.id_prov "
			 . "WHERE A.id_kel='$kelid' ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_kec = "";
        $id_kab = "";
        $id_prov = "";

        $nama_kel = "";
        $nama_kec = "";
        $nama_kab = "";
        $nama_prov = "";
        foreach ($rows as $result) {
            $id_kec = $result['id_kec'];
            $id_kab = $result['id_kab'];
            $id_prov = $result['id_prov'];

            $nama_kel = strtoupper($result['kelurahannama']);
            $nama_kec = strtoupper($result['kecamatannama']);
            $nama_kab = strtoupper($result['kabupatennama']);
            $nama_prov = strtoupper($result['provnama']);
        }
        return array(
            'id_kec' => $id_kec, 'id_kab' => $id_kab, 'id_prov' => $id_prov,
            'nama_kec' => $nama_kec, 'nama_kab' => $nama_kab, 'nama_prov' => $nama_prov, 'nama_kel' => $nama_kel
        );
    }
	
	public static function getLvlPosisiJabatan($id, $param) {
		$sql = "SELECT DISTINCT mb.id,mb.member_name AS name,mp.id AS mpos_id,mp.status_position AS sts_pos,pl.level AS id_lvl,pl.desc AS LEVEL,ps.id_posisi,ps.name AS posisi,pa.jab_id AS id_jabatan,pa.jabatan FROM member mb "
			 . "INNER JOIN member_position mp ON mp.member_id=mb.id "
			 . "INNER JOIN pos_lokasi pl ON pl.level=mp.level "
			 . "INNER JOIN pos_level ps ON ps.id_posisi=mp.position "
			 . "INNER JOIN pos_as pa ON pa.jab_id=mp.position_as "
			 . "WHERE mb.id='".$id."' AND mp.status_position='UTAMA'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_pos = "";
        $id_jab = "";
        $id_lvl = "";
		$id_mbr = "";

        $nama_pos = "";
        $nama_jab = "";
        $nama_lvl = "";
        $nama_mbr = "";
        foreach ($rows as $result) {
            $id_pos = $result['id_posisi'];
            $id_jab = $result['id_jabatan'];
            $id_lvl = $result['id_lvl'];
			$id_mbr = $result['id'];

            $nama_pos = strtoupper($result['posisi']);
            $nama_jab = strtoupper($result['jabatan']);
            $nama_lvl = strtoupper($result['level']);
            $nama_mbr = strtoupper($result['name']);
        }
		if ($param == "id_pos") {
			return $id_pos;
		} else if ($param == "id_jab") {
			return $id_jab;
		} else if ($param == "id_lvl") {
			return $id_lvl;
		} else if ($param == "id_mbr") {
			return $id_mbr;
		} else if ($param == "nama_pos") {
			return $nama_pos;
		} else if ($param == "nama_jab") {
			return $nama_jab;
		} else if ($param == "nama_lvl") {
			return $nama_lvl;
		} else if ($param == "nama_mbr") {
			return $nama_mbr;
		} 
    }
	
	public static function getLvlPosisiJabatanID($id) {
		$sql = "SELECT DISTINCT mb.id,mb.member_name, mp.id AS pos_id,mp.status_position AS sts_pos,pl.level AS id_lvl,pl.desc AS LEVEL,ps.id_posisi,ps.name AS posisi,pa.jab_id AS id_jabatan,pa.jabatan FROM member mb INNER JOIN member_position mp ON mp.member_id=mb.id INNER JOIN pos_lokasi pl ON pl.level=mp.level INNER JOIN pos_level ps ON ps.id_posisi=mp.position INNER JOIN pos_as pa ON pa.jab_id=mp.position_as WHERE mb.id='{$id}' AND mp.status_position='UTAMA'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_pos = "";
        $id_jab = "";
        $id_lvl = "";
		$id_mbr = "";

        $nama_pos = "";
        $nama_jab = "";
        $nama_lvl = "";
        $nama_mbr = "";
        foreach ($rows as $result) {
            $id_pos = $result['id_posisi'];
            $id_jab = $result['id_jabatan'];
            $id_lvl = $result['id_lvl'];
			$id_mbr = $result['id'];

            $nama_pos = strtoupper($result['posisi']);
            $nama_jab = strtoupper($result['jabatan']);
            $nama_lvl = strtoupper($result['level']);
            $nama_mbr = strtoupper($result['name']);
        }
		return array(
			'id_pos' => $id_pos, 'id_jab' => $id_jab, 'id_lvl' => $id_lvl, 'id_mbr' => $id_mbr,
			'nama_pos' => $nama_pos, 'nama_jab' => $nama_jab, 'nama_lvl' => $nama_lvl, 'nama_mbr' => $nama_mbr
		);
    }
	
	public static function getLvlPosisiJabatanID2($id) {
		$sql = "SELECT DISTINCT mb.id,mb.member_name, mp.id AS pos_id,mp.status_position AS sts_pos,pl.level AS id_lvl,pl.desc AS LEVEL,ps.id_posisi,ps.name AS posisi,pa.jab_id AS id_jabatan,pa.jabatan FROM member mb INNER JOIN member_position mp ON mp.member_id=mb.id INNER JOIN pos_lokasi pl ON pl.level=mp.level INNER JOIN pos_level ps ON ps.id_posisi=mp.position INNER JOIN pos_as pa ON pa.jab_id=mp.position_as WHERE mb.id='{$id}' AND mp.status_position='KEDUA'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_pos = "";
        $id_jab = "";
        $id_lvl = "";
		$id_mbr = "";

        $nama_pos = "";
        $nama_jab = "";
        $nama_lvl = "";
        $nama_mbr = "";
        foreach ($rows as $result) {
            $id_pos = $result['id_posisi'];
            $id_jab = $result['id_jabatan'];
            $id_lvl = $result['id_lvl'];
			$id_mbr = $result['id'];

            $nama_pos = strtoupper($result['posisi']);
            $nama_jab = strtoupper($result['jabatan']);
            $nama_lvl = strtoupper($result['level']);
            $nama_mbr = strtoupper($result['name']);
        }
		return array(
			'id_pos' => $id_pos, 'id_jab' => $id_jab, 'id_lvl' => $id_lvl, 'id_mbr' => $id_mbr,
			'nama_pos' => $nama_pos, 'nama_jab' => $nama_jab, 'nama_lvl' => $nama_lvl, 'nama_mbr' => $nama_mbr
		);
    }
	
	public static function getLvlPosisiJabatan2($id, $param) {
		$sql = "SELECT DISTINCT mb.id,mb.member_name AS name,mp.id AS mpos_id,mp.status_position AS sts_pos,pl.level AS id_lvl,pl.desc AS LEVEL,ps.id_posisi,ps.name AS posisi,pa.jab_id AS id_jabatan,pa.jabatan FROM member mb "
			 . "INNER JOIN member_position mp ON mp.member_id=mb.id "
			 . "INNER JOIN pos_lokasi pl ON pl.level=mp.level "
			 . "INNER JOIN pos_level ps ON ps.id_posisi=mp.position "
			 . "INNER JOIN pos_as pa ON pa.jab_id=mp.position_as "
			 . "WHERE mb.id='".$id."' AND mp.status_position='KEDUA'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        $id_pos = "";
        $id_jab = "";
        $id_lvl = "";
		$id_mbr = "";

        $nama_pos = "";
        $nama_jab = "";
        $nama_lvl = "";
        $nama_mbr = "";
        foreach ($rows as $result) {
            $id_pos = $result['id_posisi'];
            $id_jab = $result['id_jabatan'];
            $id_lvl = $result['id_lvl'];
			$id_mbr = $result['id'];

            $nama_pos = strtoupper($result['posisi']);
            $nama_jab = strtoupper($result['jabatan']);
            $nama_lvl = strtoupper($result['level']);
            $nama_mbr = strtoupper($result['name']);
        }
		if ($param == "id_pos") {
			return $id_pos;
		} else if ($param == "id_jab") {
			return $id_jab;
		} else if ($param == "id_lvl") {
			return $id_lvl;
		} else if ($param == "id_mbr") {
			return $id_mbr;
		} else if ($param == "nama_pos") {
			return $nama_pos;
		} else if ($param == "nama_jab") {
			return $nama_jab;
		} else if ($param == "nama_lvl") {
			return $nama_lvl;
		} else if ($param == "nama_mbr") {
			return $nama_mbr;
		} 
    }
	
    public static function MemberNo($kelurahanid) {
        try {
            $arr = Member::getKabProvKecID($kelurahanid);
            $sql = "SELECT MAX(SUBSTRING(CONCAT('000000',IFNULL(A.membership_id,'')),LENGTH(CONCAT('000000',IFNULL(A.membership_id,'')))-5,6))+1 as kode FROM member A INNER JOIN kelurahan B ON A.member_sub_district_id= B.id_kel LEFT JOIN kecamatan C ON C.id_kec= B.id_kec WHERE C.id_kab='" . $arr['id_kab'] . "'";
            $nextKode = "";
            $results = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($results AS $result) {
                $nextKode = $result['kode'];
            }

            while (strlen($nextKode) < 6) {
                $nextKode = "0" . $nextKode;
            }
        } catch (Exception $e) {
            $nextKode = "000100";
        }


        if ($nextKode == "000000")
            $nextKode = "000100";
        return $nextKode;
    }
	
	public static function CountMemberRegion($RegKode) {
		switch(strlen($RegKode)) {
			case 2:
				$sql = "SELECT K.id_kab as id, K.nama AS name, count(substr(member_sub_district_id,1,4)) as total FROM kabupaten K "
					 . "INNER JOIN member M ON SUBSTR(M.member_sub_district_id, 1, 4)=K.id_kab "
					 . "WHERE K.id_prov='$RegKode' GROUP BY K.id_kab ORDER BY total DESC";
				break;
			case 4:
				$sql = "SELECT K.id_kec as id, K.nama AS name, count(substr(member_sub_district_id,1,6)) as total FROM kecamatan K "
					 . "INNER JOIN member M ON SUBSTR(M.member_sub_district_id, 1, 6)=K.id_kec "
					 . "WHERE K.id_kab='$RegKode' GROUP BY K.id_kec ORDER BY total DESC";
				break;
			case 6:
				$sql = "SELECT K.id_kel as id, K.nama AS name, count(member_sub_district_id) as total FROM kelurahan K "
					 . "INNER JOIN member M ON M.member_sub_district_id=K.id_kel "
					 . "WHERE K.id_kec='$RegKode' GROUP BY K.id_kel ORDER BY total DESC";
				break;
			default:
				$sql = "SELECT P.id_prov AS id, P.nama AS name, count(substr(member_sub_district_id,1,2)) as total FROM provinsi P "
					 . "INNER JOIN member M ON SUBSTR(M.member_sub_district_id, 1, 2)=P.id_prov GROUP BY P.id_prov ORDER BY total DESC";
				break;
		}
		
		$Total =  Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider = new CArrayDataProvider($Total, array(
			'keyField' => 'id',
			'pagination' => false
		));
		
		return $dataProvider;
	}
	
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('membership_id',$this->membership_id,true);
		$criteria->compare('member_name',$this->member_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('is_married',$this->is_married,true);
		$criteria->compare('blood_type',$this->blood_type,true);
		$criteria->compare('occupation',$this->occupation,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('last_education_id',$this->last_education_id);
		$criteria->compare('sub_district_id',$this->sub_district_id,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('home_number',$this->home_number,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('member_sub_district_id',$this->member_sub_district_id,true);
		$criteria->compare('member_address',$this->member_address,true);
		$criteria->compare('member_home_number',$this->member_home_number,true);
		$criteria->compare('member_rt',$this->member_rt);
		$criteria->compare('member_rw',$this->member_rw);
		$criteria->compare('member_postal_code',$this->member_postal_code,true);
		$criteria->compare('couple_name',$this->couple_name,true);
		$criteria->compare('children_name',$this->children_name,true);
		$criteria->compare('home_phone_number',$this->home_phone_number,true);
		$criteria->compare('cellular_phone_number',$this->cellular_phone_number,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('member_type_id',$this->member_type_id);
		$criteria->compare('member_status',$this->member_status,true);
		$criteria->compare('member_active_number',$this->member_active_number,true);
		$criteria->compare('registered_time',$this->registered_time,true);
		$criteria->compare('identity_number',$this->identity_number,true);
		$criteria->compare('CARD_UID',$this->CARD_UID,true);
		$criteria->compare('last_print',$this->last_print,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('is_domisili',$this->is_domisili,true);
		$criteria->compare('is_have_position',$this->is_have_position,true);
		$criteria->compare('is_other_position',$this->is_other_position,true);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('mobile_auth',$this->mobile_auth,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function loadMember($filter, $status, $pagination) {
		$criteria = new CDbCriteria;
		$criteria->select = "t.id, t.membership_id, UPPER(t.member_name) as member_name, t.gender, t.member_sub_district_id, t.cellular_phone_number, t.last_print, t.last_update, t.reference, t.member_active_number, t.registered_time, t.address, t.home_number, t.rt, t.rw, t.member_address, t.member_home_number, t.member_rt, t.member_rw, t.sub_district_id ";
		$criteria->join = "LEFT JOIN kelurahan kl ON kl.id_kel=t.member_sub_district_id ";
		$criteria->join .= "LEFT JOIN kecamatan kc ON kc.id_kec=kl.id_kec ";
		$criteria->join .= "LEFT JOIN kabupaten kb ON kb.id_kab=kc.id_kab ";
		$criteria->join .= "LEFT JOIN provinsi pv ON pv.id_prov=kb.id_prov ";
		$criteria->group .= "t.membership_id";
		$criteria->condition = "t.id!=1 AND t.membership_id IS NOT NULL AND t.member_status='{$status}' {$filter}";
		if (isset($_GET['is_print'])) {
			$is_print = $_GET['is_print'];
			if ($is_print == "P") {
				$criteria->addCondition('last_print is not null');
			} else if ($is_print == "N") {
				$criteria->addCondition('last_print is null');
			}
		}
        if (isset($_GET['filterdpd'])) {
            $dpd = $_GET['filterdpd'];
            if ($dpd != "") {
                $criteria->addCondition('pv.id_prov = "' . $dpd . '" ');
            }
        }
        if (isset($_GET['filterdpc'])) {
            $dpc = $_GET['filterdpc'];
            if ($dpc != "") {
                $criteria->addCondition('kb.id_kab = "' . $dpc . '"');
            }
        }
        if (isset($_GET['filterdpac'])) {
            $dpac = $_GET['filterdpac'];
            if ($dpac != "") {
                $criteria->addCondition('kc.id_kec = "' . $dpac . '"');
            }
        }
        if (isset($_GET['filterdpar'])) {
            $dpar = $_GET['filterdpar'];
            if ($dpar != "") {
                $criteria->addCondition('kl.id_kel = "' . $dpar . '"');
            }
        }
        if (isset($_GET['Member'])) {
            if ($_GET['Member']['membership_id'] != '') {
				$criteria->addCondition('membership_id LIKE "%'.$_GET['Member']['membership_id'].'%"');
            }
            if ($_GET['Member']['member_name'] != '') {
				$criteria->addCondition('member_name LIKE "%'.$_GET['Member']['member_name'].'%"');
            }
            if ($_GET['Member']['reference'] != '') {
				$criteria->addCondition('reference LIKE "%'.$_GET['Member']['reference'].'%"');
            }
            if ($_GET['Member']['identity_number'] != '') {
				$criteria->addCondition('identity_number LIKE "%'.$_GET['Member']['identity_number'].'%"');
            }
            if ($_GET['Member']['tglmulai'] != '') {
				$criteria->addCondition('last_print >= "'.$_GET['Member']['tglmulai'].' 00:00:00"');
            }
            if ($_GET['Member']['tglakhir'] != '') {
				$criteria->addCondition('last_print <= "'.$_GET['Member']['tglakhir'].' 23:59:59"');
            }
        }
		if (isset($_GET['Member_adm_print']) && $_GET['Member_adm_print'] != '') {
			$criteria->join .= "LEFT JOIN log_print lp ON lp.member_id=t.id ";
			$criteria->join .= "LEFT JOIN users us ON us.users_id=lp.users_id ";
			$criteria->addCondition("us.users_id='".$_GET['Member_adm_print']."'");
		}
		
		$dataProvider = new CActiveDataProvider('Member', array(
			'criteria' => $criteria,
            'pagination' => $pagination,
            'sort' => array(
                'defaultOrder' => 'last_update DESC',
        )));

        return $dataProvider;
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
	