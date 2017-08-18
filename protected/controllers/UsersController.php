<?php
class UsersController extends Controller {
	public $layout='//layouts/table12';	
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}	
	public function accessRules() {
		return array(
			array('allow','actions'=>array('login','ubahpwd'),'users'=>array('*'),),
			array('allow','actions'=>array('index','profil','loadPhoto','uploadImage','cropImage','cropTemplate','loadKtadpn','loadKtablk'),
				'expression' => '$user->getAkses(\'34\',\'1\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('tambah'),
				'expression' => '$user->getAkses(\'37\',\'1\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('ubah'),
				'expression' => '$user->getAkses(\'35\',\'1\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('hapus'),
				'expression' => '$user->getAkses(\'36\',\'1\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('cetak','loadKader','generateBarcode','cetakA4DPN','cetakA4BLK','loadKtadpn','loadKtablk','statusPrint'),
				'expression' => '$user->getAkses(\'38\',\'19\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('logout','chat'),'users'=>array('@'),),
			array('deny','users'=>array('*'),),
		);
	}	
	public function actionGenerateBarcode($id) { // Tidak digunakan untuk saat ini !
		$location = Yii::app()->basePath . '/../assets/tmp/bc_'.$id.'.source';
		$fontSize = 10;   // GD1 in px ; GD2 in point
		$marge    = 50;   // between barcode and hri in pixel
		$x        = 145;  // barcode center
		$y        = 35;  // barcode center
		$height   = 65;   // barcode height in 1D ; module size in 2D
		$width    = 3;    // barcode height in 1D ; not use in 2D
		$angle    = 0;   // rotation in degrees
		$im     = imagecreatetruecolor(290, 70);
		$white  = ImageColorAllocate($im,0xff,0xff,0xff);
		$black  = ImageColorAllocate($im,0x00,0x00,0x00);
		imagefilledrectangle($im, 0, 0, 290, 70, $white);
		$data = Globals::gd($im, $black, 145, $y, 0, 'code128', array('code'=>$id), $width, $height);
		header('Content-type: image/jpeg');
		imagejpeg($im, $location, 100);
		imagedestroy($im);
	}	
	public function actionCetakA4DPN($idkta) {
		$cSql = "SELECT mb.id, mb.membership_id, mb.member_name FROM member mb"
			. " INNER JOIN kelurahan kl ON kl.id_kel=mb.member_sub_district_id"
			. " INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec"
			. " INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab"
			. " INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov"
			. " WHERE mb.id IN ({$idkta})";
		$rows = Yii::app()->db->createCommand($cSql)->queryAll();
		$this->renderPartial('_cetakA4DPN',array(
			'model' => $rows
		));
	}	
	public function actionCetakA4BLK($idkta) {
		$cSql = "SELECT mb.id, mb.membership_id, mb.member_name FROM member mb"
			. " INNER JOIN kelurahan kl ON kl.id_kel=mb.member_sub_district_id"
			. " INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec"
			. " INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab"
			. " INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov"
			. " WHERE mb.id IN ({$idkta})";
		$rows = Yii::app()->db->createCommand($cSql)->queryAll();
		$this->renderPartial('_cetakA4BLK',array(
			'model' => $rows
		));
	}	
	public function actionStatusPrint() {
		$id = $_POST['id'];
        $model = Member::model()->findByPk($id);
        $model->last_print = new CDbExpression('NOW()');
        if ($model->save(false)) {
            Globals::AdminLogging("print","massal",$id);
            echo '{"success": true,'
            . '"pesan": "Data Berhasil di Perbaharui"'
            . '}';
        }
	}	
	public function actionLoadKader() {
		$filter = ""; $lookup = "";
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
		$sql = "SELECT mb.id, mb.member_name as text FROM member mb "
			 . "INNER JOIN kelurahan kl ON kl.id_kel=mb.member_sub_district_id "
			 . "INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec "
			 . "INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab "
			 . "INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov "
			 . "INNER JOIN member_photo mp ON mp.member_id=mb.id "
			 . "WHERE mb.membership_id IS NOT NULL AND mb.member_status='A' AND mb.last_print IS NULL AND mb.member_name LIKE '%$lookup%' $filter";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "kader": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}	
	public function actionCetak() {
		$this->render('cetak');
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
    public function actioncropTemplate() {
        $imgUrl = $_POST['imgUrl'];
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
        $imgW = $_POST['imgInitW'];
        $imgH = $_POST['imgInitH'];
        $cropW = $_POST['imgInitW'];
        $cropH = $_POST['imgInitH'];
        $imgY1 = $_POST['imgY1'];
        $imgX1 = $_POST['imgX1'];
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
            imagecolortransparent($cropped_rotated_image, imagecolorallocatealpha($cropped_rotated_image, 0, 0, 0, 127));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocatealpha($final_image, 0, 0, 0, 127));
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
	public function actionloadKtadpn($id) {
		$model = UsersImg::model()->findByPk($id);
        header('Content-Type:'. $model->tdpn_type);
		print $model->template_dpn;
		exit();
    }	
	public function actionloadKtablk($id) {
		$model = UsersImg::model()->findByPk($id);
        header('Content-Type:'. $model->tblk_type);
		print $model->template_blk;
		exit();
    }	
	public function actionloadPhoto($id) {
		$model = UsersImg::model()->findByPk($id);
        header('Content-Type:'. $model->photo_type);
		print $model->img_photo;
		exit();
    }	
	public function actionProfil($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}	
	public function actionTambah() {
		$model=new Users;
		$this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->created = new CDbExpression('NOW()');
			$model->kader_id = Member::model()->findByAttributes(array('membership_id'=>$model->member_id))->id;
            $model->password = md5($model->password);
            $model->parent = Yii::app()->user->id;
			$model->repeat_password = md5($model->repeat_password);
			if($model->save()) {
				if ($model->role_id <> '1') {
					if (isset($_POST['privileges']) && count($_POST['privileges']) > 0) {
						$aksesId = implode(",", $_POST['privileges']);
						$getAkses = "SELECT akses_id,menu_id FROM users_akses WHERE akses_id IN ($aksesId)";
						$menuId = Yii::app()->db->createCommand($getAkses)->queryAll();
						foreach ($menuId as $akses) {
							$hakAkses = new UsersGranted;
							$hakAkses->users_id = $model->users_id;
							$hakAkses->menu_id = $akses['menu_id'];
							$hakAkses->by_users = Yii::app()->user->getuser('users_id');
							$hakAkses->akses_id	= $akses['akses_id'];
							$hakAkses->save(false);				
						}
					}
				}
				$imagePath = Yii::app()->basePath . '/../assets/tmp/';
				$imageUrl = Yii::app()->request->baseUrl . '/assets/tmp/';
				$imgPost = new UsersImg;
				$imgPost->users_id = $model->users_id;
				/*if ($_POST['photo'] != "") {
					$imgUrlPhoto = $_POST['photo'];
					$imgUrlPhoto = str_replace($imageUrl, $imagePath, $imgUrlPhoto);
					$fpPhoto = fopen($imgUrlPhoto, 'r');
					$contentPhoto = fread($fpPhoto, filesize($imgUrlPhoto));
					//$contentPhoto = addslashes($contentphoto);
					fclose($fpPhoto);
					$imgPost->img_photo = $contentPhoto;
				}*/
				if ($_POST['KtaDPN'] != "") {
					$imgUrlTempDPN = $_POST['KtaDPN'];
					$imgUrlTempDPN = str_replace($imageUrl, $imagePath, $imgUrlTempDPN);
					$fpKtaDPN = fopen($imgUrlTempDPN, 'r');
					$contentTempDPN = fread($fpKtaDPN, filesize($imgUrlTempDPN));
					fclose($fpKtaDPN);
					$imgPost->template_dpn = $contentTempDPN;
				}
				if ($_POST['KtaBLK'] != "") {
					$imgUrlTempBLK = $_POST['KtaBLK'];
					$imgUrlTempBLK = str_replace($imageUrl, $imagePath, $imgUrlTempBLK);
					$fpKtaBLK = fopen($imgUrlTempBLK, 'r');
					$contentTempBLK = fread($fpKtaBLK, filesize($imgUrlTempBLK));
					fclose($fpKtaBLK);
					$imgPost->template_blk = $contentTempBLK;
				}
				if ($imgPost->save()) {
					//if ($_POST['photo'] != "") {unlink($imgUrlPhoto);}
					if ($_POST['KtaDPN']!="") {unlink($imgUrlTempDPN);}
					if ($_POST['KtaBLK']!="") {unlink($imgUrlTempBLK);}
				$this->redirect(array('profil','id'=>$model->users_id));
				}
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}
    public function actionUbahPwd() {
        $model = $this->loadModel(Yii::app()->user->id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->password = md5($model->password);
            if ($model->save()) {
                //Globals::AdminLogging("change password:users:" . Yii::app()->user->id . "");
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('changepassword', array(
            'model' => $model,
        ));
    }	
	public function actionUbah($id) {
		//ini_set('memory_limit', '2048M');		
		//ini_set('max_execution_time', '180000');
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
			$model->kader_id = Member::model()->findByAttributes(array('membership_id'=>$model->member_id))->id;			
			if($model->save()) {
				if ($model->role_id <> '1') {
					if (isset($_POST['privileges']) && count($_POST['privileges']) > 0) {
						$aksesId = implode(",", $_POST['privileges']);
						$getAkses = "SELECT akses_id,menu_id FROM users_akses WHERE akses_id IN ($aksesId) AND akses_id NOT IN (SELECT akses_id FROM users_granted WHERE users_id='$model->users_id')";
						$menuId = Yii::app()->db->createCommand($getAkses)->queryAll();
						foreach ($menuId as $akses) {
							$menu = $akses['menu_id']; $admin = Yii::app()->user->getuser('users_id');
							$akses = implode(array($akses['akses_id'])); $count = count($akses); $i=0;
							while ($i<$count) {
								$sql="insert into users_granted (users_id,menu_id,by_users,akses_id) values ('{$model->users_id}','{$menu}','{$admin}','{$akses}')";
								$run[$i] = Yii::app()->db->createCommand($sql)->execute(); $i++;
							}				
						}
						$remAkses = "DELETE FROM users_granted WHERE akses_id NOT IN ($aksesId) AND users_id='$model->users_id'";
						Yii::app()->db->createCommand($remAkses)->execute();
					} else if (!isset($_POST['privileges']) || count($_POST['privileges']) < 0) {
						$flushAkses = "DELETE FROM users_granted WHERE users_id='$model->users_id'";
						Yii::app()->db->createCommand($flushAkses)->execute();
					}
				}
				$imagePath = Yii::app()->basePath . '/../assets/tmp/';
				$imageUrl = Yii::app()->request->baseUrl . '/assets/tmp/';
				$imgPost = $this->loadModelImg($id);
				$imgPost->users_id = $model->users_id;
				if ($_POST['KtaDPN'] != "") {
					$imgUrlTempDPN = $_POST['KtaDPN'];
					$imgUrlTempDPN = str_replace($imageUrl, $imagePath, $imgUrlTempDPN);
					$fpKtaDPN = fopen($imgUrlTempDPN, 'r');
					$contentTempDPN = fread($fpKtaDPN, filesize($imgUrlTempDPN));
					fclose($fpKtaDPN);
					$imgPost->template_dpn = $contentTempDPN;
				}
				if ($_POST['KtaBLK'] != "") {
					$imgUrlTempBLK = $_POST['KtaBLK'];
					$imgUrlTempBLK = str_replace($imageUrl, $imagePath, $imgUrlTempBLK);
					$fpKtaBLK = fopen($imgUrlTempBLK, 'r');
					$contentTempBLK = fread($fpKtaBLK, filesize($imgUrlTempBLK));
					fclose($fpKtaBLK);
					$imgPost->template_blk = $contentTempBLK;
				}
				if ($imgPost->save()) {
					if ($_POST['KtaDPN']!="") {unlink($imgUrlTempDPN);}
					if ($_POST['KtaBLK']!="") {unlink($imgUrlTempBLK);}
				$this->redirect(array('profil','id'=>$model->users_id));
				}
			}	
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}	
	public function loadModelImg($id) {
        $model = UsersImg::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }	
	public function actionHapus($id) {
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
    public function actionIndex() {
		$filter = "";
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND t.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND t.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND t.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $criteria = new CDbCriteria();
        $criteria->select = 't.*,tp.nama as prov_nama,tc.nama as kab_nama,tm.nama as kec_nama,tr.role,up.img_photo';
        $criteria->join .= ' LEFT JOIN kecamatan tm ON tm.id_kec=t.id_kec';
        $criteria->join .= ' LEFT JOIN kabupaten tc ON tc.id_kab=t.id_kab';
        $criteria->join .= ' LEFT JOIN provinsi tp ON tp.id_prov=t.id_prov';
        $criteria->join .= ' LEFT JOIN users_role tr ON tr.id=t.role_id';
		$criteria->join .= ' LEFT JOIN users_img up ON up.users_id=t.users_id';
		$criteria->condition = "t.users_id>='7' AND t.users_id != '".Yii::app()->user->getuser('users_id')."' $filter";

        $dataProvider = new CActiveDataProvider('Users', array('criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
            'sort' => array(
				'defaultOrder' => 'status DESC,users_id DESC',
            ),));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => $model
        ));
    }	
	public function actionChat() {
		$filter = "";
		$cQuery = "SELECT t.* FROM users t WHERE users_id!='" . Yii::app()->user->getUser('users_id'). "' AND kader_id!='1' $filter ORDER BY signed ASC, users_id DESC";
		$hasil = Yii::app()->db->createCommand($cQuery)->queryAll();
		foreach ($hasil as $data) {
			echo '<li class="user-row" id="chat_user_' . $data['users_id'] . '" data-user-id="' . $data['users_id'] . '">';
			echo '<div class="user-img">';
			echo '<a href="#"><img src="'. Yii::app()->controller->createUrl('member/loadPhoto', array('id' => $data['kader_id'])).'" alt=""></a>';
			echo '</div>';
			echo '<div class="user-info">';
			echo '<h4><a href="#">' . $data['username'] . '</a></h4>';
			echo '<span class="status ' . $data['signed'] . '" data-status="' . $data['signed'] . '"> ' . $data['signed'] . '</span>';
			echo '</div>';
			echo '<div class="user-status ' . $data['signed'] . '">';
			echo '<i class="fa fa-circle"></i>';
			echo '</div>';
			echo '</li>';
		}
	}	
	public function loadModel($id) {
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
    public function actionLogin() {      
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
				/*if(!Yii::app()->user->id=="superadmin")
					Yii::app()->user->authTimeout=100;
					Yii::app()->user->setState(CWebUser::AUTH_TIMEOUT_VAR,time()+Yii::app()->user->authTimeout);*/
				
                $this->redirect(Yii::app()->user->returnUrl);
			}
        }
		if (Yii::app()->user->isAdmin()) {
			$this->redirect(Yii::app()->homeUrl);
		} else {
			$this->layout = 'guest';
			$this->renderPartial('login', array('model' => $model));
		}
    }	
	public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}