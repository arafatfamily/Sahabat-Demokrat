<?php
class MemberController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules() {
		return array(
			array('allow', 'actions' => array('register','Reference','readKTP','uploadImage','cropImage','loadPhoto','loadKtp','profil','info','getLog','FrontKTA','BackKTA','viewDokumen'),
				'users' => array('*'),), // publik akses
			array('allow','actions'=>array('index','view','loadKta','loadAdmin'),
				'expression' => '$user->getAkses(\'2\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('tambah'),
				'expression' => '$user->getAkses(\'1\',\'12\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('ubah'),
				'expression' => '$user->getAkses(\'3\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('hapus'),
				'expression' => '$user->getAkses(\'4\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('cetak','statusprint'),
				'expression' => '$user->getAkses(\'5\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('verifikasi','terima','tolak','unverified','revalidate'),
				'expression' => '$user->getAkses(\'39\',\'13\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('print'),
				'expression' => '$user->getAkses(\'6\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),	
			array('allow','actions'=>array('statistik'),
				'expression' => '$user->getAkses(\'40\',\'14\') || $user->isSuperadmin()','users'=>array('@'),),	
			array('allow','actions'=>array('blokir'),
				'expression' => '$user->getAkses(\'47\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),			
			array('allow','actions'=>array('setUid'),
				'expression' => '$user->getAkses(\'11\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),		
			array('allow','actions'=>array('massprint'),
				'expression' => '$user->getAkses(\'38\',\'19\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('struktur'),
				'expression' => '$user->getAkses(\'41\',\'15\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('export'),
				'expression' => '$user->getAkses(\'7\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('rekap'),
				'expression' => '$user->getAkses(\'50\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('dokumen'),
				'expression' => '$user->getAkses(\'9\',\'2\') || $user->isSuperadmin()','users'=>array('@'),),
			array('deny','users'=>array('*'),),
		);
	}
	public function actionviewDokumen($id) {
		$model = MemberDoc::model()->findByPk($id);
		header('Content-Type: '.$model->lamp_type);
		print $model->lampiran;
	}
	public function actionDokumen($id) {
		$model = new MemberDoc;
		$model->member_id = $id;
		$model->nama_dok= $_POST['doc_name'];
		$model->no_dok= $_POST['doc_num'];
		//$model->dok_oleh= $_POST['doc_by'];
		$model->oleh_non= $_POST['doc_by'];
		$model->tahun_dok= $_POST['doc_years'];
		$model->description= $_POST['doc_info'];
		$files = $_FILES['doc_files']['tmp_name'];
		$fp = fopen($files, 'r');
		$content = fread($fp, filesize($files));
		fclose($fp);
		$model->lampiran = $content;
		$model->lamp_type = $_FILES['doc_files']['type'];
		if($model->save(false)) {
			$this->redirect(array('view','id'=>$id));
		}
	}
	
	public function actionRekap() {
		$sql = "select p.id_prov, p.nama, count(substr(member_sub_district_id,1,2)) as total FROM provinsi p "
			 . "inner join member m ON substr(member_sub_district_id,1,2)=p.id_prov GROUP BY p.id_prov ORDER BY total DESC";
		$rows=Yii::app()->db->createCommand($sql)->queryAll();
		$dataProvider=new CArrayDataProvider($rows, array(
			'keyField'=>'id_prov',
			'pagination'=>false
		));
		$this->render('rekapKader',array(
			'dataProvider'=> $dataProvider
		));
	}
	
	public function actionExport() {
		ini_set('memory_limit', '2048M');		
		ini_set('max_execution_time', '180000');
		$filter = ""; $i = 2;
        if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new Member('search');
		$models = $model->loadMember($filter, 'A', false)->getData();
		Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator("Yasir Arafat, A.Md")
						 ->setLastModifiedBy("BPOKK DPP PARTAI DEMOKRAT")
						 ->setTitle("Rekap Data Kader Partai Demokrat(".Globals::bulan(date('m')).")")
						 ->setSubject("Office 2007 Document")
						 ->setDescription("data laporan web sahabat demokrat.")
						 ->setKeywords("Rekap data kader")
						 ->setCategory("Laporan SAHABAT DEMOKRAT");
		$objPHPExcel->getActiveSheet()->setCellValue('A1','No. KTA');
        $objPHPExcel->getActiveSheet()->setCellValue('B1','NAMA LENGKAP');
		$objPHPExcel->getActiveSheet()->setCellValue('C1','NO. HP');
		$objPHPExcel->getActiveSheet()->setCellValue('D1','ALAMAT');
		$objPHPExcel->getActiveSheet()->setCellValue('E1','DPC');
		$objPHPExcel->getActiveSheet()->setCellValue('F1','DPD');
		$objPHPExcel->getActiveSheet()->setCellValue('G1','PENGURUS TINGKAT');
		$objPHPExcel->getActiveSheet()->setCellValue('H1','JABATAN');
		$objPHPExcel->getActiveSheet()->setCellValue('I1','TANGGAL PRINT');
		$objPHPExcel->getActiveSheet()->setCellValue('J1','ADMIN CETAK/MODE');
		$objPHPExcel->getActiveSheet()->setCellValue('K1','REFERENSI');
		foreach($models as $key=>$data) {
			$alamatKader = $data->is_domisili != "N" ? $data->address . " " . $data->home_number . " RT " . $data->rt . " RW " . $data->rw . ", KEL. " . Member::getKabProvKec($data->sub_district_id, "nama_kel") . ", KEC. " . Member::getKabProvKec($data->sub_district_id, "nama_kec") : $data->member_address . " " . $data->member_home_number . " RT " . $data->member_rt . " RW " . $data->member_rw . ", KEL. " . Member::getKabProvKec($data->member_sub_district_id, "nama_kel") . ", KEC. " . Member::getKabProvKec($data->member_sub_district_id, "nama_kec");
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$i," ".$data->membership_id)
						->setCellValue('B'.$i,$data->member_name)
						->setCellValue('C'.$i," ".$data->cellular_phone_number)
						->setCellValue('D'.$i,$data->address)
						->setCellValue('E'.$i,Member::getKabProvKec($data->member_sub_district_id, "nama_kab"))
						->setCellValue('F'.$i,Member::getKabProvKec($data->member_sub_district_id, "nama_prov"))
						->setCellValue('G'.$i,Member::getLvlPosisiJabatan($data->id, 'nama_lvl'))
						->setCellValue('H'.$i,Member::getLvlPosisiJabatan($data->id, 'nama_pos'))
						->setCellValue('I'.$i,strlen($data->last_print) < 10 ? 'Belum Cetak' : Globals::dateIndonesia(explode(" ", $data->last_print)[0]))
						->setCellValue('J'.$i,strlen($data->last_print) < 10 ? 'n/a' : Globals::getAdminPrint("LogPrint", "member_id='".$data->id."'"))
						->setCellValue('K'.$i,Globals::findByRef("member","member_name","membership_id='".$data->reference."'"));
						$i++;
		}
		$objPHPExcel->getActiveSheet()->setTitle('Data Kader') ;
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Rekap Data Kader('.Globals::bulan(date('m')).').xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
		header ('Cache-Control: cache, must-revalidate'); 
		header ('Pragma: public'); 
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		Yii::app()->end();
	}
	
	public function actionGetLog() {
		header('Content-type: application/json');
		if (!$_POST['data']) {
			echo '{"success": false, "message": "Missing Parameters \'data\'"}';
		} else {
			$member = $this->loadModel($_POST['id']);
			$inputQuery = "SELECT li.date_time, us.username, li.act_info, li.act_type, li.ip_address FROM log_input li "
						. "INNER JOIN users us ON us.users_id=li.users_id WHERE li.member_id={$_POST['id']}";
			$printQuery = "SELECT lp.date_print, us.username, lp.print_type, lp.`status`, lp.ip_address FROM log_print lp "
						. "INNER JOIN users us ON us.users_id=lp.users_id WHERE lp.member_id={$_POST['id']}";
			if ($_POST['data'] == 'Input') {
				$logInput = Yii::app()->db->createCommand($inputQuery)->queryAll();
				echo '{"success": true, "data": ' . CJSON::encode($logInput) . '}';
			} else {
				$logPrint = Yii::app()->db->createCommand($printQuery)->queryAll();
				echo '{"success": true, "data": ' . CJSON::encode($logPrint) . '}';
			}
		}
        Yii::app()->end();
	}
	
	public function actionStatistik() {		
        /*$model = new Member('search');
        $model->unsetAttributes();
        if (isset($_GET['Member'])) {
            $model->attributes = $_GET['Member'];
        }
		
		$this->render('index',array(
			'model' => $model,
			'dataProvider' => $model->loadMember($filter,'A'),			
		));*/
		$this->render('statistik',array(
		));
	}
	
	public function actionStruktur() {
		$filter = "";
        if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new MemberPosition('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberPosition'])) {
            $model->attributes = $_GET['MemberPosition'];
        }
		
