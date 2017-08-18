<?php

class FrontEndController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow','actions'=>array('loadImgSlide', 'loadVideo'),'users'=>array('*'),),
			array('allow','actions'=>array('index'),
				'expression' => '$user->getAkses(\'43\',\'9\') || $user->isSuperadmin()','users'=>array('@'),),
			array('deny','users'=>array('*'),),
		);
	}
	public function actionIndex() {
		$slider = new SiteSlider;
		if (isset($_POST['SiteSlider'])) {
			$slider->attributes = $_POST['SiteSlider'];
			$images = '';
			if (isset($_FILES['image_file'])) {
				$fp = fopen($_FILES['image_file']['tmp_name'], "r");
				if ($fp) {
					$images = fread($fp, $_FILES['image_file']['size']); fclose($fp);
					$slider->images = $images;
				}
			}
			if($slider->save())
				$this->redirect(array('index'));
		}
		
		$this->render('index', array('slider'=>$slider));
	}
	
	public function actionloadImgSlide($id) {
		$model = SiteSlider::model()->findByPk($id);
        header('Content-Type:'. $model->img_type);
		print $model->images;
		exit();
    }
}