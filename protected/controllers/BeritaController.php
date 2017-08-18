<?php

class BeritaController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}
	
	public function accessRules() {
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','imgsite'),
				'users'=>array('*'),
			),
			array('allow','actions'=>array('view','create','delete','insert'),
				'expression' => '$user->isSuperadmin()','users'=>array('@'),),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		// $this->performAjaxValidation($model);

		if(isset($_POST['SiteNews']))
		{
			$model->attributes=$_POST['SiteNews'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->news_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	public function actionIndex() {
		$model=new SiteNews;
		//$this->performAjaxValidation($model);

		if(isset($_POST['SiteNews'])) {
			$model->attributes=$_POST['SiteNews'];
			$model->admin = Yii::app()->user->getUser("users_id");
			if ($model->validate()) {
				$sticky_img = '';
				if (isset($_FILES['news_img']) && $model->sticky == 'Y') {
					$fp = fopen($_FILES['news_img']['tmp_name'], "r");
					if ($fp) {
						$sticky_img = fread($fp, $_FILES['news_img']['size']); fclose($fp);
						$model->news_img = $sticky_img;
					}
				} if (empty($model->news_img) && $model->sticky == 'Y') {
					$model->addError('news_img','Harap upload image sticky');
				} else {
					if($model->save()) {
						$this->redirect(array('view','id'=>$model->news_id));
					}
				}
			}
		}
		
		$dataProvider=new CActiveDataProvider('SiteNews');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
	}
	
	public function actionAdmin()
	{
		$model=new SiteNews('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SiteNews']))
			$model->attributes=$_GET['SiteNews'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionImgSite($id) {
		$model = $this->loadModel($id);
        header('Content-Type:'. $model->img_type);
		print $model->news_img;
		exit();
    }
	
	public function loadModel($id)
	{
		$model=SiteNews::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='site-news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
