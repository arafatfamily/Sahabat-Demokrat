<?php

class ErrorController extends Controller {
	public $layout='//layouts/column2';	
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules() {
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('tambah','hapus','ubah'),
				'users'=>array('admin'),
			),
			array('deny', 'users'=>array('*'),),
		);
	}
	
	public function actionTambah() {
		$model=new ErrorList;
		// $this->performAjaxValidation($model);
		if(isset($_POST['ErrorList'])) {
			$model->attributes=$_POST['ErrorList'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->code));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionUbah($id) {
		$model=$this->loadModel($id);
		// $this->performAjaxValidation($model);
		if(isset($_POST['ErrorList'])) {
			$model->attributes=$_POST['ErrorList'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->code));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionHapus($id) {
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionIndex() {
		$error = Yii::app()->errorHandler->error;
		$err = $this->loadModel($error['code']);
		
		$this->render('error'.$err->code, array(
			'error'=>$err
		));
	}
	
	public function loadModel($id) {
		$model=ErrorList::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='error-list-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
