<style type="text/css">
.pagebreak { page-break-before: always; }
body{
	margin: 0;
}
@media print{
	@page {
		size:85.6mm 54mm
	}
	@page rotated { size : landscape }
	margin: 0;
}
</style>
<?php
$imagePath = Yii::app()->basePath . '/../assets/';
$template = UsersImg::model()->findByPk($admin->users_id);
$foto = MemberPhoto::model()->findByPk($model->id);
$image = imagecreatefromstring($template->template_dpn);
$white = imagecolorallocate($image, 255, 255, 255);
$font = $imagePath . 'font/roboto.ttf';
$no_kta = "No. KTA"; $nama = "Nama"; $lahir = "Tempat/Tgl Lahir"; $alamat = "Alamat"; $tgl_cetak = "Tgl. Cetak: " . date('d-m-Y');
imagettftext($image, 19, 0, 50, 250, $white, $font, $no_kta);
imagettftext($image, 19, 0, 50, 290, $white, $font, $nama);
imagettftext($image, 19, 0, 50, 330, $white, $font, $lahir);
imagettftext($image, 19, 0, 50, 370, $white, $font, $alamat);
imagettftext($image, 14, 0, 775, 438, $white, $font, $tgl_cetak);

$identity_number = ": " . $model->membership_id;
$name = strtoupper(": " . $model->member_name);
$birth = strtoupper(": " . $model->birth_place . ", " . Globals::dateIndonesia($model->date_of_birth));
$no_rmh = $model->is_domisili == 'Y' ? $model->home_number : $model->member_home_number;
$no_rt = $model->is_domisili == 'Y' ? $model->rt : $model->member_rt;
$no_rw = $model->is_domisili == 'Y' ? $model->rw : $model->member_rw;
$home_number = $no_rmh ? " NO. " . $no_rmh : "";
$rt = $no_rt ? " RT. " . $no_rt : "";
$rw = $no_rw ? " RW. " . $no_rw : "";
$address = $model->is_domisili == 'Y' ? $model->address : $model->member_address;
$address_raw = $address . $home_number . $rt . $rw . " Kel. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kel") . " Kec. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kec") . " " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab");

imagettftext($image, 19, 0, 260, 250, $white, $font, $identity_number);
imagettftext($image, 19, 0, 260, 290, $white, $font, $name);
imagettftext($image, 19, 0, 260, 330, $white, $font, $birth);
$address_1 = strtoupper(wordwrap($address_raw, 32, "\n"));
imagettftext($image, 19, 0, 260, 370, $white, $font, ": ");
imagettftext($image, 19, 0, 270, 370, $white, $font, $address_1);

//header('Content-Type: ' . $foto->photo_type);
$file_ext = $foto->photo_type;
$photo = imagecreatefromstring($foto->img_photo);
$marge_right = -15;
$marge_bottom = 120;
$sx = imagesx($photo);
$sy = imagesy($photo);
imagecopyresampled($image, $photo, 790, 210, 0, 0, 165, 198, imagesx($photo), imagesy($photo));
imagepng($image, $imagePath . 'tmp/' . $model->membership_id . '_front.png');
$MemberID = $model->id;
$imgKTA = MemberCard::model()->findByPk($MemberID);
if (!$imgKTA) {
	$imgKTA = new MemberCard;
} $blobKTA = "";
$imgKTA->member_id = $MemberID;
$filename = $imagePath . 'tmp/' . $model->membership_id . '_front.png';
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));
fclose($handle);
$imgKTA->img_photo = $contents;
if ($imgKTA->save()) {
	unlink($imagePath . 'tmp/' . $model->membership_id . '_front.png');
}
echo CHtml::image($this->createUrl('member/loadkta') . '/' . $MemberID, '', array('width'=>'100%'));
imagedestroy($image);

$image = imagecreatefromstring($template->template_blk);
$bc_src = imagecreatetruecolor(290, 70);
$putih = ImageColorAllocate($bc_src,0xff,0xff,0xff);
$hitam = ImageColorAllocate($bc_src,0x00,0x00,0x00);
$rotation = 0; //Rotasi Barcode
imagefilledrectangle($bc_src, 0, 0, 290, 70, $putih);
$data = Globals::gd($bc_src, $hitam, 145, 35, $rotation, 'code128', array('code'=>$model->membership_id), 3, 65);
if (imagejpeg($bc_src, $imagePath . 'tmp/bc_' . $model->membership_id . '.source', 100)) {
	imagedestroy($bc_src);
	$barcode = imagecreatefromjpeg($imagePath . 'tmp/bc_' . $model->membership_id . '.source');	
}
$dstX = imagesx($image) - imagesx($barcode) - 230;
$dstY = imagesy($image) - imagesy($barcode) - 10;
imagecopymerge($image, $barcode, $dstX, $dstY, 0, 0, 290, 70, 100);
imagepng($image, $imagePath . 'tmp/temp_' . $model->membership_id . '.png');
echo "<div class='pagebreak'></div>";
echo CHtml::image(Yii::app()->request->baseUrl.'/assets/tmp/temp_' . $model->membership_id . '.png', '', array('width'=>'100%'));
imagedestroy($image);
if ($handle = opendir($imagePath . 'tmp/')) {
	while (false !== ($file = readdir($handle))) {
		if ((time()-filectime($imagePath . 'tmp/'.$file)) > 7200) {
		   if (preg_match('/\.png$/i', $file) || preg_match('/\.jpg$/i', $file) || preg_match('/\.jpeg$/i', $file) || preg_match('/\.source$/i', $file)) {
			  unlink($imagePath . 'tmp/'.$file);
		   }
		}
	}
}
?>