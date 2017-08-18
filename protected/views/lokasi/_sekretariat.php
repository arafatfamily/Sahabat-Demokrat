<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'Sekretariat-form',
	'method'=>'POST',
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
	//'focus'=>($model->hasErrors()) ? '.error:first' : array($model, 'title')
)); ?>
<div class="form-group">	
	<div class="col-lg-12">
		<div class="col-lg-12">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'form-control','placeholder'=>'ex. DEWAN PIMPINAN PUSAT PARTAI DEMOKRAT')); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="col-lg-12">
			<label><?php echo "PROPINSI"; ?></label>
			<?php echo Select2::dropDownList('provinsi', '', array('' => ''), array(
				'prompt' => 'PILIH PROVINSI',
				'value' => '',
				'onchange' => '{loadKabupaten()}', 'class' => 'form-control templatingSelect2', )); ?>
		</div>
		<div class="col-lg-12">
			<label><?php echo "KABUPATEN"; ?></label>
			<?php echo Select2::dropDownList('kabupaten', '', array('' => ''), array(
				'prompt' => 'PILIH KABUPATEN',
				'onchange' => '{loadKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
		</div>
		<div class="col-lg-12">
			<label><?php echo "KECAMATAN"; ?></label>
			<?php echo Select2::dropDownList('kecamatan', '', array('' => ''), array(
				'prompt' => 'PILIH KECAMATAN',
				'onchange' => '{loadKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
		</div>
		<div class="col-lg-12">
		<?php echo $form->labelEx($model,'sub_district'); ?>
			<?php echo Select2::activeDropDownList($model, 'sub_district', array('' => ''), array(
			'prompt' => 'PILIH KELURAHAN',
			'class' => 'form-control', 'selected' => 'selected')); ?>
			<?php echo $form->error($model,'sub_district'); ?>
		</div>		
		<div class="col-lg-12">
		<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textField($model,'address',array('class'=>'form-control','placeholder'=>'Masukan Alamat Sekretariat')); ?>
			<?php echo $form->error($model,'address'); ?>
		</div>
	</div>
	<div class="col-sm-4">
		<label class="control-label">CARI LOKASI</label>
		<div class="col-sm-12" style="padding: 0px;">
			<?php
			$this->widget('ext.useLocationPicker.LocationPicker', array(
				'model' => $model,
				'latId' => "latitude",
				'lonId' => "longitude",
			));
			?>
		</div>
	</div>	
	<div class="col-lg-12">
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'no_telp'); ?>
		<?php echo $form->textField($model,'no_telp',array('class'=>'form-control','placeholder'=>'(021)-3190-7999')); ?>
		<?php echo $form->error($model,'no_telp'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('class'=>'form-control','placeholder'=>'example@example.com')); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('class'=>'form-control','placeholder'=>'sahabatdemokrat.org')); ?>
		<?php echo $form->error($model,'website'); ?>
		</div>
	</div><div class="clearfix"></div></br>
	<hr style="border-bottom: 1px solid green;margin-top: 1px">
	<div class="col-lg-8 pull-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN', array('class' => 'btn btn-primary btn-block pull-right')); ?>
	</div><div class="clearfix"></div></br>
</div>
<?php $this->endWidget();
$ismode = "add";
if (!$model->isNewRecord) {
    $ismode = "edit";
}
$domisili = Member::getKabProvKecID($model->sub_district);
?>
<div class="clearfix"></div>
<script type="text/javascript">
$(document).ready(function(){
  function setCurrency (currency) {
	  if (!currency.id) { return currency.text; }
		var $currency = $('<span class="glyphicon glyphicon-euro">' + currency.text + '</span>');
		return $currency;
	};
	$(".templatingSelect2").select2({
		placeholder: "What currency do you use?", //placeholder
		templateResult: setCurrency,
		templateSelection: setCurrency
	});
})
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
			$('#<?php echo CHtml::activeId($model, 'sub_district') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'sub_district') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$('#' + '<?php echo CHtml::activeId($model, 'sub_district') ?>').select2().select2('val', '<?php echo $model->sub_district ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
</script>