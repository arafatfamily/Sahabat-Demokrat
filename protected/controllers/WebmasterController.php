<?php
class WebmasterController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules() {
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('glyphicon','index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionGlyphicon() {
		$lookup = "glyphicon";
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		$sql = "SELECT name AS id, name AS text FROM icon_list WHERE type='glyph' AND name LIKE '%$lookup%'";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "glyphicon": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}
	
	public function actionIndex() {
		$model=new Changelog;
		$this->performAjaxValidation($model);

		if(isset($_POST['Changelog'])) {
			$model->attributes=$_POST['Changelog'];
			$model->date = new CDbExpression('NOW()');
			$model->posisi = $_POST['Changelog']['posisi'] == 'L' ? 'L' : 'R';
			$model->webmaster = Yii::app()->user->getuser("users_id");
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($id) {
		$model=Changelog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='changelog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
