<?php
class EventsController extends Controller {
	public $layout='//layouts/table12';
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}	
	public function accessRules() {
		return array(
			array('allow','actions'=>array('access','absen','absenLog','loadDetail'),'users'=>array('*'),),
			array('allow','actions'=>array('index','loadEvent','delete','report','calender','treeAcara','participant','loadReport','cariAcara'),
				'expression' => '$user->getAkses(\'27\',\'4\') || $user->isSuperadmin()','users'=>array('@'),),
			array('allow','actions'=>array('view','manage','update'),
				'expression' => '$user->getAkses(\'28\',\'4\') || $user->isSuperadmin()','users'=>array('@'),),
			array('deny','users'=>array('*'),),
		);
	}
	public function actionCariAcara() {
		$lookup = 'sistem'; $filter = '';
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		if (yii::app()->user->getuser("role_id") == 3) {
            $filter .=" AND prov.id_prov='" . yii::app()->user->getuser("id_prov") . "'";
        } else if (yii::app()->user->getuser("role_id") == 4) {
            $filter .=" AND kab.id_kab='" . yii::app()->user->getuser("id_kab") . "'";
        } else if (yii::app()->user->getuser("role_id") == 5) {
            $filter .=" AND kec.id_kec='" . yii::app()->user->getuser("id_kec") . "'";
        }
		$sql = "SELECT es.ses_id AS id, CONCAT(ev.Nama,' (',es.nama,')') AS text FROM event_sesi es "
			 . "INNER JOIN event ev ON ev.ev_id=es.ev_id "
			 . "INNER JOIN kecamatan kec ON kec.id_kec=SUBSTR(ev.subdistrict,1,6) "
			 . "INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab "
			 . "INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov "
			 . "WHERE ev.Nama LIKE '%$lookup%' $filter ORDER BY ev.mulai DESC";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "acara": ' . CJSON::encode($rows) . '}';
        Yii::app()->end();	
	}
	public function actionLoadReport() {
		if($_POST['sesi']) {
			$sql = "SELECT m.member_name, t.akses_code, t.timestamp, t.status FROM event_akses t "
				 . "INNER JOIN member m ON m.id=t.member_id "
				 . "WHERE t.sesi_id = ".$_POST['sesi'];
			$absen = Yii::app()->db->createCommand($sql)->queryAll();
			//$absen = EventAkses::model()->findAllByAttributes(array('sesi_id'=>$_POST['sesi']));
			$sesi = EventSesi::model()->findByPk($_POST['sesi']);
			$event = $this->loadModel($sesi->ev_id);
			header('Content-type: application/json');
			echo '{"acara":'.CJSON::encode($event).',"sesi":'.CJSON::encode($sesi).',"absen":'.CJSON::encode($absen).'}';
			Yii::app()->end();
		}
	}
	public function actionUpdate($id) {
		$model=$this->loadModel($id);
		if(isset($_POST['Event'])) {
			$model->attributes = $_POST['Event'];
			$startEvent = explode(' ',explode(' - ',$_POST['event_time'])[0]);
			$endEvent = explode(' ',explode(' - ',$_POST['event_time'])[1]);
			$model->mulai = Globals::dateMysql($startEvent[0]) . ' ' . $startEvent[1];
			$model->akhir = Globals::dateMysql($endEvent[0]) . ' ' . $endEvent[1];
			if($model->save()) {
				if(isset($_POST['EventSesi'])) {
					$sesi=EventSesi::model()->findByAttributes(array('ev_id'=>$model->ev_id));
					$sesi->attributes = $_POST['EventSesi'];
					$startSesi = explode(' ', explode(' - ', $_POST['sesi_time'])[0]);
					$endSesi = explode(' ', explode(' - ', $_POST['sesi_time'])[1]);
					$sesi->mulai = Globals::dateMysql($startSesi[0]) . ' ' . $startSesi[1];
					$sesi->akhir = Globals::dateMysql($endSesi[0]) . ' ' . $endSesi[1];
					if($sesi->save()) {
						$fTamu=
						EventMember::model()->deleteAll('sesi_id=:ses', array(':ses'=>$sesi->ses_id));
						Globals::AdminLogging('EVENTS', 'UPDATE', $model->Nama.'_'.$sesi->ses_id);
						if(isset($_POST['undangan'])) {				
							$tamu = explode(',', $_POST['undangan'][0]);
							for($i=0;$i<count($tamu);$i++) {
								$command = Yii::app()->db->createCommand();
								$command->insert('event_member', array('member_id'=>$tamu[$i],'sesi_id'=>$sesi->ses_id)); //$sesi->ses_id
								$command->execute();
							}
							$this->redirect(Yii::app()->createUrl('events'));
						}
					}
				}
			}
		}
	}
	public function actionLoadDetail() {
		$data=null;
		if ($_POST['ev_id'] !== '') {
			$getEvent=Event::model()->findByPk($_POST['ev_id']);
			$getSesi=EventSesi::model()->findByAttributes(array('ev_id'=>$getEvent->ev_id));
			$dTamu=EventMember::model()->findAllByAttributes(array('sesi_id'=>$getSesi->ses_id));
			$getLog=LogEvent::model()->findAllByAttributes(array('ses_id'=>$getSesi->ses_id)); var_dump($getLog->users_id); exit;
			$getAdmin=Users::model()->findByPk($getLog->users_id);
			$data=null;
		}
		
		return $data;
	}
	public function actionAbsenLog() {
		$sesi = $_POST['sesi'];
		$sql = "SELECT ea.member_id, ea.timestamp, ea.akses_code, mb.member_name, ea.status FROM event_akses ea INNER JOIN member mb ON mb.id=ea.member_id WHERE ea.member_id IS NOT NULL AND sesi_id='$sesi' ORDER BY ea.timestamp DESC";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		foreach($rows as $data) {
			echo '<li class="user-row" id="chat_user_' . $data['member_id'] . '" data-user-id="' . $data['member_id'] . '">';
			echo '<div class="user-img">';
			echo '<a href="#"><img src="'. Yii::app()->controller->createUrl('member/loadPhoto', array('id' => $data['member_id'])).'" alt=""></a>';
			echo '</div>';
			echo '<div class="user-info">';
			echo '<h4><a href="#">' . $data['member_name'] . '</a></h4>';
			if ($data['status'] == 'A') {
				echo '<span class="status available" data-status="available"> ' . $data['timestamp'] . '</span>';
				echo '</div>';
				echo '<div class="user-status available">';
				echo '<i class="fa fa-sign-in"></i>';				
			} else {				
				echo '<span class="status available" data-status="available"> ' . $data['timestamp'] . '</span>';
				echo '</div>';
				echo '<div class="user-status busy">';
				echo '<i class="fa fa-times-circle"></i>';
			}
			echo '</div>';
			echo '</li>';
		}
	}	
	public function actionAbsen() {
		$rfid = $_POST['rfid'];
		$sesi = $_POST['sesi'];
		$model = Member::model()->findByAttributes(array('CARD_UID'=>$rfid));
		$member_id = 0;
		if ($model) {
			$member_id = $model->id;
		}
		$sql = "SELECT mb.id, mb.membership_id, UPPER(mb.member_name) AS nama, UPPER(kel.nama) AS nama_kel, UPPER(kec.nama) AS nama_kec, UPPER(kab.nama) AS nama_kab, UPPER(prov.nama) AS nama_prov FROM member mb "
			 . "LEFT JOIN event_member em ON em.member_id=mb.id "
			 . "LEFT JOIN event_define ed ON ed.member_id=mb.id "
			 . "LEFT JOIN kelurahan kel ON kel.id_kel=mb.member_sub_district_id "
			 . "LEFT JOIN kecamatan kec ON kec.id_kec=kel.id_kec "
			 . "LEFT JOIN kabupaten kab ON kab.id_kab=kec.id_kab "
			 . "LEFT JOIN provinsi prov ON prov.id_prov=kab.id_prov "
			 . "WHERE mb.CARD_UID='$rfid' AND (ed.kd_akses is not NULL OR em.sesi_id='$sesi')";
		$rows = Yii::app()->db->createCommand($sql)->queryRow();
		if ($rows) {
			Globals::AdminLogging('absen_in','A_M',$sesi.'_'.$rows["id"].'_'.$rfid);
		} else {
			Globals::AdminLogging('absen_in','R_M',$sesi.'_'.$member_id.'_'.$rfid);
		}
        header('Content-type: application/json');
		echo CJSON::encode($rows);
        Yii::app()->end();
	}	
	public function actionAccess($id) {
		$this->layout='event_column';
		$model = Event::model()->findByPk($id);
		$this->render('akses',array(
			'model'=>$model,
		));		
	}	
	public function actionTreeAcara() {
		$lookup = 'acara';
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		$filter = "";
		$sql = "SELECT ev.ev_id AS id, ev.Nama AS text FROM event ev "
			 . "INNER JOIN kelurahan kel ON kel.id_kel=ev.subdistrict "
			 . "INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec "
			 . "INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab "
			 . "INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov "
			 . "WHERE ev.Nama LIKE '%$lookup%' $filter ORDER BY ev.mulai";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "acara": ' . CJSON::encode($rows) . '}';
        Yii::app()->end();		
	}	
	public function actionCalender() {
		$filter = "";
		$sql = "SELECT ev.ev_id AS id, ev.Nama AS nama, DATE_FORMAT(ev.mulai, '%Y-%m-%d-%l-%i') AS mulai, DATE_FORMAT(ev.akhir, '%Y-%m-%d-%l-%i') AS akhir FROM `event` ev "
		 . "INNER JOIN kelurahan kel ON kel.id_kel=ev.subdistrict "
		 . "INNER JOIN kecamatan kec ON kec.id_kec=kel.id_kec "
		 . "INNER JOIN kabupaten kab ON kab.id_kab=kec.id_kab "
		 . "INNER JOIN provinsi prov ON prov.id_prov=kab.id_prov "
		 . "WHERE ev.Nama IS NOT NULL $filter";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
		echo CJSON::encode($rows);
        Yii::app()->end();
	}	
	public function actionView($id) {
		$getSesi = EventSesi::model()->findByAttributes(array('ev_id'=>$id));
		$getLog = LogEvent::model()->findByAttributes(array('ses_id'=>$getSesi->ses_id));
		$getAdmin = Users::model()->findByPk($getLog->users_id);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'sesi'=>$getSesi, 'log'=>$getLog, 'admin'=>$getAdmin,
		));
	}	
	public function actionLoadEvent() {
		if(isset($_POST['eventId'])) {
			$model=$this->loadModel($_POST['eventId']);
			$sesi=EventSesi::model()->findByAttributes(array('ev_id'=>$model->ev_id));
			$tSql="SELECT id, CONCAT(member_name,' (',membership_id,')') AS text FROM member WHERE id IN (SELECT member_id FROM event_member WHERE sesi_id=".$sesi->ses_id.")";
			$tamu = Yii::app()->db->createCommand($tSql)->queryAll();
		}
		header('Content-type: application/json');
        echo '{ "data": ' . CJSON::encode($model) . ', "sesi": '. CJSON::encode($sesi) . ', "tamu": '. CJSON::encode($tamu) . '}';
        Yii::app()->end();
	}	
	public function actionDelete($id) {
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
	public function actionIndex() {
		$model = Event::model()->findAll();
		
		$dataProvider=new CActiveDataProvider('Event', array(
			'pagination' => array(
				'pageSize' => 15
			),
			'sort' => array(
                'defaultOrder' => 'akhir DESC',
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}	
	public function actionManage() {
		$model = new Event; $sesi = new EventSesi;
		if(isset($_POST['Event'])) {
			$model->attributes=$_POST['Event'];
			$startEvent = explode(' ',explode(' - ',$_POST['event_time'])[0]);
			$endEvent = explode(' ',explode(' - ',$_POST['event_time'])[1]);
			$model->mulai = Globals::dateMysql($startEvent[0]) . ' ' . $startEvent[1];
			$model->akhir = Globals::dateMysql($endEvent[0]) . ' ' . $endEvent[1];
			$model->timestamp = new CDbExpression('NOW()');
			if($model->save()) {
				if(isset($_POST['EventSesi'])) {
					$sesi->attributes=$_POST['EventSesi'];
					$startSesi = explode(' ', explode(' - ', $_POST['sesi_time'])[0]);
					$endSesi = explode(' ', explode(' - ', $_POST['sesi_time'])[1]);
					$sesi->ev_id = $model->ev_id;
					$sesi->mulai = Globals::dateMysql($startSesi[0]) . ' ' . $startSesi[1];
					$sesi->akhir = Globals::dateMysql($endSesi[0]) . ' ' . $endSesi[1];
					if($sesi->save()) {
						Globals::AdminLogging('EVENTS', 'INSERT', $model->Nama.'_'.$sesi->ses_id);
						if(isset($_POST['undangan'])) {							
							$tamu = explode(',', $_POST['undangan'][0]);
							for($i=0;$i<count($tamu);$i++) {
								$command = Yii::app()->db->createCommand();
								$command->insert('event_member', array('member_id'=>$tamu[$i],'sesi_id'=>$sesi->ses_id)); //$sesi->ses_id
								$command->execute();
							}
							$this->redirect(Yii::app()->createUrl('events'));
						}
					}
				}
				$this->redirect(Yii::app()->createUrl('events'));
			}
				
		}
		$this->render('manage',array(
			'model'=>$model,
			'sesi'=>$sesi
		));
	}	
	public function actionParticipant() {
		$lookup = "participant";
		if (isset($_GET['q'])) {
			$lookup = $_GET['q'];
		}
		$sql = "SELECT id, CONCAT(member_name,' (',membership_id,')') AS text FROM member WHERE member_status='A' AND CONCAT(member_name,' (',membership_id,')') LIKE '%$lookup%'";
		$data = Yii::app()->db->createCommand($sql)->queryAll();
        header('Content-type: application/json');
        echo '{ "participant": ' . CJSON::encode($data) . '}';
        Yii::app()->end();
	}	
	public function actionReport() {
		$this->render('report');
	}
	public function loadModel($id) {
		$model=Event::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}