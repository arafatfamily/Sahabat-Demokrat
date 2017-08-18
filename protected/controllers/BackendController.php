<?php
class BackEndController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}	
	public function accessRules() {
		return array(
			array('allow','actions'=>array('loadImgSite'),'users'=>array('*'),),
			array('allow','actions'=>array('index','update','bantuan'),
				'expression' => '$user->getAkses(\'42\',\'9\') || $user->isSuperadmin()','users'=>array('@'),),
			array('deny','users'=>array('*'),),
		);
	}
	public function actionBantuan() {
		
		$this->render('bantuan',array(
			//'model'=>$model,
		));
	}
	
	public function actionIndex() {		
		if (isset($_POST['ImgSite'])) {
		$img_id = $_POST['img_id'];
		$img_site = ImgSite::model()->findByPk($img_id);
			$img_site->attributes=$_POST['ImgSite'];
			$images = '';
			if (isset($_FILES['image_file'])) {
				$fp = fopen($_FILES['image_file']['tmp_name'], "r");
				if ($fp) {
					$images = fread($fp, $_FILES['image_file']['size']); fclose($fp);
					$img_site->image = $images;
				}
			}
			$img_site->keterangan = $_POST['keterangan'];
			if($img_site->save())
				$this->redirect(array('index'));
		}

		$this->render('index');
	}	
	public function actionloadImgSite($param) {
		$model = ImgSite::model()->findByAttributes(array('params'=>$param));
        header('Content-Type:'. $model->img_type);
		print $model->image;
		exit();
    }	
	public function loadModel($id) {
		$model=ImgSite::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	public function actionUpdate($id) {
		$model=$this->loadModel($id);

		if(isset($_POST['ImgSite'])) {
			$model->attributes=$_POST['ImgSite'];
			if($model->save())
				$this->redirect(array('index'));
		}
	}
}