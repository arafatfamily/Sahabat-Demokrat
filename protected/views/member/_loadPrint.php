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
$home_number = $model->home_number ? " NO. " . $model->home_number : "";
$rt = $model->rt ? " RT. " . $model->rt : "";
$rw = $model->rw ? " RW. " . $model->rw : "";
$address = $model->is_domisili == 'Y' ? $model->address : $model->member_address;
$address_raw = $address . $home_number . $rt . $rw . " Kel. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kel") . " Kec. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kec") . " " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab");

imagettftext($image, 19, 0, 260, 250, $white, $font, $identity_number);
imagettftext($image, 19, 0, 260, 290, $white, $font, $name);
imagettftext($image, 19, 0, 260, 330, $white, $font, $birth);
$address_1 = strtoupper(wordwrap($address_raw, 32, "\n"));
imagettftext($image, 19, 0, 260, 370, $white, $font, ": ");
imagettftext($image, 19, 0, 270, 370, $white, $font, $address_1);

header('Content-Type: ' . $foto->photo_type);
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

$width = 275;
$height = 60;
$quality = 100;
$text = $model->membership_id;
$location = $imagePath . 'tmp/bc.jpg';

Yii::import("application.extensions.barcode.*");
try {
    $imgbc = barcode::Barcode39($model->membership_id, $width, $height, $quality, $text, $location);
} catch (Exception $exc) {
    echo "No KTA Terlalu Panjang Untuk Ganerate Barcode";
    exit;
}
$barcode = imagecreatefromjpeg($location);
$marge_right = 240;
$marge_bottom = 10;
$sx = imagesx($barcode);
$sy = imagesy($barcode);
imagecopymerge($image, $barcode, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, 240, 60, 100);
imagepng($image, $imagePath . 'tmp/' . $model->membership_id . '_back.png');
echo "<div class='pagebreak'></div>";
echo CHtml::image(Yii::app()->request->baseUrl.'/assets/tmp/' . $model->membership_id . '_back.png', '', array('width'=>'100%'));
imagedestroy($image);
//unlink($imagePath . 'tmp/' . $model->membership_id . '_back.png');
?>