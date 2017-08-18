<?php
class Controller extends CController {
	public $layout='//layouts/column1';
	public $menu=array();
	public $breadcrumbs=array();
	public function init() {
		if (Yii::app()->user->isAdmin()) {
			Yii::app()->theme = 'backend';
		} else {
			Yii::app()->theme = 'frontend';
		}
		
		parent::init();
	}
	
	public function ExportToJSONDataSource($data, $total=null) {
        if (is_null($total))
            $total = count($data);
		return CJSON::encode($data);
    }
}