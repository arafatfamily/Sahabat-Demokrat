<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<style type="text/css">
.gllpMap	{ width: 93%; height: 250px; }
</style>
<div class="col-lg-4">
	<section class="box info">
		<header class="panel_header">
			<h2 class="title pull-left">Profil Kader</h2>
			<div class="actions panel_actions pull-right">
				<span class="badge badge-danger"><i class="fa fa-print" data-toggle="modal" href="#logPrint"></i><?php echo Globals::Jumlah('LogPrint','status','PRINT KTA',$model->id); ?> X</span>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<center>
						<img class="img-thumbnail img-responsive img-circle" src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $model->id)) ?>">
						<h3 class="text-uppercase"><b><?php echo $model->member_name; ?></b></h3>
						<h4 class="text-uppercase"><?php echo "DPD " . Member::getKabProvKec($model->member_sub_district_id, "nama_prov") . "</br>DPC " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab") ?></h4>
						<?php if (Yii::app()->user->getAkses('47', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('BLOKIR KADER', array('id'=>'btn-blokir', 'class'=>'btn btn-danger btn-corner btn-block', 'onclick'=>'blokirKader()')); } if (Yii::app()->user->getAkses('5', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('CETAK KTA KADER', array('id'=>'btn-cetak', 'class'=>'btn btn-primary btn-corner btn-block', 'onclick'=>'printKTA()')); } if (Yii::app()->user->getAkses('3', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('EDIT PROFIL KADER', array('id'=>'btn-ubah', 'class'=>'btn btn-success btn-corner btn-block', 'submit'=>array('member/ubah/'.$model->id))); } ?></br>
						<img class="img-rounded img-responsive" src="<?php echo Yii::app()->controller->createUrl("member/loadKtp", array("id" => $model->id)) ?>">
					</center>
				</div>
			</div>
		</div>
	</section>
	<?php if (Yii::app()->user->getAkses('14', '3') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Alamat Kader</h2>
			<div class="actions panel_actions pull-right">
				<i class="box_toggle fa fa-chevron-down"></i>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
			<?php
			$this->widget('ext.useLocationPicker.AddressLocation', array(
				'model' => Lokasi::model()->findByPk($model->id),
				'latId' => "address_lat",
				'lonId' => "address_lon",
			));
			?>
			</div>
		</div>
	</section>
	<?php } if (Yii::app()->user->getAkses('10', '2') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Data Dokumen Kader</h2>
			<div class="actions panel_actions pull-right">
				<i class="box_toggle fa fa-chevron-down"></i>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
					<img class="img-thumbnail img-responsive" src="<?php echo Yii::app()->controller->createUrl("member/loadKtp", array("id" => $model->id)) ?>">
			</div>
		</div>
	</section>
	<?php } ?>
</div>
<div class="col-lg-8">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Data Kader</h2>
			<div class="actions panel_actions pull-right">
				<?php if (Yii::app()->user->getAkses("1", "12") || Yii::app()->user->isSuperadmin()) {
				echo '<button class="btn btn-md btn-rounded btn-success" onclick="goPendaftaran()" type="button"><span class="fa fa-plus-square"></span>&nbsp;Pendaftaran Kader&nbsp;</button>'; 
				} if (Yii::app()->user->getAkses('6', '2') || Yii::app()->user->isSuperadmin()) {
					echo ' <button class="btn btn-rounded btn-md btn-warning" onclick="printProfil()" type="button"><span class="fa fa-print"></span></button>';
				} ?>
			</div>
		</header>
		<style type="text/css">
		th {
			text-align: left !important;
		}
		</style>
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data' => $model,
					//'cssFile' => Yii::app()->theme->baseUrl."/css+js/style.css",
					'attributes' => array(
						array(
							'label' => 'Referensi',
							'name' => 'reference',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->reference . " ( " . Globals::findByRef("member","member_name","membership_id='" . $model->reference . "'") . " )"
						),
						array(
							'label' => 'No KTA',
							'name' => 'membership_id',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
						),
						array(
							'label' => 'D P D',
							'name' => 'member_sub_district_id',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_prov") : Member::getKabProvKec($model->member_sub_district_id, "nama_prov")
						),
						array(
							'label' => 'D P C',
							'name' => 'member_sub_district_id',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_kab") : Member::getKabProvKec($model->member_sub_district_id, "nama_kab")
						),
						array(
							'label' => 'Jabatan',
							'name' => 'is_have_position',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'visible' => $model->is_have_position == 'Y',
							'value' => Member::getLvlPosisiJabatan($model->id, 'nama_jab') . " " . Member::getLvlPosisiJabatan($model->id, 'nama_pos') . "</br>" . Member::getLvlPosisiJabatan($model->id, 'nama_lvl')
						),
						array(
							'label' => 'Jabatan Lain',
							'name' => 'is_other_position',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'visible' => $model->is_other_position == 'Y',
							'value' => Member::getLvlPosisiJabatan2($model->id, 'nama_jab') . " " . Member::getLvlPosisiJabatan2($model->id, 'nama_pos') . "</br>" . Member::getLvlPosisiJabatan2($model->id, 'nama_lvl')
						),
						array(
							'label' => 'Nama',
							'name' => 'member_name',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
						),
						array(
							'label' => 'Jenis Kelamin',
							'name' => 'gender',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => ($model->gender == "L" ? "Laki - Laki" : "Perempuan") . "<p class='pull-right' style='display: inline; margin-bottom: 0px; margin-right: 40%;'><b>Agama : </b>" . $model->religion . "</p>"
						),
						array(
							'label' => 'Agama',
							'name' => 'religion',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'type' => 'raw',
							'value' => $model->religion,
							'htmlOptions' => array('style' => 'width:50px;text-align: center;'),
						),
						array(
							'label' => 'Phone',
							'name' => 'cellular_phone_number',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->cellular_phone_number . "<p class='pull-right' style='display: " . ($model->home_number == null ? 'none' : 'inline') . "; margin-bottom: 0px; margin-right: 40%;'><b>No. Telp : </b>" . $model->home_phone_number . "</p>"
						),
						array(
							'label' => 'Tempat/Tanggal Lahir',
							'name' => 'birth_place',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->birth_place . " / " . Globals::dateIndonesia($model->date_of_birth)
						),
						array(
							'label' => 'Status Kawin',
							'name' => 'is_married',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->is_married == "Y" ? "Menikah" : ($model->is_married == "N" ? "Belum Menikah" : ($model->gender == "L" ? "Duda" : "Janda")) . "<p class='pull-right' style='display: inline; margin-bottom: 0px; margin-right: 40%;'><b>Golongan Darah : </b>" . $model->blood_type . "</p>"
						),
						'occupation',
						'couple_name',
						'children_name',
						array(
							'label' => 'Alamat',
							'name' => 'address',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->is_domisili == "Y" ? $model->address . " " . $model->home_number . " RT " . $model->rt . " RW " . $model->rw . ", KEL. " . Member::getKabProvKec($model->sub_district_id, "nama_kel") . ", KEC. " . Member::getKabProvKec($model->sub_district_id, "nama_kec") .  " <br/> " . Member::getKabProvKec($model->sub_district_id, "nama_kab") . ", PROV. " . Member::getKabProvKec($model->sub_district_id, "nama_prov") . " - " . $model->postal_code : $model->member_address . " " . $model->member_home_number . " RT " . $model->member_rt . " RW " . $model->member_rw . ", KEL. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kel") . ", KEC. " . Member::getKabProvKec($model->member_sub_district_id, "nama_kec") .  " <br/> " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab") . ", PROV. " . Member::getKabProvKec($model->member_sub_district_id, "nama_prov") . " - " . $model->member_postal_code
						),
						array(
							'label' => 'Alamat Surel',
							'name' => 'email',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->email != NULL ? "<a href='mailto:" . $model->email . "'>" . $model->email . "</a>" : ""
						),
						array(
							'label' => 'Facebook Profil',
							'name' => 'facebook',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->facebook != NULL ? "<a href='https://facebook.com/" . $model->facebook . "'>https://facebook.com/" . $model->facebook . "</a>" : ""
						),
						array(
							'label' => 'Twitter Profil',
							'name' => 'twitter',
							'type' => 'raw',
							'headerHtmlOptions' => array('style' => 'text-align: left;'),
							'value' => $model->twitter != NULL ? "<a href='https://twitter.com/" . $model->twitter . "'>https://twitter.com/" . $model->twitter . "</a>" : ""
						),
					),
				)); ?>
				</div>
			</div>
		</div>
	</section>
	<?php if (Yii::app()->user->getAkses('11', '2') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box">
        <div class="content-body">
            <div class="form-group">
                <div class="col-lg-6"><input type="text" id="card_uid" class="form-control" autofocus=true/></div>
                <div  class="col-lg-6"><input type="text" id="card_uid_result" class="form-control" readonly=true disabled=true/></div>
            </div>
        </div><div class="clearfix"></div>
    </section>
	<?php } if (Yii::app()->user->getAkses('9', '2') || Yii::app()->user->isSuperadmin()) { ?>
    <section class="box">
        <header class="panel_header"> <h2 class="title pull-left">UNGGAH DOKUMEN KADER</h2></header>
        <div class="content-body">
			<div class="form-group col-sm-12">
				<div class="col-lg-2">Nama Dokumen</div>
				<div class="col-lg-4"><input type="text" id="doc_name" class="form-control" placeholder="ex. SK DPP Tahun 2016"/></div>
				<div class="col-lg-2">Nomor Dokumen</div>
				<div class="col-lg-4"><input type="text" id="doc_num" class="form-control" placeholder="ex. 01/SK/DPP.PD/DPD/IV/2016"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Dikeluarkan Oleh</div>
				<div class="col-lg-6"><input type="text" id="doc_by" class="form-control" placeholder="ex. Dewan Pimpinan Pusat Partai Demokrat"/></div>
				<div class="col-lg-2">Pada Tahun</div>
				<div class="col-lg-2"><input type="text" id="doc_years" class="form-control" placeholder="2016"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Keterangan</div>
				<div class="col-lg-10"><textarea class="form-control autogrow" cols="5" id="doc_info" placeholder="ex. SK DPP PD Tahun 2016 Tentang Susunan Pelaksanaan Tugas" style="overflow: hidden; word-wrap: break-word;"></textarea></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Lampiran</div>
				<div class="col-lg-10"><input type="file" id="doc_files" class="form-control"/></div>
				<div  class="col-lg-12" style="margin-top:10px;">
					<button class="btn btn-primary btn-block" onclick="uploadDokument()" type="button">TAMBAH</button>
				</div>
            </div><div class="clearfix"></div>
		</div>
    </section>
	<?php } if (Yii::app()->user->getAkses('12', '2') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box">
        <header class="panel_header"> <h2 class="title pull-left">REKAM JEJAK KADER</h2></header>
        <div class="content-body">
			<div class="form-group">
				<div class="col-lg-2">Judul</div>
				<div class="col-lg-10"><input type="text" id="rekamjejak" class="form-control"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Keterangan</div>
				<div class="col-lg-10">
					<textarea class="form-control autogrow" cols="5" id="isi" placeholder="" style="overflow: hidden; word-wrap: break-word;"></textarea>
				</div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Lampiran</div>
				<div class="col-lg-10"><input type="file" id="isi" class="form-control"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div  class="col-lg-12" style="margin-top:10px;"> 
					<button class="btn btn-primary btn-block" onclick="rekamjejak()" type="button">TAMBAH</button>
				</div>
			</div><div class="clearfix"></div>
		</div>
	</section>
	<?php } ?>
