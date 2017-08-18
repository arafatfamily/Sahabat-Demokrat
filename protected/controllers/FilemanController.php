<?php

class FilemanController extends Controller{
	public $layout='//layouts/column2';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array('tambah','index','view','download'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionDownload($id) {
		$model = $this->loadModel($id);
		//$ext = explode('/', $model->file_type);
		header('Content-Type: '.$model->file_type);
		header('Content-Length: '.strlen($model->files)); 
		header('Content-Disposition: attachment; filename='.$model->name);
		print $model->files;
	}
	
	public function actionView($id) {
		$model = $this->loadModel($id);
		header('Content-Type: '.$model->file_type);
		print $model->files;
	}
	
	public function actionDelete($id) {
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('FileManager');
		$model=new FileManager;
		$this->performAjaxValidation($model);

		if(isset($_POST['FileManager'])) {
			$model->attributes=$_POST['FileManager'];
			$model->owner = Yii::app()->user->getUser("users_id");
			$model->date_time = new CDbExpression('NOW()');
			$files = $_FILES['dokumen']['tmp_name'];
			$fp = fopen($files, 'r');
			$content = fread($fp, filesize($files));
			fclose($fp);
			$model->files = $content;
			$model->file_type = $_FILES['dokumen']['type'];
			$model->file_size = $_FILES['dokumen']['size'];
			if($model->save())
				$this->redirect(array('index'));
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}
	
	public function loadModel($id) {
		$model=FileManager::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-manager-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
