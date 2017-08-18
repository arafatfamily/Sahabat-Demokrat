<?php Yii::import('ext.select2.Select2'); ?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.css" rel="stylesheet">
<div class="small-12 columns">
	<div class="page-title">
		<h2 class="title pull-left"><?php echo $model->isNewRecord ? 'Pendafataran Kader Demokrat' : 'Ubah Data Kader'; ?>
			<span class="badge badge-danger"> (*) Isian wajib di isi ! </span>
		</h2>
	</div>
</div>
<section id="main" class="medium-12 large-12 columns" style="padding-top: 15px;">
	<div class="content-body">
	    <div class="">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'member-form',
			'method'=>'POST',
			'enableAjaxValidation'=>true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
				'validateOnChange' => true
			),
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data',
			),
	        'focus'=>($model->hasErrors()) ? '.error:first' : array($model, 'title')
		)); echo $form->errorSummary($model);?>
		<div class="form-group">
			<div class="medium-12 columns">
			<?php echo $form->labelEx($model,'reference'); ?>
			<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model' => $model->reference,
				'value' => $model->reference,
				'name' => 'Member[reference]',
				'sourceUrl' => $this->createUrl('member/reference'),
				'options' => array(
					'showAnim' => 'fold',
					'minLength' => '3',
					'select' => 'js:function(event, ui) {$(this).val(ui.item.value);  return false;}'
				),
				'htmlOptions' => array(
					'class' => 'form-control', 'placeholder' => 'Masukan No. KTA Referensi'
				),
			)); echo $form->error($model,'reference'); ?>
			</div>
		</div>
		<div id="panel-info" class="form-group">
			<div class="medium-12 columns">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Data Kader Partai Demokrat </b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
	        </div>
			<!--div class="medium-3 columns">
			<label><!?php echo "Jenis Identitas *" ?></label><br/>
			<!?php echo $form->dropDownList( $posisi,'position_as', array('KTP' => 'KARTU TANDA PENDUDUK(KTP)','SIM' => 'SURAT UZUN MENGEMUDI (SIM)','PASSPORT' => 'PASSPORT'), array('class'=>'form-control', 'disabled'=>true)); ?>
			</div-->
			<div class="medium-12 columns">
			<label><?php echo "No. KTP / <strike>NO. SIM</strike> / <strike>NO. PASPOR</strike> *"; ?></label>
			<!--?php echo $form->labelEx($model,'identity_number'); ?-->
				<?php echo $form->textField($model,'identity_number',array('class'=>'form-control','onblur'=>'{readKTP(this.value)}','placeholder'=>'No. KTP (wajib 16 digit)')); ?>				
			</div>
			<div class="medium-12 columns">
			<?php echo $form->labelEx($model,'member_name'); ?>
				<?php echo $form->textField($model,'member_name',array('class'=>'form-control','placeholder'=>'Nama Calon Kader')); ?>
			</div>
			<div class="medium-6 columns">
			<?php echo $form->labelEx($model,'birth_place'); ?>
				<?php echo $form->textField($model,'birth_place',array('class'=>'form-control','placeholder'=>'Tempat Lahir (sesuai KTP)')); ?>
			</div>
			<div class="medium-6 columns">
			<?php echo $form->labelEx($model,'date_of_birth'); ?>
				<?php echo $form->textField($model,'date_of_birth',array('class'=>'form-control', 'data-mask'=>'date', 'placeholder'=>'Tanggal Lahir (sesuai KTP)')); ?>
			</div><div class="clearfix"></div>
			<div class="medium-3 columns">
			<?php echo $form->labelEx($model,'gender'); ?><br/>
			<?php echo $form->radioButtonList($model, 'gender', array("L" => 'Pria',"P" => 'Wanita'), array(
					'labelOptions' => array('class' => 'icheck-label form-label'),
					'separator' => ' ',)); ?>
			</div>
			<div class="medium-3 columns">
				<?php echo $form->labelEx($model, 'blood_type'); ?><br/>
				<?php echo $form->radioButtonList($model, 'blood_type', array("A" => 'A',"B" => 'B',"O" => 'O',"AB" => 'AB'), array(
					'labelOptions' => array('class' => 'icheck-label form-label'),
					'separator' => ' ',)); ?>   
			</div>
			<div class="medium-6 columns">
			<?php echo $form->labelEx($model,'is_married'); ?><br/>
			<?php echo $form->dropDownList($model,'is_married', array('Y' => 'MENIKAH','N' => 'BELUM MENIKAH','C' => 'JANDA / DUDA'), array('class'=>'form-control','onchange'=>'statusKader()')); ?>
			</div><div class="clearfix"></div>
			<div id="panel-couple_name" class="medium-6 columns" style="display: <?php echo ($model->is_married == 'Y' ? '' : 'none;'); ?>">
			<?php echo $form->labelEx($model,'couple_name'); ?>
				<?php echo $form->textField($model,'couple_name',array('class'=>'form-control','placeholder'=>'Nama Pasangan (suami/istri)')); ?>
			</div>
			<div id="panel-children" class="" style="display: none;">
			<?php echo $form->labelEx($model,'children_name'); ?>
				<?php echo $form->textField($model,'children_name',array('class'=>'form-control','placeholder'=>'Nama Anak (pisahkan dengan tanda koma (,) jika lebih dari 1')); ?>
			</div><div class="clearfix"></div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'religion'); ?><br/>
			<?php echo $form->dropDownList($model,'religion', array('ISLAM' => 'ISLAM','PROTESTAN' => 'PROTESTAN','KHATOLIK' => 'KHATOLIK','HINDU' => 'HINDU','BUDDHA' => 'BUDDHA','KONG HU CU' => 'KONG HU CU'), array('class'=>'form-control')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'last_education_id'); ?>
			<?php echo Select2::activeDropDownList($model, 'last_education_id', array('' => ''), array(
				'prompt' => 'PILIH PENDIDIKAN',
				'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'occupation'); ?>
				<?php echo $form->textField($model,'occupation',array('class'=>'form-control','placeholder'=>'Pekerjaan')); ?>
			</div>
		</div>
		<div id="domisili-ktp" class="form-group">
			<div class="medium-12 columns">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Data Domisili Kader Partai Demokrat </b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
	        </div>
			<div class="medium-6 columns">
				<label><?php echo "Propinsi (sesuai Kartu Identitas)"; ?></label>
				<?php echo Select2::dropDownList('provinsi', '', array('' => ''), array(
					'prompt' => 'PILIH PROVINSI',
					'value' => '',
					'onchange' => '{loadKabupaten()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="medium-6 columns">
				<label><?php echo "Kabupaten (sesuai Kartu Identitas)"; ?></label>
				<?php echo Select2::dropDownList('kabupaten', '', array('' => ''), array(
					'prompt' => 'PILIH KABUPATEN',
					'onchange' => '{loadKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="medium-6 columns">
				<label><?php echo "Kecamatan (sesuai Kartu Identitas)"; ?></label>
				<?php echo Select2::dropDownList('kecamatan', '', array('' => ''), array(
					'prompt' => 'PILIH KECAMATAN',
					'onchange' => '{loadKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="medium-6 columns">
			<?php echo $form->labelEx($model,'sub_district_id'); ?>
			<?php echo Select2::activeDropDownList($model, 'sub_district_id', array('' => ''), array(
				'prompt' => 'PILIH KELURAHAN',
				'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="medium-10 columns">
			<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textField($model,'address',array('class'=>'form-control','placeholder'=>'Alamat (Sesuai KTP)')); ?>
			</div>
			<div class="medium-2 columns">
			<?php echo $form->labelEx($model,'home_number'); ?>
			<?php echo $form->textField($model,'home_number',array('class'=>'form-control')); ?>
			</div>
			<div class="medium-3 columns">
			<?php echo $form->labelEx($model,'rt'); ?>
			<?php echo $form->textField($model,'rt',array('class'=>'form-control','placeholder'=>'RT (Sesuai KTP)')); ?>
			</div>
			<div class="medium-3 columns">
			<?php echo $form->labelEx($model,'rw'); ?>
			<?php echo $form->textField($model,'rw',array('class'=>'form-control','placeholder'=>'RW (Sesuai KTP)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'postal_code'); ?>
			<?php echo $form->textField($model,'postal_code',array('class'=>'form-control','placeholder'=>'Kode POS (Sesuai KTP)')); ?>
			</div>
			<div class="medium-2 columns" align="center">
			<?php echo $form->labelEx($model,'is_domisili'); ?>
			<?php echo $form->radioButtonList($model, 'is_domisili', array("Y" => 'YA',"N" => 'TIDAK'), array(
					'labelOptions' => array('class' => 'icheck-label form-label'),
					'separator' => ' ',)); ?>
			</div>
		</div>	
		<div id="panel-domisili" class="form-group" style="<?php echo ($model->is_domisili == 'Y' || $model->isNewRecord ? 'display:none;' : 'display:block;'); ?>">
			<div class="medium-12 columns">
				<div class="clearfix"></div></br>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
	        </div>
			<div class="medium-6 columns">
				<label><?php echo "Propinsi (sesuai Domisili)"; ?></label>
				<?php echo Select2::dropDownList('dpd', '', array('' => ''), array(
					'prompt' => 'PILIH PROVINSI',
					'value' => '',
					'onchange' => '{loadMemberKabupaten()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="medium-6 columns">
				<label><?php echo "Kabupaten (sesuai Domisili)"; ?></label>
				<?php echo Select2::dropDownList('dpc', '', array('' => ''), array(
					'prompt' => 'PILIH KABUPATEN',
					'onchange' => '{loadMemberKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="medium-6 columns">
				<label><?php echo "Kecamatan (sesuai Domisili)"; ?></label>
				<?php echo Select2::dropDownList('pac', '', array('' => ''), array(
					'prompt' => 'PILIH KECAMATAN',
					'onchange' => '{loadMemberKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="medium-6 columns">
			<?php echo $form->labelEx($model,'member_sub_district_id'); ?>
				<?php echo Select2::activeDropDownList($model, 'member_sub_district_id', array('' => ''), array(
				'prompt' => 'PILIH KELURAHAN',
				'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="medium-10 columns">
			<?php echo $form->labelEx($model,'member_address'); ?>
				<?php echo $form->textField($model,'member_address',array('class'=>'form-control','placeholder'=>'Alamat (sesuai domisili)')); ?>
			</div>
			<div class="medium-2 columns">
			<?php echo $form->labelEx($model,'member_home_number'); ?>
				<?php echo $form->textField($model,'member_home_number',array('class'=>'form-control')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'member_rt'); ?>
				<?php echo $form->textField($model,'member_rt',array('class'=>'form-control','placeholder'=>'RT (sesuai domisili)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'member_rw'); ?>
				<?php echo $form->textField($model,'member_rw',array('class'=>'form-control','placeholder'=>'RW (sesuai domisili)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'member_postal_code'); ?>
				<?php echo $form->textField($model,'member_postal_code',array('class'=>'form-control','placeholder'=>'Kode POS (sesuai domisili)')); ?>
			</div>
		</div>
		<div id="panel-kontak" class="form-group">
			<div class="medium-12 columns">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Informasi Kontak Kader Partai Demokrat </b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
	        </div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'home_phone_number'); ?>
				<?php echo $form->textField($model,'home_phone_number',array('class'=>'form-control','placeholder'=>'Masukan Nomor Telpon Rumah (jika ada)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'cellular_phone_number'); ?>
				<?php echo $form->textField($model,'cellular_phone_number',array('class'=>'form-control','placeholder'=>'Masukan Nomor Seluler (wajib)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'member_active_number'); ?>
				<?php echo $form->textField($model,'member_active_number',array('class'=>'form-control','placeholder'=>'Informasi Nomor Terverifikasi (otomatis)','disabled'=>'disabled')); ?>
			</div><div class="clearfix"></div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'Masukan Alamat Surel (jika ada)')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'facebook'); ?>		
			<?php echo $form->textField($model,'facebook',array('class'=>'form-control','aria-describedby'=>'fb-link','placeholder'=>'Masukan Profil Facebook')); ?>
			</div>
			<div class="medium-4 columns">
			<?php echo $form->labelEx($model,'twitter'); ?>
			<?php echo $form->textField($model,'twitter',array('class'=>'form-control','aria-describedby'=>'twitter-link','placeholder'=>'Masukan Username Twitter')); ?>
			<?php echo CHtml::hiddenField('identitas'); ?>
			<?php echo CHtml::hiddenField('photo'); ?>
			</div>
			<div class="medium-12 columns">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Dokumen Kader Partai Demokrat </b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
	        </div>
		</div>
		<div id="panel-dokument" class="form-group">
			<div class="medium-8 columns">
				<label>UNGGAH HASIL SCAN KTP/SIM/PASPOR CALON ANGGOTA.</label>
				<div id="cropKTP" class="cropContainerModal" style="width:420px;height:260px;background-color:#999">
					<?php
					if ($model->id != "") {
						echo CHtml::image(Yii::app()->controller->createUrl('member/loadKtp', array('id' => $model->id), array('class' => 'img-thumbnail')));
					}
					?>  
				</div>
			</div> 
			<div class="medium-4 columns">
				<label>UNGGAH PAS FOTO  CALON ANGGOTA.</label>
				<div id="cropPHOTO" class="cropContainerModal" style="width:213px;height:247px;background-color:#999">
					<?php
					if ($model->id != "") {
						echo CHtml::image(Yii::app()->controller->createUrl('member/loadPhoto', array('id' => $model->id), array('class' => 'img-thumbnail')));
					}
					?>  
				</div>
			</div><div class="clearfix"></div></br>
			<div class="medium-8 pull-right columns">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'D A F T A R' : 'S I M P A N', array('class' => 'btn btn-primary btn-block pull-right')); ?>
			</div><div class="clearfix"></div></br>
			<hr style="border-bottom: 1px solid green;margin-top: 1px"><hr style="border-bottom: 1px solid green;margin-top: 1px">
		</div>
		<?php $this->endWidget(); ?>
		</div>
	</div>
</section>
<?php
$ismode = "add";
if (!$model->isNewRecord) {
    $ismode = "edit";
}
$domisili = Member::getKabProvKecID($model->sub_district_id);
$member_domisili = Member::getKabProvKecID($model->member_sub_district_id);
?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.mousewheel.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script type="text/javascript">
function loadProvinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#provinsi').html(data);
			$("#provinsi").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#provinsi").select2().select2('val', '<?php echo $domisili['id_prov'] ?>');
			}
			loadKabupaten();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKabupaten() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#provinsi').val()},
		success: function (data) {
			$("#kabupaten").html(data);
			$("#kabupaten").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#kabupaten").select2().select2('val', '<?php echo $domisili['id_kab'] ?>');
			}

			loadKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#kabupaten').val()},
		success: function (data) {
			$('#kecamatan').html(data);
			$("#kecamatan").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#kecamatan").select2().select2('val', '<?php echo $domisili['id_kec'] ?>');
			}

			loadKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatan').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'sub_district_id') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'sub_district_id') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$('#' + '<?php echo CHtml::activeId($model, 'sub_district_id') ?>').select2().select2('val', '<?php echo $model->sub_district_id ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberProvinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#dpd').html(data);
			$("#dpd").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#dpd").select2().select2('val', '<?php echo $member_domisili['id_prov'] ?>');
			}
			loadMemberKabupaten();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKabupaten() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#dpd').val()},
		success: function (data) {
			$("#dpc").html(data);
			$("#dpc").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#dpc").select2().select2('val', '<?php echo $member_domisili['id_kab'] ?>');
			}
			loadMemberKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#dpc').val()},
		success: function (data) {
			$('#pac').html(data);
			$("#pac").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#pac").select2().select2('val', '<?php echo $member_domisili['id_kec'] ?>');
			}
			loadMemberKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#pac').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$('#' + '<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').select2().select2('val', '<?php echo $model->member_sub_district_id ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadEducation() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadeducation') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'last_education_id') ?>').html(data);
			$("#<?php echo CHtml::activeId($model, 'last_education_id') ?>").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#<?php echo CHtml::activeId($model, 'last_education_id') ?>").select2().select2('val', '<?php echo $model->last_education_id; ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function statusKader() {
	if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'N') {
		$('#panel-couple_name').hide();
		$("#panel-children").hide();
	} if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'C') {
		$('#panel-couple_name').hide();
		$("#panel-children").show().removeClass('medium-6 columns').addClass('medium-12 columns');
	} if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'Y') {
		$("#panel-couple_name").show();
		$("#panel-children").show().removeClass('medium-12 columns').addClass('medium-6 columns');
	}
}
var OptionsCropKTP = {
	uploadUrl: '<?php echo CController::createUrl('member/uploadimage') ?>',
	cropUrl: '<?php echo CController::createUrl('member/cropimage') ?>',
	modal: true,
	enableMousescroll: true,
	loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onBeforeImgUpload: function () { console.log('onBeforeImgUpload') },
	onAfterImgUpload: function () { console.log('onAfterImgUpload') },
	onImgDrag: function () { console.log('onImgDrag') },
	onImgZoom: function () { console.log('onImgZoom') },
	onBeforeImgCrop: function () { console.log('onBeforeImgCrop') },
	onAfterImgCrop: function (e) { imgchangeKTP(e.url); },
	onReset: function () { console.log('onReset') },
	onError: function (errormessage) { console.log('onError:' + errormessage) },
}
var cropKTP = new Croppic('cropKTP', OptionsCropKTP);
function imgchangeKTP(f) { $('#identitas').val(f); }
var OptionsCropPHOTO = {
	uploadUrl: '<?php echo CController::createUrl('member/uploadimage') ?>',
	cropUrl: '<?php echo CController::createUrl('member/cropimage') ?>',
	modal: true,
	enableMousescroll: true,
	loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onBeforeImgUpload: function () { console.log('onBeforeImgUpload') },
	onAfterImgUpload: function () { console.log('onAfterImgUpload') },
	onImgDrag: function () { console.log('onImgDrag') },
	onImgZoom: function () { console.log('onImgZoom') },
	onBeforeImgCrop: function () { console.log('onBeforeImgCrop') },
	onAfterImgCrop: function (e) { imgchangePhoto(e.url); },
	onReset: function () { console.log('onReset') },
	onError: function (errormessage) { console.log('onError:' + errormessage) },
}
var cropPHOTO = new Croppic('cropPHOTO', OptionsCropPHOTO);
function imgchangePhoto(f) { $('#photo').val(f); }	
var isktp = false;
function readKTP() {
	isktp = true;
	$.ajax({
		url: "<?php echo CController::createUrl('member/readKTP') ?>",
		type: 'POST',
		data: {nik: $('#<?php echo CHtml::activeId($model, 'identity_number') ?>').val()},
		success: function (data) {
			var obj = $.parseJSON(data);
			console.log(obj);
			if (obj.success === true) {
				$("#provinsi").select2().select2('val', obj.provinsi);
				if (obj.tanggal_lahir.length < 2) {
					var tanggal_lahir = '0' + obj.tanggal_lahir;
				} else {
					var tanggal_lahir = obj.tanggal_lahir;
				}
				$("#<?php echo CHtml::activeId($model, 'date_of_birth') ?>").val(tanggal_lahir + "/" + obj.bulan_lahir + "/" + obj.tahun_lahir);
				if (obj.jk == "P") {
					$("#Member_gender_1").prop('checked', true);
				} else {
					$("#Member_gender_0").prop('checked', true);
				}
				$.ajax({
					url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
					type: 'POST',
					data: {id_prov: obj.provinsi},
					success: function (data) {
						$('#kabupaten').html(data);
						$('#kabupaten').select2().select2('val', obj.provinsi + "" + obj.kota);
						$.ajax({
							url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
							type: 'POST',
							data: {id_kab: obj.provinsi + "" + obj.kota},
							success: function (data) {
								$('#kecamatan').html(data);
								$('#kecamatan').select2().select2('val', obj.provinsi + "" + obj.kota + "" + obj.kecamatan);
								loadKelurahan();
							},
							error: function (jqXHR, status, err) {
								alert(err);
							}
						});
					},
					error: function (jqXHR, status, err) {
						alert(err);
					}
				});

			} else {
				alert(obj.pesan);
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function domisili() {
	loadMemberProvinsi();
	$('#panel-domisili').fadeToggle(750);
	if ($('#<?php echo CHtml::activeId($model, 'is_domisili') ?>').val('N') == true) {
		$('#<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_address') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_home_number') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_rt') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_rw') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_postal_code') ?>').val('');
	}
}
$(document).ready(function () {
	document.getElementById("<?php echo CHtml::activeId($model, 'is_domisili') ?>").onchange = function() {domisili()};
	loadProvinsi();
	loadEducation();
	readKTP();
});
</script>