<?php

class StrukturController extends Controller {
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
				'actions'=>array('index','view','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionCreate() {
		$model=new MemberPosition;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MemberPosition']))
		{
			$model->attributes=$_POST['MemberPosition'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	} 
	public function actionUpdate($id) {
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MemberPosition']))
		{
			$model->attributes=$_POST['MemberPosition'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	} 
	public function actionDelete($id) {
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
        }/*
        $model = new MemberPosition('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberPosition'])) {
            $model->attributes = $_GET['MemberPosition'];
        }
		
		$this->render('index',array(
			'model' => $model,
			//'dataProvider' => $model->loadMember($filter, 'A', array('pageSize' => 20)),			
		));*/
		
		$dataProvider=new CActiveDataProvider('MemberPosition');
		$this->render('index',array(
			'model'=>new MemberPosition,
			'dataProvider'=>$dataProvider,
		));
	} 
	public function loadModel($id) {
		$model=MemberPosition::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	} 
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='MemberPosition-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
