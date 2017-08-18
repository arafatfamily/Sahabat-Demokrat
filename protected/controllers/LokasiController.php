<?php

class LokasiController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}
	
	public function accessRules() {
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			array('allow','actions'=>array('index','tambah','ubah','sebaran','perjalanan','loadMember','loadMemberRute','loadMemberLocation','loadMemberAddress','loadOffice','sekretariat'),
				'expression' => '$user->isSuperadmin()','users'=>array('@'),),
			array('deny', 'users'=>array('*'),),
		);
	}
	public function actionloadMember() {		
		$filter = ""; $lookup = "";
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		if (isset($_GET['prov']) && $_GET['prov'] != '') {
			$filter .=" AND pv.id_prov='" . $_GET['prov'] . "'";
		}
		if (isset($_GET['kab']) && $_GET['kab'] != '') {
			$filter .=" AND kb.id_kab='" . $_GET['kab'] . "'";
		}
		if (isset($_GET['kec']) && $_GET['kec'] != '') {
			$filter .=" AND kc.id_kec='" . $_GET['kec'] . "'";
		}
		if (isset($_GET['kel']) && $_GET['kel'] != '') {
			$filter .=" AND kl.id_kel='" . $_GET['kel'] . "'";
		}
		$sql = "SELECT mb.id, CONCAT(mb.member_name, ' (', mb.membership_id, ')') AS text FROM member mb "
			 . "INNER JOIN kelurahan kl ON kl.id_kel=mb.member_sub_district_id "
			 . "INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec "
			 . "INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab "
			 . "INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov "
			 . "WHERE CONCAT(mb.member_name, ' (', mb.membership_id, ')') LIKE '%$lookup%' "
			 . "AND mb.id IN (SELECT lm.member_id FROM lokasi_member lm WHERE lm.track_lat IS NOT NULL OR lm.track_lon IS NOT NULL GROUP BY lm.member_id) $filter";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "kader": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}
	public function actionloadMemberRute() {
		if(isset($_POST["id"])) {
			$filter = ""; $id = $_POST["id"];
			if($_POST['dateLog'] != '') {
				$startPoint = explode(' ', explode(' - ', $_POST['dateLog'])[0]);
				$endPoint = explode(' ', explode(' - ', $_POST['dateLog'])[1]);
				$filter = "AND time>='".Globals::dateMysql($startPoint[0])." ".$startPoint[1]."' AND time<='".Globals::dateMysql($endPoint[0])." ".$endPoint[1]."'";
			}
			$member = Yii::app()->db->createCommand("SELECT id, member_name FROM member WHERE id=$id")->queryAll();
			$wpSql = "SELECT track_lat, track_lon, time FROM lokasi_member WHERE member_id=$id ".$filter." GROUP BY SUBSTR(time,1,16) ORDER BY time ASC";
			$wayPoint = Yii::app()->db->createCommand($wpSql)->queryAll();
			echo '{"infoMember":'.CJSON::encode($member).',
			"startPoint":'.CJSON::encode(reset($wayPoint)).',
			"wayPoint":'.CJSON::encode($wayPoint).',
			"endPoint":'.CJSON::encode(end($wayPoint)).'}';
		}		
	}
	
	public function actionloadMemberLocation() {
        $filter = "";		
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
		
        $sql = "SELECT t.member_id, m.member_name, m.member_sub_district_id, m.cellular_phone_number, t.mobile_lat AS latitude, t.mobile_lon AS longitude FROM lokasi t INNER JOIN member m ON m.id=t.member_id INNER JOIN kelurahan kl ON kl.id_kel=m.member_sub_district_id INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov WHERE t.mobile_lat is not null and t.mobile_lon is not null $filter order by t.member_id desc";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        echo CJSON::encode($rows);		
    }
	
	public function actionloadMemberAddress() {
        $filter = "";		
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
		
        $sql = "SELECT t.member_id, m.member_name, m.member_sub_district_id, m.cellular_phone_number, t.address_lat AS latitude, t.address_lon AS longitude FROM lokasi t INNER JOIN member m ON m.id=t.member_id INNER JOIN kelurahan kl ON kl.id_kel=m.member_sub_district_id INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov WHERE t.address_lat is not null and t.address_lon is not null $filter order by t.member_id desc";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        echo CJSON::encode($rows);		
    }
	
	public function actionloadOffice() {
        $filter = "";		
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND pv.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kb.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kc.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
		
        $sql = "SELECT t.member_id, m.member_name, m.member_sub_district_id, m.cellular_phone_number, t.address_lat AS latitude, t.address_lon AS longitude FROM lokasi t INNER JOIN member m ON m.id=t.member_id INNER JOIN kelurahan kl ON kl.id_kel=m.member_sub_district_id INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov WHERE t.address_lat is not null and t.address_lon is not null $filter order by t.member_id desc";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        echo CJSON::encode($rows);		
    }
	
	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('Lokasi');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionSebaran() {
		$dataProvider=new CActiveDataProvider('Lokasi');
		$this->render('sebaran',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionPerjalanan() {
		$dataProvider=new CActiveDataProvider('Lokasi');
		$this->render('perjalanan',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionSekretariat() {
		$dataProvider=new CActiveDataProvider('Lokasi');
		$this->render('sekretariat',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionTambah() {
		$model = new Sekretariat;
		$this->performAjaxValidation($model);

		if(isset($_POST['Sekretariat'])) {
			$model->attributes=$_POST['Sekretariat'];
			if($model->save())
				$this->redirect(array('sekretariat'));
		}
		
		$this->render('tambah',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($id) {
		$model=Lokasi::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='lokasi-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
