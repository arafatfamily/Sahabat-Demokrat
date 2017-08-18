<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/>
<style type="text/css">.btn-block-custom {padding: 0 !important;line-height: 32px !important;display: none;}</style>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'method'=>'POST',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
	//'focus'=>($model->hasErrors()) ? '.error:first' : array($model, 'title')
)); ?>
<div class="form-group" style="">
	<div class="col-lg-12">
		<div class="clearfix"></div></br>
			<span class="bg-info text-uppercase"><b>Informasi Detil Acara </b></span>
			<hr style="border-bottom: 1px solid green;margin-top: 1px">
	</div>
	<div class="col-lg-12">
	<?php echo $form->labelEx($model,'Nama'); ?>
	<?php echo $form->textField($model,'Nama',array('class'=>'form-control','placeholder'=>'Masukan Nama Acara')); ?>
	<?php echo $form->error($model,'Nama'); ?>
	</div>
	<div class="col-lg-6">
		<label><?php echo "PROPINSI"; ?></label>
		<?php echo Select2::dropDownList('provinsi', '', array('' => ''), array(
			'prompt' => 'PILIH PROVINSI','value' => '',
			'onchange' => '{loadKabupaten()}', 'class' => 'form-control', )); ?>
	</div>
	<div class="col-lg-6">
		<label><?php echo "KABUPATEN"; ?></label>
		<?php echo Select2::dropDownList('kabupaten', '', array('' => ''), array(
			'prompt' => 'PILIH KABUPATEN',
			'onchange' => '{loadKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
	</div>
	<div class="col-lg-6">
		<label><?php echo "KECAMATAN"; ?></label>
		<?php echo Select2::dropDownList('kecamatan', '', array('' => ''), array(
			'prompt' => 'PILIH KECAMATAN',
			'onchange' => '{loadKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
	</div>
	<div class="col-lg-6">
	<?php echo $form->labelEx($model,'subdistrict'); ?>
		<?php echo Select2::activeDropDownList($model, 'subdistrict', array('' => ''), array(
		'prompt' => 'PILIH KELURAHAN',
		'class' => 'form-control', 'selected' => 'selected')); ?>
		<?php echo $form->error($model,'subdistrict'); ?>
	</div>		
	<div class="col-lg-6">
	<?php echo $form->labelEx($model,'lokasi'); ?>
	<?php echo $form->textField($model,'lokasi',array('class'=>'form-control','placeholder'=>'Masukan Lokasi Event')); ?>
	<?php echo $form->error($model,'lokasi'); ?>
	</div>
	<div class="col-lg-6">
	<label><?php echo "PELAKSANAAN ACARA"; ?></label>
	<?php echo CHtml::textField('event_time','',array('class'=>'form-control')); ?>
	<?php echo $form->error($model,'mulai'); ?>
	</div>
	<div class="col-lg-12">
	<?php echo $form->labelEx($model,'keterangan'); ?>
	<?php echo $form->textArea($model,'keterangan',array('class'=>'form-control','rows'=>4,'placeholder'=>'Tulis Detil acara ...')); ?>
	<?php echo $form->error($model,'keterangan'); ?>
	</div>
</div>
<div id="sesi-event" class="form-group" style="">
	<div class="col-lg-12">
		<div class="clearfix"></div></br>
			<span class="bg-info text-uppercase"><b>Informasi Detil Sesi Event </b></span>
			<div class="col-md-3 pull-right ">
		<div class="btn-group btn-group-justified text-uppercase">
			<?php $text = "<i class='fa fa-plus-square'></i> Tambah Sesi";
			echo CHtml::link($text, '#akhir-sesi', array('class'=>'btn btn-sm btn-success', 'onClick'=>'{loadSesiTime()}')); ?></div>
		</div>
		<hr style="border-bottom: 1px solid green;margin-top: 1px">
	</div>
	<div class="col-lg-12">
	<?php echo $form->labelEx($sesi,'nama'); ?>
	<?php echo $form->textField($sesi,'nama',array('class'=>'form-control','placeholder'=>'Masukan Nama Acara')); ?>
	<?php echo $form->error($sesi,'nama'); ?>
	</div>
	<div class="col-lg-6">
	<?php echo $form->labelEx($sesi,'lokasi'); ?>
	<?php echo $form->textField($sesi,'lokasi',array('class'=>'form-control','placeholder'=>'Masukan Lokasi Sesi')); ?>
	<?php echo $form->error($sesi,'lokasi'); ?>
	</div>
	<div class="col-lg-6">
		<label><?php echo "PELAKSANAAN SESI"; ?></label>
		<?php echo CHtml::textField('sesi_time', '',array('class'=>'form-control')); ?>
		<?php echo $form->error($sesi,'mulai'); ?>
	</div>
	<div id="participant" class="form-group">
		<div class="col-lg-12">
		<label><?php echo "UNDANGAN/PESERTA"; ?></label>	
		<?php echo Select2::activeDropDownList('undangan', '', array(), array(
				'placeholder'=>'Silahkan Pilih Tamu Undangan',
				'class' => 'form-control',
				'select2Options'=>array(
					'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
					'minimumInputLength'=>'3',
					'multiple'=> true,
					'ajax'=>array(
						'url'=> Yii::app()->createUrl('events/participant'),
						'type'=>'GET',
						'dataType'=>'json',
						'data'=>new CJavaScriptExpression('function (text, page) {return {q: text, page:page}}'),
						'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.participant};}'),						
					),
					'formatResult'=> new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
					}'),
					'formatSelection'=>new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
					}'),
				)
		)); ?>
		</div>
	</div>
</div>
<div class="form-group"><div class="clearfix"></div></br>
	<hr style="border-bottom: 1px solid green;margin-top: 1px">
	<div id="akhir-sesi" class="col-lg-8 pull-right">
		<?php echo CHtml::submitButton('T A M B A H', array('id' => 'submitBtn','class' => 'btn btn-primary btn-block pull-right')); ?>
	</div>
</div>
<?php $this->endWidget();
$ismode = "add";
if (!$model->isNewRecord) {
    $ismode = "edit";
}
$domisili = Member::getKabProvKecID($model->subdistrict);
?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/date_moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/daterangepicker.js"></script>
<script type="text/javascript">
$('#event_time').daterangepicker({
	timePicker: true,
	opens: 'left',
    drops: 'up',
	buttonClasses: 'btn btn-block btn-block-custom btn-corner',
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    },
    startDate: currentdate.getDate(),
    endDate: currentdate.getDate()
});
function loadprovinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#provinsi').html(data);
			$("#provinsi").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#provinsi").select2().select2('val', '<?php echo $domisili['id_prov'] ?>');
			} else if (subdistrictId != null) {
				$("#provinsi").select2().select2('val', subdistrictId.substr(0, 2));
			}
			loadKabupaten();
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
			} else if (subdistrictId != null) {
				$("#kabupaten").select2().select2('val', subdistrictId.substr(0, 4));
			}
			loadKecamatan();
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
			} else if (subdistrictId != null) {
				$("#kecamatan").select2().select2('val', subdistrictId.substr(0, 6));
			}
			loadKelurahan();
		}
	});
}
function loadKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatan').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'subdistrict') ?>').html(data);
			$('#<?php echo CHtml::activeId($model, 'subdistrict') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
			$('#<?php echo CHtml::activeId($model, 'subdistrict') ?>').select2().select2('val', '<?php echo $model->subdistrict ?>');
			} else if (subdistrictId != null) {
				$('#<?php echo CHtml::activeId($model, 'subdistrict') ?>').select2().select2('val', subdistrictId);
			}
		}
	});
}
function loadSesiTime() {	
	$('#sesi_time').daterangepicker({
		timePicker: true,
		timePicker24Hour: true,
		opens: 'left',
		drops: 'up',
		buttonClasses: 'btn btn-block btn-block-custom btn-corner',
		locale: {
		  format: 'DD/MM/YYYY HH:mm'
		},
		startDate: currentdate.getDate(),
		endDate: currentdate.getDate()
	});
}
loadprovinsi(); loadSesiTime();
</script>