		$this->render('struktur',array(
			'model' => $model,
			//'dataProvider' => $model->loadMember($filter, 'A', array('pageSize' => 20)),			
		));
	}
	
	public function actionInfo() {		
		$this->layout = 'column2';
		$nik = Yii::app()->user->getState('nomerKTA');
		if (isset($_POST['cek_KTA'])) {
			$nik = $_POST['cek_KTA'];
		}
		$model = Member::model()->findByAttributes(array('membership_id' => $nik));
		if(count($model) == 0) {
			$model = Member::model()->findByAttributes(array('CARD_UID' => $nik));
		}
		if(count($model) == 0) {
			$this->redirect(Yii::app()->getHomeUrl());
		} else {
			$dokumen = MemberDoc::model()->findAllByAttributes(array('member_id'=>$model->id));
			$this->render('_info', array(
				'model' => $model,
				'dokumen' => $dokumen
			));
		}
	}
	
	public function actionMassPrint($id) {
		$admin = Users::model()->findByPk(Yii::app()->user->getUser("users_id"));		
		$this->renderPartial('_loadPrint', array(
            'model' => $this->loadModel($id),
			'admin' => $admin,
        ));
	}
	
	public function actionPrint($id) {
        $this->renderPartial('_cetak', array(
            'model' => $this->loadModel($id),
        ));
		Globals::AdminLogging("cetak","standalone",$id);
    }

    public function actionStatusPrint() {
        $id = $_POST['id'];

        $model = $this->loadModel($id);
        $model->last_print = new CDbExpression('NOW()');
        if ($model->save(false)) {
            Globals::AdminLogging("print","standalone",$id);
            echo '{"success": true,'
            . '"pesan": "Data Berhasil di Perbaharui"'
            . '}';
        }
    }

    public function actionProfil() {
        $this->redirect(Yii::app()->getHomeUrl());
    }

    public function actionSetUid() {
		$TagInput = $_POST['value'];
        $model = $this->loadModel($_POST['id']);
        $model->CARD_UID = $TagInput;
		$model->last_update = new CDbExpression('NOW()');
        if ($model->save(false)) {
			Globals::AdminLogging("update","set RFID serial",$_POST['id']);
			echo '{"value": "'.$TagInput.'"}';
        }
    }
	
	public function actionRevalidate() {
		$id = $_GET['id'];
		$find = Member::model()->findByPk($id);
		$cNum = Member::model()->countByAttributes(array('cellular_phone_number'=>$find->cellular_phone_number));
		if ($cNum == 1) {
			echo '{"success": true}';
		} else {
			echo '{"success": false}';
		}
	}

    public function actionTerima() {
        $id = $_GET['id'];
        $model = $this->loadModel($id);
        $model->member_status = 'A';
		$model->last_update = new CDbExpression('NOW()');
        if ($model->save(false)) { 
			Globals::AdminLogging("update","STATUS DITERIMA",$id);
        	$this->redirect(array('verifikasi'));
            echo '{"success": true,'
            . '"pesan": "Proses Penerimaan sebagai Anggota Berhasil"'
            . '}';
        }
    }

    public function actionTolak() {
        $id = $_GET['id'];
        $model = $this->loadModel($id);
        $model->member_status = 'B';
		$model->last_update = new CDbExpression('NOW()');
        if ($model->save(false)) { 
			Globals::AdminLogging("update","STATUS DITOLAK",$id);
        	$this->redirect(array('verifikasi'));
            echo '{"success": true,'
            . '"pesan": "Proses blokir sebagai Anggota Berhasil"'
            . '}';
        }
    }

	public function actionRegister() {
		$this->layout = 'column1';

		$model = new Member;
		$posisi = new MemberPosition;
		$dokumen = new MemberDoc;
		$this->performAjaxValidation($model);

		if(isset($_POST['Member'])) {
			$model->attributes=$_POST['Member'];
			if ($_POST['Member']['is_domisili'] != 'N') {
				$model->member_sub_district_id = $model->sub_district_id;
            }
			$model->membership_id = substr($model->member_sub_district_id, 0, 4) . Member::MemberNo($model->member_sub_district_id);
			$model->mobile_auth = md5($model->membership_id);
            $model->member_status = 'N';
			$model->registered_time = new CDbExpression('NOW()');
			$model->date_of_birth = Globals::dateMysql($_POST['Member']['date_of_birth']);
			if($model->save()) {
				if ($model->member_sub_district_id != NULL) {
					$getKordinat = "SELECT latitude,longitude FROM kelurahan WHERE id_kel = '" . $model->member_sub_district_id . "'";
					$cKordinat = Yii::app()->db->createCommand($getKordinat)->queryAll();
					foreach ($cKordinat AS $kordinat) {
						$lokasi = new Lokasi;
						$lokasi->member_id = $model->id;
						$lokasi->address_lat = $kordinat['latitude'];
						$lokasi->address_lon = $kordinat['longitude'];
						$lokasi->save();
					}
				}				
				$imagePath = Yii::app()->basePath . '/../assets/tmp/';
				$imageUrl = Yii::app()->request->baseUrl . '/assets/tmp/';
				$this->performAjaxValidation($posisi);
				if(isset($_POST['MemberPosition']) && $model->is_have_position == 'Y') {
					$posisi->attributes=$_POST['MemberPosition'];
					$posisi->member_id = $model->id;
					$posisi->status_position = 'UTAMA';
					if($posisi->save()) {
						if($model->is_other_position == 'Y') {
							$posisi2 = new MemberPosition;
							$posisi2->attributes=$_POST['MemberPosition'];
							$posisi2->member_id = $model->id;
							$posisi2->level = $_POST['level_lain'];
							$posisi2->position = $_POST['Posisi_lain'];
							$posisi2->position_as = $_POST['jabatan_lain'];
							$posisi2->status_position = 'KEDUA';
							$posisi2->save();
						}
					}
				}
				if ($_POST['identitas'] != "") {
					$iktp = new MemberIdentity;
					$this->performAjaxValidation($iktp);
					$imgUrlKtp = $_POST['identitas'];
					$imgUrlKtp = str_replace($imageUrl, $imagePath, $imgUrlKtp);
					$fpKtp = fopen($imgUrlKtp, 'r');
					$contentKtp = fread($fpKtp, filesize($imgUrlKtp));
					fclose($fpKtp);
					$iktp->member_id = $model->id;
					$iktp->img_photo = $contentKtp;
					if ($iktp->save()) {
						if ($_POST['identitas']!="") {unlink($imgUrlKtp);}
					}
				}
				if ($_POST['photo'] != "") {
					$iphoto = new MemberPhoto;
					$this->performAjaxValidation($iphoto);
					$imgUrlPhoto = $_POST['photo'];
					$imgUrlPhoto = str_replace($imageUrl, $imagePath, $imgUrlPhoto);
					$fpPhoto = fopen($imgUrlPhoto, 'r');
					$contentPhoto = fread($fpPhoto, filesize($imgUrlPhoto));
					fclose($fpPhoto);
					$iphoto->member_id = $model->id;
					$iphoto->img_photo = $contentPhoto;
					if ($iphoto->save()) {
						if ($_POST['photo']!="") {unlink($imgUrlPhoto);}
					}
				}
				Yii::app()->user->setState('nomerKTA', $model->membership_id);
                $this->redirect('info');
			}
		}

		$model->identity_number = $_GET['identity_number'];
        $model->member_name = $_GET['member_name'];
		$this->render('register',array('model'=>$model,'posisi'=>$posisi,'dokumen'=>$dokumen));
	}
	
	public function actionFrontKTA($id) {
		$model = $this->loadModel($id);
		$admin = Users::model()->findByPk(Yii::app()->user->getUser("users_id"));
		$imagePath = Yii::app()->basePath . '/../assets/';
		$template = UsersImg::model()->findByPk($admin->users_id);
		$foto = MemberPhoto::model()->findByPk($model->id);
		$image = imagecreatefromstring($template->template_dpn);
		$white = imagecolorallocate($image, 255, 255, 255);
		$font = $imagePath . 'font/roboto.ttf';
		$no_kta = "No. KTA"; $nama = "Nama"; $lahir = "Tempat/Tgl Lahir"; $alamat = "Alamat"; $tgl_cetak = "Tgl. Cetak: " . date('d-m-Y');
		imagettftext($image, 19, 0, 50, 250, $white, $font, $no_kta);
		imagettftext($image, 19, 0, 50, 290, $white, $font, $nama);
		imagettftext($image, 19, 0, 50, 330, $white, $font, $lahir);
		imagettftext($image, 19, 0, 50, 370, $white, $font, $alamat);
		imagettftext($image, 14, 0, 775, 438, $white, $font, $tgl_cetak);
		$no_rmh = $model->is_domisili == 'Y' ? $model->home_number : $model->member_home_number;
		$no_rt = $model->is_domisili == 'Y' ? $model->rt : $model->member_rt;
		$no_rw = $model->is_domisili == 'Y' ? $model->rw : $model->member_rw;
		$home_number = $no_rmh ? " NO. " . $no_rmh : "";
		$rt = $no_rt ? " RT. " . $no_rt : "";
		$rw = $no_rw ? " RW. " . $no_rw : "";
		$address = $model->is_domisili == 'Y' ? $model->address : $model->member_address;
		$address_raw = $address . $home_number . $rt . $rw . " Kel. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kel") . " Kec. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kec") . " " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab");
		imagettftext($image, 19, 0, 260, 250, $white, $font, ": " . $model->membership_id);
		imagettftext($image, 19, 0, 260, 290, $white, $font, strtoupper(": " . $model->member_name));
		imagettftext($image, 19, 0, 260, 330, $white, $font, strtoupper(": " . $model->birth_place . ", " . Globals::dateIndonesia($model->date_of_birth)));
		$address_1 = strtoupper(wordwrap($address_raw, 32, "\n"));
		imagettftext($image, 19, 0, 260, 370, $white, $font, ": ");
		imagettftext($image, 19, 0, 270, 370, $white, $font, $address_1);
		$photo = imagecreatefromstring($foto->img_photo);
		$marge_right = -15;
		$marge_bottom = 120;
		$sx = imagesx($photo);
		$sy = imagesy($photo);
		imagecopyresampled($image, $photo, 790, 210, 0, 0, 165, 198, imagesx($photo), imagesy($photo));
		imagepng($image, $imagePath . 'tmp/' . $model->membership_id . '_front.png');
		$imgKTA = MemberCard::model()->findByPk($model->id);
		if (!$imgKTA) {
			$imgKTA = new MemberCard;
		} $blobKTA = "";
		$filename = $imagePath . 'tmp/' . $model->membership_id . '_front.png';
		$handle = fopen($filename, "rb");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		$imgKTA->img_photo = $contents;
		if ($imgKTA->save()) {
			unlink($imagePath . 'tmp/' . $model->membership_id . '_front.png');
		}
		header('Content-Type: ' . $imgKTA->photo_type);
		print $imgKTA->img_photo;
		imagedestroy($image);
		exit();
	}
	
	public function actionBackKTA($id) {
		$model = $this->loadModel($id);
		$admin = Users::model()->findByPk(Yii::app()->user->getUser("users_id"));
		$imagePath = Yii::app()->basePath . '/../assets/';
		$template = UsersImg::model()->findByPk($admin->users_id);
		$image = imagecreatefromstring($template->template_blk);
		$bc_src = imagecreatetruecolor(290, 70);
		$putih = ImageColorAllocate($bc_src,0xff,0xff,0xff);
		$hitam = ImageColorAllocate($bc_src,0x00,0x00,0x00);
		$rotation = 0; //Rotasi Barcode
		imagefilledrectangle($bc_src, 0, 0, 290, 70, $putih);
		$data = Globals::gd($bc_src, $hitam, 145, 35, $rotation, 'code128', array('code'=>$model->membership_id), 3, 65);
		if (imagejpeg($bc_src, $imagePath . 'tmp/bc_' . $model->membership_id . '.source', 100)) {
			imagedestroy($bc_src);
			$barcode = imagecreatefromjpeg($imagePath . 'tmp/bc_' . $model->membership_id . '.source');	
		}
		$dstX = imagesx($image) - imagesx($barcode) - 230;
		$dstY = imagesy($image) - imagesy($barcode) - 10;
		imagecopymerge($image, $barcode, $dstX, $dstY, 0, 0, 290, 70, 100);
		header('Content-Type: image/png');
		imagepng($image);
		imagedestroy($image);
		exit();
	}

    public function actionCetak($id) {
		$admin = Users::model()->findByPk(Yii::app()->user->getUser("users_id"));		
        $this->renderPartial('_print', array(
            'model' => $this->loadModel($id),
			'admin' => $admin,
        ));
    }

    public function actionreadKTP() {		
        header('Access-Control-Allow-Origin: *');
        $nik = $_POST['nik'];
        if (strlen($nik) != 16) {
            echo '{"success": false,"pesan": "Panjang NIK harus 16 angka. Input Anda = ' . strlen($nik) . ' angka."}';
            return;
        } else {
            $data = array();
            $data['provinsi'] = substr($nik, 0, 2);
            $data['kota'] = substr($nik, 2, 2);
            $data['kecamatan'] = substr($nik, 4, 2);
            $data['tanggal_lahir'] = substr($nik, 6, 2);
            $data['bulan_lahir'] = substr($nik, 8, 2);
            $data['tahun_lahir'] = (substr($nik, 10, 1) == 0 ? "20" : "19") . substr($nik, 10, 2);
            $data['unik'] = substr($nik, 12, 4);
            if (intval($data['tanggal_lahir']) > 40) {
                $data['tanggal_lahir'] = intval($data['tanggal_lahir']) - 40;
                $gender = 'P';
            } else {
                $data['tanggal_lahir'] = intval($data['tanggal_lahir']);
                $gender = 'L';
            }

            echo '{"success": true,'
            . '"pesan": "Panjang NIK harus 16 angka. Input Anda = ' . strlen($nik) . ' angka.",'
            . '"provinsi": "' . $data['provinsi'] . '",'
            . '"kota": "' . $data['kota'] . '",'
            . '"kecamatan": "' . $data['kecamatan'] . '",'
            . '"tanggal_lahir": "' . $data['tanggal_lahir'] . '",'
            . '"bulan_lahir": "' . $data['bulan_lahir'] . '",'
            . '"tahun_lahir": "' . $data['tahun_lahir'] . '",'
            . '"unik": "' . $data['unik'] . '",'
            . '"jk": "' . $gender . '"'
            . '}';
        }
    }

    public function actionuploadImage() {	
        $imagePath = Yii::app()->basePath . '/../assets/tmp/';
        $imageUrl = Yii::app()->request->baseUrl . '/assets/tmp/';
        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
        $temp = explode(".", $_FILES["img"]["name"]);
        $extension = end($temp);
        if (!is_writable($imagePath)) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            print json_encode($response);
            return;
        }
        if (in_array($extension, $allowedExts)) {
            if ($_FILES["img"]["error"] > 0) {
                $response = array(
                    "status" => 'error',
                    "message" => 'ERROR Return Code: ' . $_FILES["img"]["error"],
                );
            } else {

                $filename = $_FILES["img"]["tmp_name"];
                list($width, $height) = getimagesize($filename);
                move_uploaded_file($filename, $imagePath . $_FILES["img"]["name"]);
                $response = array(
                    "status" => 'success',
                    "url" => $imageUrl . $_FILES["img"]["name"],
                    "width" => $width,
                    "height" => $height
                );
            }
        } else {
            $response = array(
                "status" => 'error',
                "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
            );
        }

        print json_encode($response);
    }
	
	public function actioncropImage() {
        $imgUrl = $_POST['imgUrl'];
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
        $cropW = $_POST['cropW'];
        $cropH = $_POST['cropH'];
        $angle = $_POST['rotation'];
        $jpeg_quality = 100;
        $imagePath = Yii::app()->basePath . '/../assets/tmp/';
        $imageUrl = Yii::app()->request->baseUrl . '/assets/tmp/';
        $output_filename = Yii::app()->basePath . '/../assets/tmp/croppedImg_' . rand();
        $imgUrl = str_replace($imageUrl, $imagePath, $imgUrl);
        $what = getimagesize($imgUrl);
        switch (strtolower($what['mime'])) {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                header('Content-Type: image/jpeg');
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }
        if (!is_writable(dirname($output_filename))) {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        } else {
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            imagejpeg($final_image, $output_filename . $type, $jpeg_quality);
            $response = Array(
                "status" => 'success',
                "url" => $output_filename . $type
            );
        }
        unlink($imgUrl);
        $response = str_replace($imagePath, $imageUrl, $response);
        print json_encode($response);
    }
	
	public function actionloadPhoto($id) {
		$model = MemberPhoto::model()->findByPk($id);
        header('Content-Type:'. $model->photo_type);
		print $model->img_photo;
		exit();
    }
	
	public function actionloadKtp($id) {
		$model = MemberIdentity::model()->findByPk($id);
        header('Content-Type:'. $model->photo_type);
		print $model->img_photo;
		exit();
    }
	
	public function actionloadKta($id) {
		$model = MemberCard::model()->findByPk($id);
        header('Content-Type:'. $model->photo_type);
		print $model->img_photo;
		exit();
    }
	
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id)
		));
	}
	
	public function actionUnverified($id) {
		$this->render('unverified',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionReference() {
		$res = array();
        if (isset($_GET['term'])) {
            $sql = 'SELECT concat(membership_id,"      ( ",UPPER(member_name)," )") as label, membership_id as value FROM member ';
            $sql = $sql . ' WHERE membership_id LIKE :label limit 3'; // Must be at least 1
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":label", '%' . $_GET['term'] . '%', PDO::PARAM_STR);
            echo json_encode($command->queryAll());
        }
	}
	
	public function actionTambah() {
		$model = new Member;
		$posisi = new MemberPosition;
		$dokumen = new MemberDoc;
		$this->performAjaxValidation($model);

		if(isset($_POST['Member'])) {
			$model->attributes=$_POST['Member'];
			$model->is_domisili = $_POST['is_domisili'] != 'N' ? 'Y' : 'N' ;
			$model->is_have_position = $_POST['is_have_position'];
			$model->is_other_position = $_POST['is_other_position'];
			$model->registered_time = new CDbExpression('NOW()');
			if ($_POST['is_domisili'] != 'N') {
				$model->member_sub_district_id = $model->sub_district_id;
            }
			$model->membership_id = substr($model->member_sub_district_id, 0, 4) . Member::MemberNo($model->member_sub_district_id);
			$model->mobile_auth = md5($model->membership_id);
			$model->date_of_birth = Globals::dateMysql($_POST['Member']['date_of_birth']);
			if($model->save()) {
				Globals::AdminLogging("insert","TAMBAH KADER",$model->id);
				if ($model->member_sub_district_id != NULL) {
					$getKordinat = "SELECT latitude,longitude FROM kelurahan WHERE id_kel = '" . $model->member_sub_district_id . "'";
					$cKordinat = Yii::app()->db->createCommand($getKordinat)->queryAll();
					foreach ($cKordinat AS $kordinat) {
						$lokasi = new Lokasi;
						$lokasi->member_id = $model->id;
						$lokasi->address_lat = $kordinat['latitude'];
						$lokasi->address_lon = $kordinat['longitude'];
						$lokasi->save();
					}
				}
				$this->performAjaxValidation($posisi);
				if(isset($_POST['MemberPosition']) && $model->is_have_position == 'Y') {
					$posisi->attributes=$_POST['MemberPosition'];
					$posisi->member_id = $model->id;
					$posisi->status_position = 'UTAMA';
					if($posisi->save()) {
						if($model->is_other_position == 'Y') {
							$posisi2 = new MemberPosition;
							$posisi2->attributes=$_POST['MemberPosition'];
							$posisi2->member_id = $model->id;
							$posisi2->level = $_POST['level_lain'];
							$posisi2->position = $_POST['Posisi_lain'];
							$posisi2->position_as = $_POST['jabatan_lain'];
							$posisi2->status_position = 'KEDUA';
							$posisi2->save();
						}
					}
				}
				if ($_POST['postIdentitas'] != "") {
					$iktp = new MemberIdentity;
					$this->performAjaxValidation($iktp);
					$imgUrlKtp = $_POST['postIdentitas'];
					$fpKtp = fopen($imgUrlKtp, 'rb');
					$contentKtp = stream_get_contents($fpKtp);
					fclose($fpKtp);
					$iktp->member_id = $model->id;
					$iktp->img_photo = $contentKtp;
					$iktp->save();
				}
				if ($_POST['postPhoto'] != "") {
					$iphoto = new MemberPhoto;
					$this->performAjaxValidation($iphoto);
					$imgUrlPhoto = $_POST['postPhoto'];
					$fpPhoto = fopen($imgUrlPhoto, 'rb');
					$contentPhoto = stream_get_contents($fpPhoto);
					fclose($fpPhoto);
					$iphoto->member_id = $model->id;
					$iphoto->img_photo = $contentPhoto;
					$iphoto->save();
				}
				if (Yii::app()->user->getAkses("2", "2") == true || Yii::app()->user->isSuperadmin()) {
					$this->redirect(array('view','id'=>$model->id));
				} else {
					$this->redirect(array('tambah'));
				}
			}
		}
		
		$this->render('create',array('model'=>$model,'posisi'=>$posisi,'dokumen'=>$dokumen));
	}
	
	public function actionUbah($id) {
		$model=$this->loadModel($id); 
		$posisi = MemberPosition::model()->findByAttributes(array('member_id'=>$id,'status_position'=>'UTAMA'));
		if ($posisi == NULL) {
			$posisi = new MemberPosition;
		}
		$dokumen = MemberDoc::model()->findByAttributes(array('member_id'=>$id));
		if ($dokumen == NULL) {
			$dokumen = new MemberDoc;
		}
		$this->performAjaxValidation($model);
		if(isset($_POST['Member'])) {
			$model->attributes=$_POST['Member'];
			$model->is_domisili = $_POST['is_domisili'] != 'N' ? 'Y' : 'N';
			$model->is_have_position = $_POST['is_have_position'];
			$model->is_other_position = $_POST['is_other_position'];
			if ($_POST['is_domisili'] != 'N') {
				$model->member_sub_district_id = $model->sub_district_id;
            }
			$model->last_update = new CDbExpression('NOW()');
			$model->date_of_birth = Globals::dateMysql($_POST['Member']['date_of_birth']);
			if($model->save()) {
				Globals::AdminLogging("update","UBAH DATA KADER",$model->id);
				$this->performAjaxValidation($posisi);
				if(isset($_POST['MemberPosition']) && $model->is_have_position == 'Y') {
					$posisi->attributes=$_POST['MemberPosition'];
					$posisi->member_id = $model->id;
					$posisi->status_position = 'UTAMA';
					if($posisi->save()) {
						if($model->is_other_position == 'Y') {
							$posisi2 = MemberPosition::model()->findByAttributes(array('member_id'=>$id,'status_position'=>'KEDUA'));
							if ($posisi2 == NULL) {
								$posisi2 = new MemberPosition;
							}
							$posisi2->attributes=$_POST['MemberPosition'];
							$posisi2->level = $_POST['level_lain'];
							$posisi2->position = $_POST['Posisi_lain'];
							$posisi2->position_as = $_POST['jabatan_lain'];
							$posisi2->status_position = 'KEDUA';							
							$posisi2->save();
						}
					}
				}
				if ($_POST['postIdentitas'] != "") {
					$iktp = MemberIdentity::model()->findByPk($id);
					if ($iktp == NULL) {
						$iktp = new MemberIdentity;
					}
					$this->performAjaxValidation($iktp);
					$imgUrlKtp = $_POST['postIdentitas'];
					$fpKtp = fopen($imgUrlKtp, 'rb');
					$contentKtp = stream_get_contents($fpKtp);
					fclose($fpKtp);
					$iktp->member_id = $model->id;
					$iktp->img_photo = $contentKtp;
					$iktp->save();
				}
				if ($_POST['postPhoto'] != "") {
					$iphoto = MemberPhoto::model()->findByPk($id);
					if ($iphoto == NULL) {
						$iphoto = new MemberPhoto;
					}
					$this->performAjaxValidation($iphoto);
					$imgUrlPhoto = $_POST['postPhoto'];
					$fpPhoto = fopen($imgUrlPhoto, 'rb');
					$contentPhoto = stream_get_contents($fpPhoto);
					fclose($fpPhoto);
					$iphoto->member_id = $model->id;
					$iphoto->img_photo = $contentPhoto;
					$iphoto->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

        $model->date_of_birth = Globals::dateRevMysql($model->date_of_birth);
		$this->render('update',array(
			'model'=>$model,'posisi'=>$posisi,'dokumen'=>$dokumen
		));
	}
	
	public function actionHapus($id) {
		$dMember = $this->loadModel($id);
		if ($dMember->delete()) {			
			Globals::AdminLogging("delete","HAPUS KADE",$id);
			$dPosisi = MemberPosition::model()->findByAttributes(array('member_id'=>$id,'status_position'=>'UTAMA'));
			if ($dPosisi == NULL) {
				$dDokumen = MemberDoc::model()->findByAttributes(array('member_id'=>$id));
				if ($dDokumen == NULL) {
					$dPosisi2 = MemberPosition::model()->findByAttributes(array('member_id'=>$id,'status_position'=>'KEDUA'));
					if ($dPosisi2 == NULL) {
						$dKTP = MemberIdentity::model()->findByPk($id);
						if ($dKTP == NULL) {
							$dFoto = MemberPhoto::model()->findByPk($id);
							if ($dFoto == NULL) {
								//All Done !
							} else {
								$dFoto->delete();
							}
						} else {
							$dKTP->delete();
						}
					} else {
						$dPosisi2->delete();
					}
				} else {
					$dDokumen->delete();
				}
			} else {
				$dPosisi->delete();
			}
		}
		
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionIndex() {
		$filter = "";
        if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new Member('search');
        $model->unsetAttributes();
        if (isset($_GET['Member'])) {
            $model->attributes = $_GET['Member'];
        }
		
		$this->render('index',array(
			'model' => $model,
			'dataProvider' => $model->loadMember($filter, 'A', array('pageSize' => 20)),			
		));
	}
	
	public function actionVerifikasi() {
		$filter = "";
        if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new Member('search');
        $model->unsetAttributes();
        if (isset($_GET['Member'])) {
            $model->attributes = $_GET['Member'];
        }
		
		$this->render('verifikasi',array(
			'model' => $model,
			'dataProvider' => $model->loadMember($filter,'N', array('pageSize' => 20)),			
		));
	}	
	
	public function actionBlokir() {
		$filter = "";
        if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new Member('search');
        $model->unsetAttributes();
        if (isset($_GET['Member'])) {
            $model->attributes = $_GET['Member'];
        }
		
		$this->render('verifikasi',array(
			'model' => $model,
			'dataProvider' => $model->loadMember($filter,'B'),			
		));
	}	
	
	public function actionLoadAdmin() {
        $filter = "";
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $sql = "SELECT '' as users_id,'--PILIH ADMIN--' as username UNION ALL "
                . "SELECT users_id,username FROM users WHERE username!='superadmin' $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['users_id']), CHtml::encode(strtoupper($row['username'])), true);
        }
    }
	
	public function loadModel($id) {
		$model=Member::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='member-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

