<?php
class _apiController extends Controller {
	private $format = 'json';
	private function domain() {
		return Yii::app()->request->hostInfo;
	}
	public function filters() {
		return array();
	}
	public function actionIndex() {
		$this->_checkAuth();
		$this->_sendResponse(200, '{"member_name":["Anda harus melengkapi data NAMA LENGKAP."],"birth_place":["Anda harus melengkapi data TEMPAT LAHIR."],"occupation":["Anda harus melengkapi data PEKERJAAN."],"cellular_phone_number":["Anda harus melengkapi data NO. SELULER."],"identity_number":["Anda harus melengkapi data NO. KTP \/ NO. SIM \/ NO. PASPOR."],"date_of_birth":["Anda harus melengkapi data TANGGAL LAHIR."]}', 'application/json' );
		//echo CJSON::encode(array(1, 2, 3));
	}
	private function cUrlMasking($extUrl) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://sms.rosihanari.net:8080/web2sms/api/sendSMS.aspx?username='.$extUrl);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	private function _getMobileMenu($hp) {
		
		$this->_sendResponse(200, '{"success": true,"message": "Nomor Seluler Valid!"}');
		return;
	}
	private function _validate() {
		if (isset($_GET['hp'])) {
			$num = $_GET['hp'];
			if (strlen($num) <= 8) {
				$this->_sendResponse(500, '{"success": false,"message": "Nomor HP salah . Input Anda = ' . strlen($num) . ' digit.\nMinimal input 8 digit."}');
				return;
			} else if ($num == '') {
				$this->_sendResponse(500, '{"success": false,"message": "Nomor HP tidak boleh kosong!."}');
				return;
			} else {
				$noTelkomsel = array('0852', '0853', '0811', '0812', '0813', '0821', '0822', '0823');
				$noIndosat = array('0856', '0857', '0815', '0816', '0858');
				$noXL = array('0817', '0818', '0819', '0859', '0877', '0878');
				$noThree = array('0896', '0897', '0898', '0899');
				$noAxis = array('0831', '0838');
				$prefix = array_merge($noTelkomsel, $noIndosat, $noXL, $noThree, $noAxis);
				if (in_array(substr($num, 0, 4), $prefix)) {
					$cDouble = Yii::app()->db->createCommand("select count(*) as count, UPPER(member_name) as nama from member where cellular_phone_number='$num'")->queryRow();
					if ($cDouble['count'] >= 1) {
						$nama = $cDouble['nama'];
						$this->_sendResponse(500, '{"success": false,"message": "Nomor HP Terdaftar a/n '.$nama.' !."}');
						return;
					} else {
						$this->_sendResponse(200, '{"success": true,"message": "Nomor Seluler Valid!"}');
					}					
				} else {
					$this->_sendResponse(500, '{"success": false,"message": "Nomor Seluler Tidak Valid !."}');
					return;
				}
			}
		} else if (isset($_GET['nik'])) {
			$nik = $_GET['nik'];
			if (strlen($nik) != 16){
				$this->_sendResponse(500, '{"success": false,"message": "Panjang NIK harus 16 angka. Input Anda = ' . strlen($nik) . ' angka."}');
				return;
			} else {
				$district = substr($nik, 0, 4);
				$cDistrict = Yii::app()->db->createCommand("SELECT id_kab AS district FROM kabupaten WHERE id_kab='$district'")->queryRow();
				$cDouble = Yii::app()->db->createCommand("SELECT COUNT(*) AS count, UPPER(member_name) AS nama FROM member WHERE identity_number='$nik'")->queryRow();
				if ($cDistrict['district'] == NULL) {
					$this->_sendResponse(500, '{"success": false,"message": "Nomor KTP Tidak Dikenal Harap Periksa Kembali !"}');
					return;
				} else if ($cDouble['count'] >= 1) {
					$nama = $cDouble['nama'];
					$this->_sendResponse(500, '{"success": false,"message": "No KTP Ini sudah pernah terdaftar a/n '.$nama.' !"}');
					return;
				} else {
					$data = array();
					$data['provinsi'] = substr($nik, 0, 2);
					$data['kota'] = substr($nik, 0, 4);
					$data['kecamatan'] = substr($nik, 0, 6);
					$data['tanggal_lahir'] = substr($nik, 6, 2);
					$data['bulan_lahir'] = substr($nik, 8, 2);
					$data['tahun_lahir'] = (substr($nik, 10, 1) == 0 ? "20" : "19") . substr($nik, 10, 2);
					if (intval($data['tanggal_lahir']) > 40) {
						$data['tanggal_lahir'] = intval($data['tanggal_lahir']) - 40;
						$gender = 'P';
					} else {
						$gender = 'L';
					}
					$this->_sendResponse(200, '{"success": true, "message": "Nomor KTP Valid !","provinsi": "' . $data['provinsi'] . '","kota": "' . $data['kota'] . '","kecamatan": "' . $data['kecamatan'] . '","tanggal_lahir": "' . $data['tanggal_lahir'] . '","bulan_lahir": "' . $data['bulan_lahir'] . '","tahun_lahir": "' . $data['tahun_lahir'] . '","jk": "' . $gender . '"}');
					return;
				}
			}
		} else {
			$this->_sendResponse(500, 'Error: Missing Parameters');
			return;
		}
	}
	private function _getDistrict() {
		$data = Member::getKabProvKecID($_GET['subdistrict']);
		foreach($data as $json) {
			$this->_sendResponse(200, '{"success": true, "data": '.CJSON::encode($data).'}');
		}
		return;
	}
	private function _getImg($id) {
		if (isset($_GET['ktp'])) {
			$model = MemberIdentity::model()->findByPk($id);			
			header('Content-Type:'. $model->photo_type);
			print $model->img_photo;
			return;
		} else if (isset($_GET['kta'])) {
			$member = Member::model()->findByPk($id);
			if ($member->last_print != null) {
				$model = MemberCard::model()->findByPk($id);			
				header('Content-Type:'. $model->photo_type);
				print $model->img_photo;
			} else {
				$this->_sendResponse(500, '{"success": false, "data": "KTA Belum Dicetak!"}');
			}			
			return;
		} else if (isset($_GET['barcode'])) {
			$model = Member::model()->findByPk($id);
			$bc_src = imagecreatetruecolor(290, 70);
			$putih = ImageColorAllocate($bc_src,0xff,0xff,0xff);
			$hitam = ImageColorAllocate($bc_src,0x00,0x00,0x00);
			$rotation = 0; //Rotasi Barcode
			imagefilledrectangle($bc_src, 0, 0, 290, 70, $putih);
			$data = Globals::gd($bc_src, $hitam, 145, 35, $rotation, 'code128', array('code'=>$model->membership_id), 3, 65);
			header('Content-Type: image/jpeg');
			imagejpeg($bc_src);
			return;
		} else if (isset($_GET['params'])) {
			$model = ImgSite::model()->findByAttributes(array('params'=>$_GET['params']));
			header('Content-Type:'. $model->img_type);
			print $model->image;
			return;
		} else {
			$model = MemberPhoto::model()->findByPk($id);
			header('Content-Type:'. $model->photo_type);
			print $model->img_photo;
			return;
		}
	}
	private function _newsImg($id) {
		$model=SiteNews::model()->findByPk($id);
		header('Content-Type:'. $model->img_type);
		print $model->news_img;
		return;
	}
	private function _upCoordinate($user, $latitude, $longitude) {
		$model = new LokasiMember;
		$model->member_id = $user;
		$model->track_lat = $latitude;
		$model->track_lon = $longitude;
		$model->time = new CDbExpression('NOW()');
		if($model->save()) {
			$update = Lokasi::model()->findByPk($user);
			$update->mobile_lat = $latitude;
			$update->mobile_lon = $longitude;
			if($update->save()) {
				$distance = 1000000; // Jarak dalam meter
				$sql="SELECT l.member_id, l.mobile_lat, l.mobile_lon, (((ACOS(SIN(($latitude* PI()/180)) * SIN((l.mobile_lat* PI()/180))+ COS(($latitude* PI()/180))* COS((l.mobile_lat* PI()/180))* COS((($longitude-l.mobile_lon)* PI()/180))))*180/ PI())*60*1.1515*1609.344) AS distance FROM lokasi AS l INNER JOIN member m ON m.id=l.member_id WHERE l.member_id!=$user AND m.last_print IS NOT NULL HAVING distance < $distance ORDER BY distance ASC LIMIT 100";
				$nearby = Yii::app()->db->createCommand($sql)->queryAll();
				if (count($nearby) == 0) {
					$this->_sendResponse(404, '{"success": false, "message": "'.count($nearby).'"}');
				} else {
					$this->_sendResponse(200, '{
						"success": true,
						"message": "get nearby coordinates success",
						"nearby": '.CJSON::encode($nearby).'
					}');
				}
			}
		}
		return;
	}
	private function _sendAuthenticate($hp, $msg) {
		$maskUser = 'bpokkpd'; $maskUserXl = 'xlbpokkpd';
		$arrXl = array('0817', '0818', '0819', '0859', '0877', '0878');
		$maskSrv = $maskUser.'&mobile='.$hp.'&message='.urlencode($msg).'&auth='.MD5($maskUser.'o1923klj'.$hp);
		$maskSrvXl = $maskUserXl.'&mobile='.$hp.'&message='.urlencode($msg).'&auth='.MD5($maskUserXl.'ttdopxsa'.$hp);		
		if (in_array(substr($hp, 0, 4), $arrXl)) {
			$grab = $this->cUrlMasking($maskSrvXl);
		} else {
			$grab = $this->cUrlMasking($maskSrv);
		}
		return substr($grab, 0, 4);
	}
	public function actionCreate() {
		$this->_checkAuth();
		switch($_GET['model']) {
			case 'members':
				$model = new Member;
				$model->setAttributes('Member');
				$model->registered_time = new CDbExpression('NOW()');
				if ($_POST['is_domisili'] == 'Y') {
					$model->member_sub_district_id = $_POST['sub_district_id'];
				}
				$model->member_status = 'N';
				$model->membership_id = substr($model->member_sub_district_id, 0, 4) . Member::MemberNo($model->member_sub_district_id);
				$model->mobile_auth = rand(1000,9999);
				break;
			case 'imgFt':
				if(!isset($_POST['member_id'])) {
					$this->_sendResponse(500, 'Error: Parameter <b>member_id</b> is missing' );
				} else {
					if(isset($_FILES['img_photo'])) {
						$model = new MemberPhoto;
						$model->setAttributes('MemberPhoto');
						$photo = $_FILES['img_photo']['tmp_name'];
						$fp = fopen($photo, 'r');
						$content = fread($fp, filesize($photo));
						fclose($fp);
						$model->img_photo = $content;
						$model->photo_type = $_FILES['img_photo']['type'];
					} else {
						$this->_sendResponse(500, 'Error: Parameter <b>img_photo</b> is missing' );
					}
				}
				break;
			case 'imgId':
				if(!isset($_POST['member_id'])) {
					$this->_sendResponse(500, 'Error: Parameter <b>member_id</b> is missing' );
				} else {
					if(isset($_FILES['img_photo'])) {
						$model = new MemberIdentity;
						$model->setAttributes('MemberIdentity');
						$identitas = $_FILES['img_photo']['tmp_name'];
						$fp = fopen($identitas, 'r');
						$content = fread($fp, filesize($identitas));
						fclose($fp);
						$model->img_photo = $content;
						$model->photo_type = $_FILES['img_photo']['type'];
					} else {
						$this->_sendResponse(500, 'Error: Parameter <b>img_photo</b> is missing' );
					}
				}
				break;
			case 'berita':
				$model = new SiteNews;
				break;
			case 'coordinates':
				if (!isset($_POST['member_id'])) {
					$this->_sendResponse(500, 'Error: Parameter <b>member_id</b> is missing' );
				} else if(!isset($_POST['track_lat'])) {
					$this->_sendResponse(500, 'Error: Parameter <b>track_lat</b> is missing' );
				} else if(!isset($_POST['track_lon'])) {
					$this->_sendResponse(500, 'Error: Parameter <b>track_lon</b> is missing' );
				} else {
					if ($_POST['member_id'] == 1) {
						$this->_upCoordinate($_POST['member_id'], -6.202083600, 106.846899700);
					} else {
						$this->_upCoordinate($_POST['member_id'], $_POST['track_lat'], $_POST['track_lon']);
					}					
				}
				break;
			default:
				$this->_sendResponse(501, sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		
		foreach($_POST as $var=>$value) {
			if($model->hasAttribute($var)) {
				$model->$var = $value;
			} else {
				$this->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $_GET['model']) );
			}
		}
		
		if($model->save()) {
			if($_GET['model'] == 'members') {
				$address = Kelurahan::model()->findByPk($model->member_sub_district_id);
				$lokasi = new Lokasi;
				$lokasi->member_id = $model->id;
				$lokasi->address_lat = $address->latitude;
				$lokasi->address_lon = $address->longitude;
				$lokasi->save();
			}
			$this->_sendResponse(200, $this->_getObjectEncoded($_GET['model'], $model->attributes) );
		} else {
			$json= array();
			foreach($model->errors as $attribute=>$attr_errors) {
				foreach($attr_errors as $attr_error) {
					array_push($json,$attr_error);
				}
			}
			$this->_sendResponse(500, CJSON::encode($json) );
		}
	}
	public function actionList() {
		$this->_checkAuth();
		switch($_GET['model']) {
			case 'members':
				$models = Member::model()->findAll(array('limit'=>10));
				break;
			case 'getdistrict':
				if(!isset($_GET['subdistrict']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$this->_getDistrict();
				break;
			case 'validate':
				if(!isset($_GET['hp']) && !isset($_GET['nik']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$this->_validate();
				break;
			case 'users':
				$models = Users::model()->findAll();
				break;
			case 'berita':
				$models = SiteNews::model()->findAll(Array(
					'select'=>'news_id,admin,kategori,judul,isi_berita,sticky,tgl_post,status'
				));
				break;
			case 'provinsi':
				$models = Provinsi::model()->findAll();
				break;
			case 'kabupaten':			
				if(!isset($_GET['prov']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$models = Kabupaten::model()->findAllByAttributes(array('id_prov' => $_GET['prov']));
				break;
			case 'kecamatan':			
				if(!isset($_GET['kab']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$models = Kecamatan::model()->findAllByAttributes(array('id_kab' => $_GET['kab']));
				break;
			case 'kelurahan':			
				if(!isset($_GET['kec']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$models = Kelurahan::model()->findAllByAttributes(array('id_kec' => $_GET['kec']));
				break;
			case 'pendidikan':
				$models = LastEducation::model()->findAll();
				break;
			case 'menu':
				if(!isset($_GET['hp']))
					$this->_sendResponse(500, 'Error: Missing Parameters' );
				$this->_getMobileMenu($_GET['hp']);
				break;
			default:
				$this->_sendResponse(501, sprintf('Error: Mode <b>list</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		if(is_null($models)) {
			$this->_sendResponse(500, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
		} else {
			$rows = array();
			foreach($models as $model)
				$rows[] = $model->attributes;
			$this->_sendResponse(200, CJSON::encode($rows));
		}
	}
	public function actionView() {
		$this->_checkAuth();
		$parameter = $_GET['id'];
		if(!isset($_GET['id']))
			$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );

		switch($_GET['model']) {
			case 'auth':
				$model = Member::model()->findByAttributes(array('cellular_phone_number'=>$parameter,'member_status'=>'A'));
				break;
			case 'members':
				$model = Member::model()->findByPk($parameter);
				break;
			case 'getimages':
				$this->_getImg($parameter);
				break;
			case 'imgnews':
				$this->_newsImg($parameter);
				break;
			case 'berita':
				$model = SiteNews::model()->findByPk($parameter);
				break;
			default:
				$this->_sendResponse(501, sprintf('Mode <b>view</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		if(is_null($model)) {
			$this->_sendResponse(404, '{"success": false, "message": " Parameter (' . $_GET["id"] . ') tidak ditemukan pada database %s !"}');
		} else {
			$this->_sendResponse(200, $this->_getObjectEncoded($_GET['model'], $model->attributes));
		}
	}
	public function actionUpdate() {
		$this->_checkAuth();		
		parse_str(file_get_contents('php://input'), $put_vars);
		switch($_GET['model']) {
			case 'members':
				$model = Member::model()->findByPk($_GET['id']);
				break;
			case 'berita':
				$model = SiteNews::model()->findByPk($_GET['id']);
				break;
			default:
				$this->_sendResponse(501, sprintf('Error: Mode <b>update</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		if(is_null($model))
			$this->_sendResponse(400, sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
		foreach($put_vars as $var=>$value) {
			if($model->hasAttribute($var)) {
				$model->$var = $value;
			} else {
				$this->_sendResponse(500, sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $_GET['model']) );
			}
		}
		if($model->save()) {
			$this->_sendResponse(200, sprintf('The model <b>%s</b> with id <b>%s</b> has been updated.', $_GET['model'], $_GET['id']) );
		} else {
			$msg = "<h1>Error</h1>";
			$msg .= sprintf("Couldn't update model <b>%s</b>", $_GET['model']);
			$msg .= "<ul>";
			foreach($model->errors as $attribute=>$attr_errors) {
				$msg .= "<li>Attribute: $attribute</li>";
				$msg .= "<ul>";
				foreach($attr_errors as $attr_error) {
					$msg .= "<li>$attr_error</li>";
				}
				$msg .= "</ul>";
			}
			$msg .= "</ul>";
			$this->_sendResponse(500, $msg );
		} 
	}
	public function actionDelete() {
		$this->_checkAuth();
		switch($_GET['model']) {
			/*case 'members':
				$model = Member::model()->findByPk($_GET['id']);
				break;*/
			default:
				$this->_sendResponse(501, sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		if(is_null($model)) {
			$this->_sendResponse(400, sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
		}
		
		$num = $model->delete();
		if($num>0)
			$this->_sendResponse(200, sprintf("Model <b>%s</b> with ID <b>%s</b> has been deleted.",$_GET['model'], $_GET['id']) );
		else
			$this->_sendResponse(500, sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",$_GET['model'], $_GET['id']) );
	}
	// Start API v2 renew Authentication and Methode	
	public function actionImages() { //api/v2/images/<model:\w+>/<id:\d+>
		if(!isset($_GET['id']))
			$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		
		switch($_GET['model']) {
			case 'photo': //api/v2/images/photo/<id>
				$model = MemberPhoto::model()->findByPk($_GET['id']);
				header('Content-Type:'. $model->photo_type);
				print $model->img_photo;
				break;
			case 'identitas': //api/v2/images/identitas/<id>
				$model = MemberIdentity::model()->findByPk($_GET['id']);			
				header('Content-Type:'. $model->photo_type);
				print $model->img_photo;
				break;
			case 'kartu': //api/v2/images/kartu/<id>
				$member = Member::model()->findByPk($_GET['id']);
				if ($member->last_print != null) {
					$model = MemberCard::model()->findByPk($id);			
					header('Content-Type:'. $model->photo_type);
					print $model->img_photo;
				} else {
					$this->_sendResponse(500, '{"success": false, "data": "KTA Belum Dicetak!"}');
				}
				break;
			case 'barcode': //api/v2/images/barcode/<id>
				$model = Member::model()->findByPk($_GET['id']);
				if ($member->last_print != null) {
					$bc_src = imagecreatetruecolor(290, 70);
					$putih = ImageColorAllocate($bc_src,0xff,0xff,0xff);
					$hitam = ImageColorAllocate($bc_src,0x00,0x00,0x00);
					$rotation = 0; //Rotasi Barcode
					imagefilledrectangle($bc_src, 0, 0, 290, 70, $putih);
					$data = Globals::gd($bc_src, $hitam, 145, 35, $rotation, 'code128', array('code'=>$model->membership_id), 3, 65);
					header('Content-Type: image/jpeg');
					imagejpeg($bc_src);
				} else {
					$this->_sendResponse(500, '{"success": false, "data": "KTA Belum Dicetak!"}');
				}
				break;
			case 'berita': //api/v2/images/berita/<id>
				$model=SiteNews::model()->findByPk($_GET['id']);
				if ($model != null) {
					header('Content-Type:'. $model->img_type);
					print $model->news_img;
				} else {
					$this->_sendResponse(500, '{"success": false, "data": "Berita Tidak Memiliki Gambar!"}');
				}
				break;
			default:
				$this->_sendResponse(501, sprintf('Error: Mode <b>list</b> is not implemented for model <b>%s</b>',$_GET['model']) );
				exit;
		}
		if(is_null()) {
			$this->_sendResponse(500, sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
		}
	}
	public function actionGetList() { //api/v2/<model:\w+>
		$this->_checkAuth();
		switch($_GET['model']) {
			case 'members': //api/v2/data/allmembers
				$models=Member::model()->findAll(); // untuk sementara tidak dapat digunakan karena batasan memory.
				break;
			case 'nearby': //api/v2/images/members (parameters: <member_id>,<latitude>,<longitude>)
				if (!isset($_GET['id'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>id</b> is missing!"}');
				} else if(!isset($_GET['lat'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>lat</b> is missing!"}');
				} else if(!isset($_GET['lon'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>lon</b> is missing!"}');
				} else {
					$this->_nearbyMember($_GET['id'], $_GET['lat'], $_GET['lon']);
				}
				break;
			case 'provinsi': //api/v2/provinsi
				$models=Provinsi::model()->findAll();
				break;
			case 'kabupaten': //api/v2/kabupaten (parameters: <id_prov>)
				if(!isset($_GET['id_prov']))
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				$models=Kabupaten::model()->findAllByAttributes(array('id_prov'=>$_GET['id_prov']));
				break;
			case 'kecamatan': //api/v2/kecamatan (parameters: <id_kab>)
				if (!isset($_GET['id_kab']) && !isset($_GET['id']))
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				$models=Kecamatan::model()->findAllByAttributes(array('id_kab'=>$_GET['id_kab']));
				break;
			case 'kelurahan': //api/v2/kelurahan (parameters: <id_kec>)
				if(!isset($_GET['id_kec']))
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				$models=Kelurahan::model()->findAllByAttributes(array('id_kec'=>$_GET['id_kec']));
				break;
			case 'region':
				if(!isset($_GET['subdistrict']))
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				$subdistrict = $_GET['subdistrict'];
				$sql="SELECT prov.nama AS `provinsi`, kab.nama AS `kabupaten`, kec.nama AS `kecamatan`, kel.nama AS `kelurahan` FROM kelurahan kel "
				   . "INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec "
				   . "INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab "
				   . "INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov "
				   . "WHERE kel.id_kel='$subdistrict'";
				$data=Yii::app()->db->createCommand($sql)->queryAll();
				$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode($data).'}');
				return;
				break;
			case 'validate': //api/v2/validate (parameter: <nik> atau <hp>)
				if(!isset($_GET['hp']) && !isset($_GET['nik']))
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				$this->_validate();
				break;
			case 'lokasi_jabatan': //api/v2/lokasi_jabatan atau //api/v2/lokasi_jabatan (parameters: <id>)
				if(!isset($_GET['id']))
					$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode(Helpers::getStrukturData('lokasi')).'}');
				$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode(Helpers::getStrukturData('lokasi', $_GET['id'])).'}');
				break;
			case 'pendidikan': //api/v2/pendidikan
				$models = LastEducation::model()->findAll();
				break;
			case 'berita': //api/v2/berita atau //api/v2/berita (parameters: <data> == {detail/sticky})
				if(!isset($_GET['data'])) {
					$this->_infoBerita();
				} else {
					if(isset($_GET['id']))
						$this->_infoBerita($_GET['data'], $_GET['id']);
					$this->_infoBerita($_GET['data']);
				}
				break;
			default:
				$this->_sendResponse(501, '{"success": false, "message": "Missing action!"}');
				exit;			
		}	
		
		if(is_null($models)) {
			$this->_sendResponse(404, '{"success": false, "message": " Parameter (' . $_GET["id"] . ') tidak ditemukan pada database %s !"}');
		} else {
			$rows = array();
			foreach($models as $model)
				$rows[] = $model->attributes;
			$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode($rows).'}');
		}
	}
	private function _nearbyMember($id, $lat, $lon) {
		$distance = 1000000; // Jarak dalam meter
		$sql="SELECT m.id, m.member_name, p.nama as dpd, k.nama as dpc, l.mobile_lat, l.mobile_lon, (((ACOS(SIN(($lat* PI()/180)) * SIN((l.mobile_lat* PI()/180))+ COS(($lat* PI()/180))* COS((l.mobile_lat* PI()/180))* COS((($lon-l.mobile_lon)* PI()/180))))*180/ PI())*60*1.1515*1609.344) AS distance FROM lokasi l INNER JOIN member m ON m.id=l.member_id INNER JOIN kabupaten k ON k.id_kab=SUBSTR(m.member_sub_district_id,1,4) INNER JOIN provinsi p ON p.id_prov=k.id_prov WHERE l.member_id!=$id AND m.last_print IS NOT NULL HAVING distance < $distance ORDER BY distance ASC LIMIT 100";
		$nearby = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($nearby) == 0) {
			$this->_sendResponse(404, '{"success": false, "message": "'.count($nearby).'"}');
		} else {
			$response['success'] = true;
			$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode($nearby).'}');
		}
	}
	private function _infoBerita($data = false, $id = null) {
		switch($data) {
			case 'detail':
				if(is_null($id)) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter is missing!"}');
				} else {
					$sql="SELECT sn.news_id, us.username, sn.judul, sn.isi_berita, sn.tgl_post, CONCAT('" . $this->domain() . CController::createUrl('api/v2') . "','/images/berita/',sn.news_id) as img_url FROM site_news sn INNER JOIN users us ON us.users_id=sn.admin WHERE sn.news_id=" . $id;
					$return = Yii::app()->db->createCommand($sql)->queryAll();
				}
				break;
			case 'slider':
				$sql="SELECT sn.news_id, sn.judul, CONCAT('" . $this->domain() . CController::createUrl('api/v2') . "','/images/berita/',sn.news_id) as img_url FROM site_news sn ORDER BY sn.tgl_post DESC";
				$return = Yii::app()->db->createCommand($sql)->queryAll();
				break;
			default:
				$sql="SELECT sn.news_id, us.username, sn.judul, sn.tgl_post, CONCAT('" . CController::createUrl('api/v2') . "','/images/berita/',sn.news_id) as img_url FROM site_news sn INNER JOIN users us ON us.users_id=sn.admin";
				$return = Yii::app()->db->createCommand($sql)->queryAll();
				break;
		}
		
		if(is_null($return)) {
			$this->_sendResponse(501, '{"success": false, "message": "Missing action method!"}');
		} else {
			$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.CJSON::encode($return).'}');
		}
	}
	public function actionGetOne() {	
		$this->_checkAuth();
		if(!isset($_GET['id']))
			$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
		$params = $_GET['id'];
		
		switch($_GET['model']) {
			case 'auth': //api/v2/auth
				$members=Member::model()->findByAttributes(array('cellular_phone_number'=>$params));
				$randOtp = rand(100000, 999999);
				if(!isset($_GET['token'])) {
					if (count($members) == 1) {
						switch ($members->member_status) {
							case 'B': // member blokir
								$this->_sendResponse(200, '{
									"success": false,
									"message": "Blokir",
									"data": [{
										"title": "Kader Diblokir!",
										"message": "Untuk Membuka Blokir\nSilahan Hubungi Administrator BPOKK DPP PD!"
									}]
								}');
								break;
							case 'N': // member non-aktif
								$this->_sendResponse(200, '{
									"success": false,
									"message": "Non-Aktif",
									"data": [{
										"title": "Kader Non-Aktif!",
										"message": "Silahan Hubungi Administrator BPOKK DPP PD!"
									}]
								}');
								break;
							default: // member aktif
								break;
						}
						$tplMsg = "OTP Login Anda : " . $randOtp . ". Masa aktif OTP Anda adalah 15 menit. Terima Kasih";
						$iToken = MobileStatus::model()->findByAttributes(array('member_id'=>$members->id));
						if(is_null($iToken)) {
							$iToken = new MobileStatus;
						}
						$respOtp = $this->_sendAuthenticate($params, $tplMsg);
						if ($respOtp == 1701) {		
							$iToken->member_id = $members->id;
							$iToken->token = $randOtp;
							if($iToken->save())
								$this->_sendResponse(200, '{"success": true, "message": "Token ' . $this->_respMasking($respOtp) . ' dikirim!"}');
							$this->_sendResponse(200, '{"success": false, "message": "' . $this->_respMasking($respOtp) . '"}');
						} else {
							$this->_sendResponse(200, '{"success": false, "message": "' . $this->_respMasking($respOtp) . '"}');
						}
					} else {
						$this->_sendResponse(404, '{"success": false, "message": " Kader dengan nomor seluler: ' . $params . ' tidak ditemukan!"}');						
					}
				} else {
					if(isset($_GET['firebaseId'])) {
						$uToken = MobileStatus::model()->findByAttributes(array('member_id'=>$members->id, 'token'=>$_GET['token']));
						if(is_null($uToken)) {
							$this->_sendResponse(200, '{"success": false, "message": "OTP yang Anda masukan salah!", "data": "'.$_GET['token'].'"}');
						} else {
							$members->mobile_auth = $_GET['firebaseId'];
							if($members->update()) {
								$uToken->status = 'Sukses';
								if($uToken->update()) {
									$model = $members;
								} else {
									$this->_sendResponse(200, '{"success": false, "message": "Token gagal diverifikasi. Hubungi Administrator!"}');
								}
							} else {
								$this->_sendResponse(200, '{"success": false, "message": "Member gagal diverifikasi. Hubungi Administrator!"}');
							}
						}
					} else {
						$this->_sendResponse(501, '{"success": false, "message": "Missing Parameter Firebase!"}');
					}
				}
				break;
			case 'provinsi':
				$model=Provinsi::model()->findByPk($params);
				break;
			case 'kabupaten':
				$model=Kabupaten::model()->findByPk($params);
				break;
			case 'kecamatan':
				$model=Kecamatan::model()->findByPk($params);
				break;
			case 'kelurahan':
				$model=Kelurahan::model()->findByPk($params);
				break;
			default:
				$this->_sendResponse(501, '{"success": false, "message": "Missing action!"}');
				exit;
		}
		
		if(is_null($model)) {
			$this->_sendResponse(404, '{"success": false, "message": " Parameter (' . $_GET["id"] . ') tidak ditemukan pada database %s !"}');
		} else {
			$this->_sendResponse(200, '{"success": true, "message": "Sukses mengambil data", "data": '.$this->_getObjectEncoded($_GET['model'], $model->attributes).'}');
		}		
	}
	public function actionPostOne() {
		$this->_checkAuth();
		switch($_GET['model']) {
			case 'tracker':
				if (!isset($_POST['uid'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>uid</b> is missing!"}');
				} else if (!isset($_POST['lat'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>lat</b> is missing!"}');
				} else if (!isset($_POST['lng'])) {
					$this->_sendResponse(500, '{"success": false, "message": "Parameter <b>lng</b> is missing!"}');
				} else {
					if ($_POST['uid'] == 1) {
						$this->_trackerServices($_POST['uid'], -6.202083600, 106.846899700);
					} else {
						$this->_trackerServices($_POST['uid'], $_POST['lat'], $_POST['lng']);
					}					
				}
				break;
			default:
				$this->_sendResponse(501, '{"success": false, "message": "Missing action!"}');
				Yii::app()->end();
		}
	}
	private function _trackerServices($uid, $lat, $lng) {
		$model = new LokasiMember;
		$model->member_id = $uid;
		$model->track_lat = $lat;
		$model->track_lon = $lng;
		$model->time = new CDbExpression('NOW()');
		if($model->save()) {
			$update = Lokasi::model()->findByPk($uid);
			$update->mobile_lat = $lat;
			$update->mobile_lon = $lng;
			if($update->save()) {
				$this->_sendResponse(200, '{"success": true, "message": "Sukses Update Lokasi" }');
			}
		}
		return;
	}
	public function actionPutOne() {
		
	}
	private function _respMasking($status = 1701) {
		$codes = Array(
			1701 => 'Success',
			1702 => 'Invalid Username or Password',
			1703 => 'Internal Server Error',
			1704 => 'Data not found',
			1705 => 'Process Failed',
			1706 => 'Invalid Phone Number',
			1707 => 'Invalid Message',
			1708 => 'Insufficient Credit',
			1709 => 'Group Empty',
			1711 => 'Invalid Group Name',
			1712 => 'Invalid Group ID',
			1721 => 'Invalid Phonebook Name',
			1722 => 'Invalid Phonebook ID',
			1731 => 'User Name already exist',
			1732 => 'Sender ID not valid',
			1733 => 'Internal Error – please contact administrator',
			1734 => 'Invalid client user name',
			1735 => 'Invalid Credit Value'
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
	private function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		header('Access-Control-Allow-Origin: *');
		if($body != '') {
			echo $body;
			exit;
		} else {
			$message = '';
			switch($status) {
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
			$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
						<html>
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
								<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
							</head>
							<body>
								<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
								<p>' . $message . '</p>
								<hr />
								<address>' . $signature . '</address>
							</body>
						</html>';
			echo $body;
			exit;
		}
	}
	private function _getStatusCodeMessage($status) {
		$codes = Array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
	private function _checkAuth() {
		if(!(isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']))) {
			$this->_sendResponse(403, 'You\'re not authorized to view this content !');
		}
		$username = $_SERVER['PHP_AUTH_USER']; $password = $_SERVER['PHP_AUTH_PW'];
		$user=Users::model()->find('LOWER(username)=?',array(strtolower($username)));
		if($user===null) {
			$this->_sendResponse(401, 'Error: User Name is invalid');
		} else if(!$user->validatePassword($username,md5($password))) {
			$this->_sendResponse(401, 'Error: User Password is invalid');
		}
	}
	private function _getObjectEncoded($model, $array) {
		if(isset($_GET['format']))
			$this->format = $_GET['format'];
		if($this->format=='json') {
			return CJSON::encode($array);
		} elseif ($this->format=='xml') {
			$result = '<?xml version="1.0">';
			$result .= "\n<$model>\n";
			foreach($array as $key=>$value)
				$result .= "    <$key>".utf8_encode($value)."</$key>\n";
				$result .= '</'.$model.'>';
				return $result;
		} else {
			return;
		}
	}
}