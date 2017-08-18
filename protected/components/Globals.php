<?php
class Globals extends CApplicationComponent {	
	public static function getAdminPrint($models, $condition, $single=true) {
		if ($single) {
			$model = $models::model()->find(array(
				'condition'=>$condition,
				'order'=>'log_id DESC'
			));			
		} else {			
			$model = $models::model()->findAll(array(
				'condition'=>$condition,
				'order'=>'log_id DESC'
			));
		}
		if(!$model) {
			return 'Log Tidak Tersedia';
		} else {
			$data = Users::model()->findByPk($model->users_id);
			return $data->username . '/' . $model->status . '(' . $model->print_type . ')';
		}
	}
	
    public static function newID($TableName, $Primary) {
        $isAda = TRUE;
        $jumlahSama = 0;
        $guidText = "";
        while ($isAda) {
            $s = strtoupper(md5(uniqid(rand(), true)));
            $guidText = substr($s, 0, 8) . '' .
                    substr($s, 8, 2) . '' .
                    substr($s, 12, 2) . '' .
                    substr($s, 16, 4) . '' .
                    substr($s, 20, 4);
            if (Globals::isDataExist("select count(*) from " . $TableName . " where " . $Primary . "='" . $guidText . "'")) {
                $isAda = TRUE;
                $jumlahSama = $jumlahSama + 1;
            } else {
                $isAda = FALSE;
            }
        }
        return $guidText;
    }

    public static function isDataExist($sql) {
        $recCount = "0";
        $results = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($results AS $result) {
            $recCount = $recCount + $result['count'];
        }
        if ($recCount == "0" || $recCount == null || $recCount == 'null') {
            return false;
        } else {
            return true;
        }
    }

    public static function findByRef($table, $field, $where = "") {
        $sql = "SELECT $field as result FROM $table WHERE $field is not null AND $where LIMIT 1";
        $output = "";
        $results = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($results AS $result) {
            $output = $result['result'];
        }
        return $output;
    }

    public static function GetNextNo($table, $field, $where = "") {
        try {
            $sql = "select ifnull(max(cast($field as UNSIGNED))+1,1) as kode from $table where $field is not null $where";
            $nextKode = "1";
            $results = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($results AS $result) {
                $nextKode = $result['kode'];
            }

            while (strlen($nextKode) < 4) {
                $nextKode = "0" . $nextKode;
            }

            return $nextKode . "";
        } catch (Exception $e) {
            return "0001";
        }
    }