</div>
<div class="modal fade" id="logPrint" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">INFORMASI HISTORI CETAK KTA KADER</h4>
			</div>
			<div class="modal-body">

				Loading...

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function goPendaftaran() {
	window.location.href = "<?php echo CController::createUrl('member/tambah') ?>";
}
$("#card_uid").keyup(function () {
    $.ajax({
        url: "<?php echo CController::createUrl('member/setUid') ?>",
        type: 'POST',
        data: {id: '<?php echo $model->id; ?>', value: $("#card_uid").val()},
        success: function (data) {
            var obj = $.parseJSON(data);
            if (obj.success) {
                $("#card_uid_result").val(obj.value);
            }
        },
    });
});
function printProfil() {
	var myWindow = window.open('<?php echo Yii::app()->controller->createUrl('member/print', array('id' => $model->id)) ?>', '', '');

	myWindow.document.close();
	myWindow.focus();
	myWindow.print();
}
function blokirKader() {
    $.ajax({
        url: "<?php echo CController::createUrl('member/tolak') ?>",
        type: 'POST',
        data: {id:"<?php echo $model->id; ?>"},
		dataType: 'json',
        success: function (data) {
            var obj = $.parseJSON(data);
        },
    });
}
function statusPrintAuto() {
    $.ajax({
        url: "<?php echo CController::createUrl('member/statusprint') ?>",
        type: 'POST',
        data: {id:"<?php echo $model->id; ?>"},
		dataType: 'json',
        success: function (data) {
			JSON.stringify(data);
            //var obj = $.parseJSON(data);
        },
    });
}
function printKTA() {
    statusPrintAuto();
    var myWindow = window.open('<?php echo Yii::app()->controller->createUrl('member/cetak', array('id' => $model->id)) ?>', '', '');

    myWindow.document.close();
    myWindow.focus();
    myWindow.print();
    $('#is_print').prop('checked', true);
    //myWindow.close();
}
$(document).ready(function () {
        $('#card_uid_result').val("<?php echo $model->CARD_UID; ?>");
    });
</script>
