<?php
class Maintenance extends CApplicationComponent {
	public $allowedIPs=array();
	public $locked=false;
	public $redirectURL='';
	public function init() {
   		if($this->locked == true) {
			$allowed = false;
   			$ips = $this->allowedIPs;
   			foreach($ips as &$ip) {
   				if($_SERVER['REMOTE_ADDR'] == $ip) {
   					$allowed = true;
   				} 
   			}
			if($allowed == false) {
				Yii::app()->request->redirect($this->redirectURL);
			}
		}
   }
}