    public static function dateMysql($date) {
        try {

            $result = substr($date, 6, 4) . "-" . substr($date, 3, 2) . "-" . substr($date, 0, 2);

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function dateRevMysql($date) {
        try {

            $result = substr($date, 8, 2) . "/" . substr($date, 5, 2) . "/" . substr($date, 0, 4);

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function dateIndonesia($date) {
        try {

            $result = substr($date, 8, 2) . " " . Globals::bulan(substr($date, 5, 2)) . " " . substr($date, 0, 4);

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function bulan($i) {
        $i = intval($i);
        $data = array(
            'JANUARI',
            'FEBRUARI',
            'MARET',
            'APRIL',
            'MEI',
            'JUNI',
            'JULI',
            'AGUSTUS',
            'SEPTEMBER',
            'OKTOBER',
            'NOVEMBER',
            'DESEMBER'
        );

        return $data[$i - 1];
    }

    public static function AdminLogging($action,$mode,$media) {
		if ($action == 'print' || $action == 'cetak') {
			$model = new LogPrint();
			$model->member_id = $media;
			$model->date_print = new CDbExpression('NOW()');
			$model->users_id = Yii::app()->user->getuser("users_id");
			$model->print_type = $mode;
			if ($action == 'cetak') {
				$model->status = 'PRINT PROFIL';
			} else {
				$model->status = 'PRINT KTA';
			}
			$model->ip_address = $_SERVER['REMOTE_ADDR'];
			$model->save(false);
		} else if ($action == 'insert' || $action == 'update' || $action == 'delete') {
			$model = new LogInput();
			$model->member_id = $media;
			$model->date_time = new CDbExpression('NOW()');
			$model->users_id = Yii::app()->user->getuser("users_id");
			$model->act_info = $mode;
			if ($action == 'delete') {
				$model->act_type = 'DELETE';
			} else if ($action == 'update') {
				$model->act_type = 'UPDATE';
			} else {
				$model->act_type = 'INSERT';
			}			
			$model->ip_address = $_SERVER['REMOTE_ADDR'];
			$model->save(false);
		} else if ($action == 'users') {
			$model = new UsersLog();
			$model->activity = $mode . ":" . $media;
			$model->users_id = Yii::app()->user->getuser("users_id");
			$model->time = new CDbExpression('NOW()');
			$model->ip = $_SERVER['REMOTE_ADDR'];
			$model->save(false);
		} else if ($action ==  'absen_in' || $action == 'absen_out') {
			$model = new EventAkses();
			$dNeeded = explode("_", $media);
			$model->sesi_id = $dNeeded[0];
			$model->member_id = $dNeeded[1] == 0 ? Null : $dNeeded[1];
			$model->auth_use = $dNeeded[2];
			$dStatus = explode("_", $mode);
			$model->akses_code = $dStatus[1];
			$model->status = $dStatus[0];
			$model->save(false);
		} else if ($action == 'EVENTS') {
			$model = new LogEvent();
			$dNeeded = explode("_", $media);
			$model->ses_id = $dNeeded[1];
			$model->date_time = new CDbExpression('NOW()');
			$model->users_id = Yii::app()->user->getuser("users_id");
			if ($mode == 'UPDATE') {
				$model->act_info = 'Ubah Acara '.$dNeeded[0];	
			} else if ($mode == 'DELETE') {
				$model->act_info = 'Hapus Acara '.$dNeeded[0];	
			} else {
				$model->act_info = 'Tambah Acara '.$dNeeded[0];	
			}
			$model->act_type = $mode; 
			$model->ip_address = $_SERVER['REMOTE_ADDR'];
			$model->save(false);
		}
    }
	
	public static function Jumlah($model,$column,$value,$id) {
		if ($id == null) {
			$jml = $model::model()->countByAttributes(array($column=>$value));
		} else {
			$jml = $model::model()->countByAttributes(array(
				$column => $value,
				'member_id' => $id
			));
		}
		
		return $jml;
	}
	
	public static function Total($model,$table,$value) {
		if ($table == '' && $value == '') {
			$criteria = new CDbCriteria();
		} else {
			$criteria = new CDbCriteria(array('condition' => $table . " = '" . $value . "'"));
		}		
		if($model == 'Member') {
			$criteria->join = "INNER JOIN kelurahan kl ON kl.id_kel=t.member_sub_district_id ";
			$criteria->join .= "INNER JOIN kecamatan kc ON kc.id_kec=kl.id_kec ";
			$criteria->join .= "INNER JOIN kabupaten kb ON kb.id_kab=kc.id_kab ";
			$criteria->join .= "INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov ";
			
			if (yii::app()->user->getuser("role_id") == 3) {
				$criteria->addCondition('pv.id_prov = "' . yii::app()->user->getuser("id_prov") . '"');
			} else if (yii::app()->user->getuser("role_id") == 4) {
				$criteria->addCondition('kb.id_kab= "' . yii::app()->user->getuser("id_kab") . '"');
			} else if (yii::app()->user->getuser("role_id") == 5) {
				$criteria->addCondition('kc.id_kec= "' . yii::app()->user->getuser("id_kec") . '"');
			}
		}
		$total = $model::model()->count($criteria);
		
		return $total;
	}
	
	public static function getAkses($users_id,$akses_id) {
		$model = UsersGranted::model()->countByAttributes(array(
			'users_id'=>$users_id,'akses_id'=>$akses_id));
		return $model;
	}
	//Lib Custom Generate Barcode code128 by Yasir Arafat
	static public function gd($res, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null){
        return self::_draw(__FUNCTION__, $res, $color, $x, $y, $angle, $type, $datas, $width, $height);
    }	
	static private function _draw($call, $res, $color, $x, $y, $angle, $type, $datas, $width, $height){
        $digit = '';
        $hri   = '';
        $code  = '';
        $crc   = true;
        $rect  = false;
        $b2d   = false;

        if (is_array($datas)){
            foreach(array('code' => '', 'crc' => true, 'rect' => false) as $v => $def){
                $$v = isset($datas[$v]) ? $datas[$v] : $def;
            }
            $code = $code;
        } else {
            $code = $datas;
        }
        if ($code == '') return false;
        $code = (string) $code;
        $type = strtolower($type);
        switch($type){
            case 'code128':
                $digit = self::getDigit($code);
                $hri = $code;
                break;
        }

        if ($digit == '') return false;

        if ( $b2d ){
            $width = is_null($width) ? 5 : $width;
            $height = $width;
        } else {
            $width = is_null($width) ? 1 : $width;
            $height = is_null($height) ? 50 : $height;
            $digit = self::bitStringTo2DArray($digit);
        }

        if ( $call == 'gd' ){
            $result = self::digitToGDRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        } else if ( $call == 'fpdf' ){
            $result = self::digitToFPDFRenderer($res, $color, $x, $y, $angle, $width, $height, $digit);
        }

        $result['hri'] = $hri;
        return $result;
    }
	private static function bitStringTo2DArray( $digit ){
        $d = array();
        $len = strlen($digit);
        for($i=0; $i<$len; $i++) $d[$i] = $digit[$i];
        return(array($d));
    }	
	private static function digitToGDRenderer($gd, $color, $xi, $yi, $angle, $mw, $mh, $digit){
        $fn = function($points) use ($gd, $color) {
            imagefilledpolygon($gd, $points, 4, $color);
        };
        return self::digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit);
    }	
	private static function digitToRenderer($fn, $xi, $yi, $angle, $mw, $mh, $digit){
        $lines = count($digit);
        $columns = count($digit[0]);
        $angle = deg2rad(-$angle);
        $cos = cos($angle);
        $sin = sin($angle);
		
        self::_rotate($columns * $mw / 2, $lines * $mh / 2, $cos, $sin , $x, $y);
        $xi -=$x;
        $yi -=$y;
        for($y=0; $y<$lines; $y++){
            $x = -1;
            while($x <$columns) {
                $x++;
                if ($digit[$y][$x] == '1') {
                    $z = $x;
                    while(($z + 1 <$columns) && ($digit[$y][$z + 1] == '1')) {
                        $z++;
                    }
                    $x1 = $x * $mw;
                    $y1 = $y * $mh;
                    $x2 = ($z + 1) * $mw;
                    $y2 = ($y + 1) * $mh;
                    self::_rotate($x1, $y1, $cos, $sin, $xA, $yA);
                    self::_rotate($x2, $y1, $cos, $sin, $xB, $yB);
                    self::_rotate($x2, $y2, $cos, $sin, $xC, $yC);
                    self::_rotate($x1, $y2, $cos, $sin, $xD, $yD);
                    $fn(array(
                        $xA + $xi, $yA + $yi,
                        $xB + $xi, $yB + $yi,
                        $xC + $xi, $yC + $yi,
                        $xD + $xi, $yD + $yi
                    ));
                    $x = $z + 1;
                }
            }
        }
        return self::result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin);
    }	
	static private function _rotate($x1, $y1, $cos, $sin , &$x, &$y){
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }	
	static private function result($xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin){
        self::_rotate(0, 0, $cos, $sin , $x1, $y1);
        self::_rotate($columns * $mw, 0, $cos, $sin , $x2, $y2);
        self::_rotate($columns * $mw, $lines * $mh, $cos, $sin , $x3, $y3);
        self::_rotate(0, $lines * $mh, $cos, $sin , $x4, $y4);
        return array(
            'width' => $columns * $mw,
            'height'=> $lines * $mh,
            'p1' => array(
                'x' => $xi + $x1,
                'y' => $yi + $y1
            ),
            'p2' => array(
                'x' => $xi + $x2,
                'y' => $yi + $y2
            ),
            'p3' => array(
                'x' => $xi + $x3,
                'y' => $yi + $y3
            ),
            'p4' => array(
                'x' => $xi + $x4,
                'y' => $yi + $y4
            )
        );
    }	
	static private $encoding = array(
        '11011001100', '11001101100', '11001100110', '10010011000',
        '10010001100', '10001001100', '10011001000', '10011000100',
        '10001100100', '11001001000', '11001000100', '11000100100',
        '10110011100', '10011011100', '10011001110', '10111001100',
        '10011101100', '10011100110', '11001110010', '11001011100',
        '11001001110', '11011100100', '11001110100', '11101101110',
        '11101001100', '11100101100', '11100100110', '11101100100',
        '11100110100', '11100110010', '11011011000', '11011000110',
        '11000110110', '10100011000', '10001011000', '10001000110',
        '10110001000', '10001101000', '10001100010', '11010001000',
        '11000101000', '11000100010', '10110111000', '10110001110',
        '10001101110', '10111011000', '10111000110', '10001110110',
        '11101110110', '11010001110', '11000101110', '11011101000',
        '11011100010', '11011101110', '11101011000', '11101000110',
        '11100010110', '11101101000', '11101100010', '11100011010',
        '11101111010', '11001000010', '11110001010', '10100110000',
        '10100001100', '10010110000', '10010000110', '10000101100',
        '10000100110', '10110010000', '10110000100', '10011010000',
        '10011000010', '10000110100', '10000110010', '11000010010',
        '11001010000', '11110111010', '11000010100', '10001111010',
        '10100111100', '10010111100', '10010011110', '10111100100',
        '10011110100', '10011110010', '11110100100', '11110010100',
        '11110010010', '11011011110', '11011110110', '11110110110',
        '10101111000', '10100011110', '10001011110', '10111101000',
        '10111100010', '11110101000', '11110100010', '10111011110',
        '10111101110', '11101011110', '11110101110', '11010000100',
        '11010010000', '11010011100', '11000111010');
		
    static public function getDigit($code){
        $tableB = " !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~";
        $result = "";
        $sum = 0;
        $isum = 0;
        $i = 0;
        $j = 0;
        $value = 0;

        // check each characters
        $len = strlen($code);
        for($i=0; $i<$len; $i++){
            if (strpos($tableB, $code[$i]) === false) return("");
        }

        // check firsts characters : start with C table only if enought numeric
        $tableCActivated = $len> 1;
        $c = '';
        for($i=0; $i<3 && $i<$len; $i++){
            $tableCActivated &= preg_match('`[0-9]`', $code[$i]);
        }

        $sum = $tableCActivated ? 105 : 104;

        // start : [105] : C table or [104] : B table
        $result = self::$encoding[ $sum ];

        $i = 0;
        while( $i < $len ){
            if (! $tableCActivated){
                $j = 0;
                // check next character to activate C table if interresting
                while ( ($i + $j < $len) && preg_match('`[0-9]`', $code[$i+$j]) ) $j++;

                // 6 min everywhere or 4 mini at the end
                $tableCActivated = ($j > 5) || (($i + $j - 1 == $len) && ($j > 3));

                if ( $tableCActivated ){
                    $result .= self::$encoding[ 99 ]; // C table
                    $sum += ++$isum * 99;
                }
                // 2 min for table C so need table B
            } else if ( ($i == $len - 1) || (preg_match('`[^0-9]`', $code[$i])) || (preg_match('`[^0-9]`', $code[$i+1])) ) { //todo : verifier le JS : len - 1!!! XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                $tableCActivated = false;
                $result .= self::$encoding[ 100 ]; // B table
                $sum += ++$isum * 100;
            }

            if ( $tableCActivated ) {
                $value = intval(substr($code, $i, 2)); // Add two characters (numeric)
                $i += 2;
            } else {
                $value = strpos($tableB, $code[$i]); // Add one character
                $i++;
            }
            $result  .= self::$encoding[ $value ];
            $sum += ++$isum * $value;
        }

        // Add CRC
        $result  .= self::$encoding[ $sum % 103 ];
        // Stop
        $result .= self::$encoding[ 106 ];
        // Termination bar
        $result .= '11';
        return($result);
    }
	//End Of Lib Barcode
}
?>