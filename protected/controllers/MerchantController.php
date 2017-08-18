<?php
class MerchantController extends Controller {
	public $layout='//layouts/column2';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function accessRules() {
		return array(
			array('allow', 'actions'=>array('index','hapus','ubah','registrasi','loadMember','view','loadPoster','loadProduk', 'loadSticky'), 'users'=>array('@'),),
			array('deny', 'users'=>array('*'),),
		);
	}
	public function actionLoadSticky($id) {
		$model = MerchantImg::model()->findByAttributes(array('img_as'=>'Promo', 'merchant'=>$id));
        header('Content-Type:'. $model->img_type);
		print $model->images;
		Yii::app()->end();
	}
	public function actionLoadProduk($id) {
		$model = MerchantImg::model()->findByAttributes(array('img_as'=>'Produk', 'merchant'=>$id));
        header('Content-Type:'. $model->img_type);
		print $model->images;
		Yii::app()->end();
	}
	public function actionLoadPoster($id) {
		$model = MerchantImg::model()->findByAttributes(array('img_as'=>'Poster', 'merchant'=>$id));
        header('Content-Type:'. $model->img_type);
		print $model->images;
		Yii::app()->end();
	}
	public function actionView($id) {
		$model = $this->loadModel($id);
		$member = Member::model()->findByPk($model->member_id);
		$this->render('view',array(
			'model'=>$model,
			'member'=>$member
		));
	}
	public function actionLoadMember() {
		$lookup = "member";
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		$sql = "SELECT id, CONCAT(member_name,' (',membership_id,')') AS text FROM member WHERE member_status='A' AND CONCAT(member_name,' (',membership_id,')') LIKE '%$lookup%'";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "member": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}
	public function actionRegistrasi() {
		$model=new Merchant;
		$this->performAjaxValidation($model);
		
		if(isset($_POST['Merchant'])) {
			$model->attributes=$_POST['Merchant'];
			$model->date_join = new CDbExpression('NOW()');
			if($model->save()) {
				if($_POST['postPoster'] != '') {
					$image=new MerchantImg;
					$image->merchant = $model->idm;
					$image->img_as = 'Poster';
					$imgPost = $_POST['postPoster'];
					$fpImg = fopen($imgPost, 'rb');
					$imgContent = stream_get_contents($fpImg);
					fclose($fpImg);
					$image->images = $imgContent;
					$image->taken = new CDbExpression('NOW()');
					$image->save();
				}
				$this->redirect(array('view','id'=>$model->idm));
			}
		}
		
		$this->render('registrasi', array(
			'model'=>$model
		));
	}
	public function actionUbah($id) {
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);

		if(isset($_POST['Merchant'])) {
			$model->attributes=$_POST['Merchant'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->idm));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionHapus($id) {
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionIndex() {
		$filter = '';
		
		$model = new Merchant('search');
        $model->unsetAttributes();
        if (isset($_GET['Merchant'])) {
            $model->attributes = $_GET['Merchant'];
        }
		
		$this->render('index',array(
			'model' => $model,
			'dataProvider' => $model->loadMerchant($filter, array('pageSize' => 20)),			
		));
	}
	public function loadModel($id) {
		$model=Merchant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='merchant-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
