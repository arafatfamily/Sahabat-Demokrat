<script src="https://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="screen"/>
<style type="text/css">
.gllpMap	{ width: 93%; height: 250px; }
</style>
<div class="col-lg-4">
	<section class="box info">
		<header class="panel_header">
			<h2 class="title pull-left">Profil Kader</h2>
			<div class="actions panel_actions pull-right">
				<a data-toggle="modal" href="#memberLog" onclick="loadLog('Input')">
					<span class="badge badge-danger">
						<i class="fa fa-history"></i><?php echo Globals::Jumlah('LogInput','member_id',$model->id,null); ?> X
						<i class="fa fa-print"></i><?php echo Globals::Jumlah('LogPrint','status','PRINT KTA',$model->id); ?> X
					</span>
				</a>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<center>
						<img id="<?php echo $model->membership_id; ?>" class="img-thumbnail img-responsive img-circle" src="<?php echo MemberPhoto::model()->findByPk($model->id) == NULL ? Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "default_profile_".$model->gender)) : Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $model->id)) ?>">
						<h3 class="text-uppercase"><b><?php echo $model->member_name; ?></b></h3>
						<h4 class="text-uppercase"><?php echo "DPD " . Member::getKabProvKec($model->member_sub_district_id, "nama_prov") . "</br>DPC " . Member::getKabProvKec($model->member_sub_district_id, "nama_kab") ?></h4>
						<div class="panel" style="display: <?php echo $model->member_status == 'A' ? 'block' : 'none'; ?>;">
						<?php if (Yii::app()->user->getAkses('47', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('BLOKIR KADER', array('id'=>'btn-blokir', 'class'=>'btn btn-danger btn-corner btn-block', 'onclick'=>'blokirKader()')); } if (Yii::app()->user->getAkses('5', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('CETAK KTA KADER', array('id'=>'btn-cetak', 'class'=>'btn btn-primary btn-corner btn-block', 'onclick'=>'printKTA()')); } if (Yii::app()->user->getAkses('3', '2') || Yii::app()->user->isSuperadmin()) { 
						 echo CHtml::button('EDIT PROFIL KADER', array('id'=>'btn-ubah', 'class'=>'btn btn-success btn-corner btn-block', 'submit'=>array('member/ubah/'.$model->id))); } ?>
						 </div>
						 <div class="panel" style="display: <?php echo $model->member_status != 'A' ? 'block' : 'none'; ?>;">
						 <?php if (Yii::app()->user->getAkses('39', '13') || Yii::app()->user->isSuperadmin()) {
						 echo CHtml::button('TERIMA KADER', array('id'=>'btn-blokir', 'class'=>'btn btn-success btn-corner btn-block', 'onclick'=>'alert("ON PROGRESS")')); } if (Yii::app()->user->getAkses('47', '2') || Yii::app()->user->isSuperadmin()) {
						 echo CHtml::button('TOLAK KADER', array('id'=>'btn-blokir', 'class'=>'btn btn-danger btn-corner btn-block', 'onclick'=>'blokirKader()')); } ?>
						 </div>
						 </br>
						<img class="img-rounded img-responsive" src="<?php echo MemberPhoto::model()->findByPk($model->id) == NULL ? Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "default_identitas")) : Yii::app()->controller->createUrl("member/loadKtp", array("id" => $model->id)) ?>">
					</center>
				</div>
			</div>
		</div>
	</section>
	<?php if (Yii::app()->user->getAkses('14', '3') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box " style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
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
	<section class="box " style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
		<header class="panel_header">
			<h2 class="title pull-left">Data Dokumen Kader</h2>
			<div class="actions panel_actions pull-right">
				<i class="box_toggle fa fa-chevron-down"></i>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
				Loading ...
			</div>
		</div>
	</section>
	<?php } ?>
</div>
<div class="col-lg-8">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Data Kader</h2>
			<div class="actions panel_actions pull-right" style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
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
	<section class="box" style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
        <div class="content-body">
            <div class="form-group">
                <div class="col-lg-6"><input type="text" id="card_uid" class="form-control" autofocus=true/></div>
                <div  class="col-lg-6"><input type="text" id="card_uid_result" class="form-control" readonly=true disabled=true/></div>
            </div>
        </div><div class="clearfix"></div>
    </section>
	<?php } if (Yii::app()->user->getAkses('9', '2') || Yii::app()->user->isSuperadmin()) { ?>
    <section class="box" style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
        <header class="panel_header"> <h2 class="title pull-left">UNGGAH DOKUMEN KADER</h2></header>
        <div class="content-body">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'member-dokumen',
			'action' => Yii::app()->createUrl('member/dokumen', array("id"=>$model->id)),
			'method'=>'POST',
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data',
			)
		)); ?>
			<div class="form-group col-sm-12">
				<div class="col-lg-2">Nama Dokumen</div>
				<div class="col-lg-4"><input type="text" name="doc_name" class="form-control" placeholder="ex. SK DPP Tahun 2016"/></div>
				<div class="col-lg-2">Nomor Dokumen</div>
				<div class="col-lg-4"><input type="text" name="doc_num" class="form-control" placeholder="ex. 01/SK/DPP.PD/DPD/IV/2016"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Dikeluarkan Oleh</div>
				<div class="col-lg-6"><input type="text" name="doc_by" class="form-control" placeholder="ex. Dewan Pimpinan Pusat Partai Demokrat"/></div>
				<div class="col-lg-2">Pada Tahun</div>
				<div class="col-lg-2"><input type="text" name="doc_years" class="form-control" placeholder="2016"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Keterangan</div>
				<div class="col-lg-10"><textarea class="form-control autogrow" cols="5" name="doc_info" placeholder="ex. SK DPP PD Tahun 2016 Tentang Susunan Pelaksanaan Tugas" style="overflow: hidden; word-wrap: break-word;"></textarea></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-2">Lampiran</div>
				<div class="col-lg-10"><input type="file" name="doc_files" class="form-control"/></div>
			<div class="clearfix" style="margin-bottom:10px;"></div>
				<div class="col-lg-8 pull-right">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN', array('class' => 'btn btn-primary btn-block pull-right')); ?>
				</div>
            </div><div class="clearfix"></div>
		<?php $this->endWidget(); ?>
		</div>
    </section>
	<?php } if (Yii::app()->user->getAkses('12', '2') || Yii::app()->user->isSuperadmin()) { ?>
	<section class="box" style="display: <?php echo $model->member_status == 'N' ? 'none' : 'block'; ?>;">
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
<div class="modal fade" id="memberLog" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
	<div class="modal-dialog" style="width: 75%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-uppercase bold">INFORMASI PERUBAHAN DATA DAN CETAK KTA <?php echo $model->member_name; ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<ul class="nav nav-tabs nav-justified primary">
							<li class="active"><a href="#logInput" data-toggle="tab"><i class="fa fa-history"></i> PERUBAHAN DATA</a></li>
							<li><a href="#logPrint" data-toggle="tab"><i class="fa fa-print"></i> CETAK KTA & PROFIL</a></li>
						</ul>
						<div class="tab-content primary">
							<div class="tab-pane fade in active" id="logInput">
								<div class="col-md-12">
									<table id="rLogInput" class="display table table-hover table-condensed" cellspacing="0" width="100%"></table>
								</div>
							</div>
							<div class="tab-pane fade" id="logPrint">
								<div class="col-md-12">
									<table id="rLogCetak" class="display table table-hover table-condensed" cellspacing="0" width="100%"></table>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>						
					</div>
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">TUTUP</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.js"></script>
<?php
$ft = MemberPhoto::model()->findByPk($model->id);
$tpl = UsersImg::model()->findByPk(Yii::app()->user->getUser("users_id"));
$xFT = $ft['img_photo'] != NULL ? "1" : "0";
$xTPL = $tpl['template_dpn'] !=NULL ? "1" : "0";
?>
<script type="text/javascript">
function goPendaftaran() {
	window.location.href = "<?php echo CController::createUrl('member/tambah') ?>";
}
$("#card_uid").keypress(function (e) {
	if (e.which == 13) {
		$.ajax({
			url: "<?php echo CController::createUrl('member/setUid') ?>",
			type: 'POST',
			data: {id: '<?php echo $model->id; ?>', value: $("#card_uid").val()},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$("#card_uid_result").val(data.value);
			},
		});
    }
});
function loadLog(data) {
	$.ajax({
        url: "<?php echo CController::createUrl('member/getlog') ?>",
        type: 'POST',
        data: {id: "<?php echo $model->id; ?>", data: data},
		dataType: 'json',
        success: function (e) {
			var json = [];
			for (var i = 0; i < e.data.length; i++) {
				if(data == 'Input') {
					json.push([
						e.data[i].date_time,
						e.data[i].username.toUpperCase(),
						e.data[i].act_type,
						e.data[i].act_info.toUpperCase(),
						e.data[i].ip_address
					]);
				} else {
					json.push([
						e.data[i].date_print,
						e.data[i].username.toUpperCase(),
						e.data[i].status,
						e.data[i].print_type.toUpperCase(),
						e.data[i].ip_address
					]);
				}
			}
			$('#rLog' + data).DataTable({
				"paging": false,
				"ordering": false,
				"info": false,
				"searching": false,
				"destroy": true,
				"language": {
					"search": "Cari:",
					"emptyTable": "Tidak ada data !",
				},
				"data": eval(JSON.stringify(json)),
				"columns": [
					{"title": "TANGGAL"},
					{"title": "ADMIN"},
					{"title": "TINDAKAN"},
					{"title": "KETERANGAN"},
					{"title": "JARINGAN"}
				]
			});
        },
		complete: function() {
			if(data == 'Input') {
				loadLog('Cetak');
			}
		}
    });
}
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
			$('#is_print').prop('checked', true);
        },
    });
}
function printKTA() {
	if ("<?php echo $xFT ?>" == "0") {
		alert("Maaf Kader ini belum memiliki foto untuk KTA !");
	} else if ("<?php echo $xTPL ?>" == "0") {
		alert("Maaf Anda belum memiliki template KTA !");
	} else {
		if (<?php echo Yii::app()->user->getuser("role_id") ?> <= 2) {
			var myWindow = window.open('<?php echo Yii::app()->controller->createUrl('member/cetak', array('id' => $model->id)) ?>', '', '');
			myWindow.document.close();
			myWindow.focus();
			myWindow.print();			
		} else {			
			w = window.open();
			//w.document.write('<title>Cetak KTA<?php echo $model->member_name ?></title>');
			w.document.write('<title>Cetak KTA</title>');
			w.document.write('<style type="text/css">.pagebreak { page-break-before: always; } body{margin: 0; } @media print{ @page { size:85.6mm 54mm	} @page rotated { size : landscape } margin: 0; }</style>');
			w.document.write('<img style="width: 100%" src="<?php echo Yii::app()->controller->createUrl('member/FrontKTA', array('id' => $model->id)) ?>" >');
			w.document.write('<img style="width: 100%" src="<?php echo Yii::app()->controller->createUrl('member/BackKTA', array('id' => $model->id)) ?>" >');
			w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
			w.document.close();
			w.focus();
		}
		statusPrintAuto();
	}
}
$(document).ready(function () {
        $('#card_uid_result').val("<?php echo $model->CARD_UID; ?>");
});
</script>
