<?php
class EWebUser extends CWebUser {
    protected $_model;	
	function isAdmin() {
        $user = $this->loadUser();
		if (!$user) {
			return false;
		} else {
			$member = Member::model()->findByPk($user->kader_id);
			if ($user->kader_id == $member)
				return false;
			return true;
		}		
	}
	
    function isSuperadmin() {
        $user = $this->loadUser();
        if ($user)
            return $user->role_id == 1;
        return false;
    }

    function getuser($param) {
        $user = $this->loadUser();
        if ($param == 'role_id') {            
			if($this->isAdmin()) {
				return $user->role_id;
			} else {
				return 'guest';
			}
        } else if ($param == 'id_prov') {
            return $user->id_prov;
        } else if ($param == 'users_id') {
            return $user->users_id;
        } else if ($param == 'id_kab') {
            return $user->id_kab;
        } else if ($param == 'id_kec') {
            return $user->id_kec;
        } else if ($param == 'kader_id') {
            return $user->kader_id;
        } else if ($param == 'username') {
            return strtoupper($user->username);
        } else if ($param == 'member_id') {
			return Member::model()->findByPk($user->kader_id)->member_id;
		} else if ($param == 'member_name') {
			if (!$this->isAdmin()) {
				return strtoupper('TRIAL ADMIN');
			} else {
				return strtoupper(Member::model()->findByPk($user->kader_id)->member_name);
			}
		} else if ($param == "role") {
            return UsersRole::model()->findByPk($user->role_id)->role;
        } else if ($param == "location") {
            if ($user->role_id == 1) {
                return "^_^ WEBMASTER ^_^";
            } if ($user->role_id == 2) {
                return "Admin Nasional";
            } else if ($user->role_id == 3) {
                return "DPD " . Provinsi::model()->findByPk($user->id_prov)->nama;
            } else if ($user->role_id == 4) {
                return "DPD " . Provinsi::model()->findByPk($user->id_prov)->nama . ",</br>DPC " . Kabupaten::model()->findByPk($user->id_kab)->nama;
            } else if ($user->role_id == 5) {
                return "DPC " . Kabupaten::model()->findByPk($user->id_kab)->nama . ",</br>PAC " . Kecamatan::model()->findByPk($user->id_kec)->nama;
            } else {
                return "Semua Lokasi";
            }
        } else if ($param == "menu") {
			return $user->allmenu;
		}
    }
	
	function getAkses($param, $akses) {
		$users = Yii::app()->user->id;
		$granted = UsersGranted::model()->findByAttributes(array('users_id'=> $users, 'akses_id'=>$param, 'menu_id'=>$akses));
		if ($granted !== NULL) {
			return true;
		} else {
			return false;
		}
	}
	
    protected function afterLogin() {
        $this->setState('___uid', $this->id);
        Globals::AdminLogging('users','login',$this->id);
		$setonline = "UPDATE users SET signed='available' WHERE users_id='" . $this->id . "'";
		Yii::app()->db->createCommand($setonline)->execute();
		$setmessage = "INSERT INTO users_chat(users_id, time, message, to_users) VALUES('" . $this->id . "'," . new CDbExpression('NOW()') . ", 'login to chat', '" . $this->id . "')";
		Yii::app()->db->createCommand($setmessage)->execute();
        return true;
    }

    protected function beforeLogout() {
        parent::beforeLogout();
        Globals::AdminLogging('users','logout',Yii::app()->user->id);
        $setoffline = "UPDATE users SET signed='offline' WHERE users_id='" . Yii::app()->user->id . "'";
        Yii::app()->db->createCommand($setoffline)->execute();
		$setmessage = "INSERT INTO users_chat(users_id, time, message, to_users, status) VALUES('" . $this->id . "'," . new CDbExpression('NOW()') . ", 'logout from chat', '" . $this->id . "','R')";
		Yii::app()->db->createCommand($setmessage)->execute();
        $setread = "UPDATE users_chat SET status='R' WHERE users_id='" . Yii::app()->user->id . "' AND message LIKE '%login to chat%'";
        Yii::app()->db->createCommand($setread)->execute();
        return true;
    }

    protected function loadUser() {
        if ($this->_model === null) {
            $this->_model = Users::model()->findByPk(Yii::app()->user->id);
        }
        return $this->_model;
    }
}
