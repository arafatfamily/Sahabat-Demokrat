<?php

class Users extends CActiveRecord {
	public $prov_nama;
    public $kab_nama;
    public $kec_nama;
    public $repeat_password;
    public $initialPassword;
	
	public function tableName() {
		return 'users';
	}
	
	public function rules() {
		return array(
            array('password, repeat_password', 'required', 'message' => 'Passwords wajib diisi', 'on' => 'insert'),
			array('username, created', 'required'),
			array('parent, kader_id, role_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>40),
			array('member_id', 'length', 'max'=>10),
            array('password, repeat_password', 'length', 'min' => 6, 'max' => 40),
			array('status', 'length', 'max'=>1),
			array('id_prov', 'length', 'max'=>2),
			array('id_kab', 'length', 'max'=>4),
			array('id_kec', 'length', 'max'=>6),
			array('signed', 'length', 'max'=>9),
            array('password', 'compare', 'compareAttribute' => 'repeat_password', 'message' => 'Passwords tidak sesuai'),
			array('password_repeat', 'safe'),
			array('users_id, parent, kader_id, member_id, username, password, status, role_id, id_prov, id_kab, id_kec, signed, created, allmenu', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations() {
		return array(
			'logPrints' => array(self::HAS_MANY, 'LogPrint', 'users_id'),
			'idKab' => array(self::BELONGS_TO, 'Kabupaten', 'id_kab'),
			'idKec' => array(self::BELONGS_TO, 'Kecamatan', 'id_kec'),
			'idProv' => array(self::BELONGS_TO, 'Provinsi', 'id_prov'),
			//'member' => array(self::BELONGS_TO, 'member', 'member_id'),
			'role' => array(self::BELONGS_TO, 'UsersRole', 'role_id'),
			'usersChats' => array(self::HAS_MANY, 'UsersChat', 'to_users'),
			'usersChats1' => array(self::HAS_MANY, 'UsersChat', 'users_id'),
			'usersGranteds' => array(self::HAS_MANY, 'UsersGranted', 'users_id'),
			'usersGranteds1' => array(self::HAS_MANY, 'UsersGranted', 'by_users'),
			'usersMenus' => array(self::HAS_MANY, 'UsersMenu', 'user_id'),
			'usersPhotos' => array(self::HAS_MANY, 'UsersPhoto', 'users_id'),
		);
	}

    public function beforeSave() {
        if (empty($this->password) && empty($this->repeat_password) && !empty($this->initialPassword))
            $this->password = $this->repeat_password = $this->initialPassword;
        return parent::beforeSave();
    }

    public function saveModel($data = array()) {
        if (!empty($data['password']) && !empty($data['repeat_password'])) {
            $data['password'] = Yii::app()->user->hashPassword($data['password']);
            $data['repeat_password'] = Yii::app()->user->hashPassword($data['repeat_password']);
        }
        $this->attributes = $data;

        if (!$this->save())
            return CHtml::errorSummary($this);

        return true;
    }

    public function afterFind() {
        $this->initialPassword = $this->password;
        $this->password = null;

        parent::afterFind();
    }
	
	public function attributeLabels()
	{
		return array(
			'users_id' => 'Users',
			'parent' => 'Parent',
			'kader_id' => 'Kader',
			'member_id' => 'member_id',
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'role_id' => 'Role',
			'id_prov' => 'Id Prov',
			'id_kab' => 'Id Kab',
			'id_kec' => 'Id Kec',
			'signed' => 'Signed',
			'created' => 'Created',
			'allmenu' => 'allmenu',
		);
	}
	
	public function search() {

		$criteria=new CDbCriteria;

		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('kader_id',$this->kader_id);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('id_prov',$this->id_prov,true);
		$criteria->compare('id_kab',$this->id_kab,true);
		$criteria->compare('id_kec',$this->id_kec,true);
		$criteria->compare('signed',$this->signed,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('allmenu',$this->allmenu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function validatePassword($username, $password) {
        $x = md5($password);
        $sql = "select password from users where username='$username'";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $result = $rows[0];
        $hasil = $result['password'];
        if (($password == $hasil))
            return true;
        return false;
    }/*
	public static function getUsers($id, $param) {
		$sql="SELECT us.parent, us.member_id, us.username, us.`status` FROM users us WHERE us.users_id={$id}";
		$rows = Yii::app()->db->createCommand($sql)->queryRow();
		$return = '';
		foreach ($rows as $data) {
			if ($param == 'username') {
				$return = $data['username'];
			}
		}
		return $return;
	}*/
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
