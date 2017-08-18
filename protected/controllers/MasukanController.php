<?php

class MasukanController extends Controller {
	public $layout='//layouts/column2';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	public function accessRules() {
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','tambah','balas'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionClose($id) {
		$model=$this->loadModel($id);
		if(isset($_POST['KritikSaran'])) {
			$model->attributes=$_POST['KritikSaran'];
			$model->status = 'C';
			if($model->save())
				$this->redirect('masukan/index');
		}
	}
	public function actionBalas() {
		$model=new KritikRespons;
		if($_POST['reply']) {
			$model->kritik_id = $_POST['id'];
			$model->konten = $_POST['reply'];
			$model->admin_id = Yii::app()->user->id;
			$model->reply_date = new CDbExpression('NOW()');
			if($model->save()) {
				$update=$this->loadModel($model->kritik_id);
				$update->status = 'R';
				if($update->save())
					echo '{"success": true}';
			}
		}
	}
	public function actionTambah() {
		$model=new KritikSaran;
		$this->performAjaxValidation($model);
		if(isset($_POST['KritikSaran'])) {
			$model->attributes=$_POST['KritikSaran'];
			$model->member_id = Yii::app()->user->getuser("kader_id");
			$model->administrator = Yii::app()->user->isAdmin() ? 'Y' : 'N';
			$model->update_time = new CDbExpression('NOW()');
			$model->status = 'P';
			if($model->save())
				$this->redirect('index');
		}		
	}
	public function actionIndex() {
		$dataProvider = KritikSaran::model()->findAll(array(
			'condition'=>'member_id="'.Yii::app()->user->getuser('kader_id').'"',
			'order'=>'update_time DESC'
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>new KritikSaran
		));
	}
	public function actionDelete($id) {
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function loadModel($id) {
		$model=KritikSaran::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='kritik-saran-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
