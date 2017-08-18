<?php

class GaleriController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}
	
	public function accessRules() {
		return array(
            array('allow',
                'actions' => array('loadalbum', 'loadimg'),
                'users' => array('*'),
            ),
			array('allow','actions'=>array('index','view','create','delete','insert'),
				'expression' => '$user->isSuperadmin()','users'=>array('@'),),
			array('deny', 'users'=>array('*'),),
		);
	}

	public function actionloadImg($id) {
		$model = SiteGalery::model()->findbyPk($id);
		header('Content-Type: jpeg');
		print $model->images;
		exit();
	}

	public function actionloadAlbum($id) {
		$path = Yii::app()->basePath . '/../assets/tmp/';
		$sqlsvr = "select * from galery where album='" . $id . "'";
		$rowssvr = Yii::app()->db->createCommand($sqlsvr)->queryAll();
		foreach ($rowssvr as $rowsvr) {
			$file = $rowsvr['keterangan'];
			$obj['name'] = $file; //get the filename in array
			$obj['id'] = $rowsvr['galeri_id']; //get the filename in array
			$obj['size'] = strlen($rowsvr['images']); //filesize($path . $file); //get the flesize in array
			$result[] = $obj; // copy it to another array
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function actionInsert() {
	        if (!empty($_FILES)) {
	            $random = rand(0, 99999999999);

	            $tempFile = $_FILES['file']['tmp_name'];

	            $targetPath = Yii::app()->basePath . '/../assets/tmp/';
	            $file_name = $random . '_' . str_replace(' ', '_', $_FILES['file']['name']);
	            $targetFile = $targetPath . $file_name;


	            if (move_uploaded_file($tempFile, $targetFile)) {
	                $afterresize = $this->resize(960, $targetFile, $targetFile);
	                $upload = new SiteGalery;
	                $upload->keterangan = $file_name;
	                $upload->admin = Yii::app()->user->getuser('users_id');
	                $upload->tgl_upload = new CDbExpression('NOW()');

	                $fpPhoto = fopen($afterresize, 'r');
	                $contentphoto = fread($fpPhoto, filesize($targetFile));
	                // $contentphoto = addslashes($contentphoto);
	                fclose($fpPhoto);
	                $upload->images = $contentphoto;
	              
	                $upload->save();
	                echo $upload->getPrimaryKey();
	            }
	        }
	}

	function resize($newWidth, $targetFile, $originalFile) {

	        $info = getimagesize($originalFile);
	        $mime = $info['mime'];

	        switch ($mime) {
	            case 'image/jpeg':
	                $image_create_func = 'imagecreatefromjpeg';
	                $image_save_func = 'imagejpeg';
	                $new_image_ext = 'jpg';
	                break;

	            case 'image/png':
	                $image_create_func = 'imagecreatefrompng';
	                $image_save_func = 'imagepng';
	                $new_image_ext = 'png';
	                break;

	            case 'image/gif':
	                $image_create_func = 'imagecreatefromgif';
	                $image_save_func = 'imagegif';
	                $new_image_ext = 'gif';
	                break;

	            default:
	                return $targetFile . ".jpg";
	        }

	        $img = $image_create_func($originalFile);
	        list($width, $height) = getimagesize($originalFile);

	        $newHeight = ($height / $width) * $newWidth;
	        $tmp = imagecreatetruecolor($newWidth, $newHeight);
	        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

	        if (file_exists($targetFile)) {
	            unlink($targetFile);
	        }
	        $image_save_func($tmp, "$targetFile");
	        // move_uploaded_file($tmp, $targetFile . $new_image_ext);
	        return $targetFile;
	}
	
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionDelete($id) {
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionIndex() {
		$model=new SiteAlbum;
		$this->performAjaxValidation($model);
		if(isset($_POST['SiteAlbum'])) {
			$model->attributes=$_POST['SiteAlbum'];
			$model->tgl_dibuat = new CDbExpression('NOW()'); var_dump($_POST['uploadId']); exit;
			if($model->save()) {
				$ids = $_POST['uploadId'];
				if (substr($ids, 1, 1) == ",") {
				    $ids = substr($ids, 1);
				}
				if (substr($string, 0, -1) == ",") {
				    $ids = substr($string, 0, -1);
				}
				$ids = rtrim($ids, ","); var_dump($ids);
				$sql = "update site_galery set `album`='" . $model->getPrimaryKey() . "' where id in ($ids)";
				Yii::app()->db->createCommand($sql)->execute();

				$sql = "delete from  site_galery where `album`='" . $model->getPrimaryKey() . "' and id not in ($ids)";
				Yii::app()->db->createCommand($sql)->execute(); exit();
				$this->redirect(array('index'));
			}
		}
		
		$dataProvider=new CActiveDataProvider('SiteGalery');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}
	
	public function loadModel($id) {
		$model=SiteGalery::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='site-galery-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
