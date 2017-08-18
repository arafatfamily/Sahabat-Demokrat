<?php
class Helpers extends CApplicationComponent {
	public static function ajaxSelect2() {
		
	}
	public static function memberSelect2() {
		if(Yii::app()->user->isAdmin()) {
			
		}
	}
	public static function appConfig($params) {
		switch($params) {
			default:
				Yii::app()->end;
		}
	}
	public static function getListdomisili($model, $data = null) {
		$filter = '';
		switch($model) {
			default:
				Yii::app()->end;
		}
	}
	public static function getStrukturData($table, $data = null) {
		$filter = '';
		switch($table) {
			case 'lokasi':
				if(!is_null($data)) {
					$filter = "WHERE level=$data";
				}
				$sql="SELECT level as id, `desc` as text FROM pos_lokasi $filter";
				if(Yii::app()->user->isAdmin()) {
					if (yii::app()->user->getuser("role_id") == 3) {
						$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22)";
					} else if (yii::app()->user->getuser("role_id") == 4) {
						$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22,33)";
					} else if (yii::app()->user->getuser("role_id") == 5) {
						$sql="SELECT level as id, `desc` as text FROM pos_lokasi WHERE level NOT IN (11,22,33,44)";
					}
				}	
				$rows = Yii::app()->db->createCommand($sql)->queryAll();
				return $rows;
				break;
			case 'provinsi':
				$sql="SELECT id_prov as id, nama as text FROM provinsi";
				if(Yii::app()->user->isAdmin()) {
					$role=Yii::app()->user->getuser("role_id");
					if ($role == 3 || $role == 4 || $role == 5) {
						$sql="SELECT id_prov as id, nama as text FROM provinsi WHERE id_prov=" . Yii::app()->user->getuser('id_prov');
					}
				}
				$rows=Yii::app()->db->createCommand($sql)->queryAll();
				return $rows;
				break;
			default:
				Yii::app()->end;
		}
	}
}
?>