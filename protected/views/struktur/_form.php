<?php
Yii::app()->clientScript->registerScript('struktur', "
$('#str_level').change(function(){
	$('#member_dept').show('slow');
	if ($(this).val() == 33) {
		$('#location').show('slow');
		$('#form_provinsi').show().removeClass('col-md-6').addClass('col-md-12');
		$('#form_kabupaten').hide('slow');
		$('#form_kecamatan').hide('slow');
		$('#form_kelurahan').hide('slow');
	} else if ($(this).val() == 44) {
		$('#location').show('slow');
		$('#form_provinsi').show().removeClass('col-md-12').addClass('col-md-6');
		$('#form_kabupaten').show('slow');
		$('#form_kecamatan').hide('slow');
		$('#form_kelurahan').hide('slow');
	} else if ($(this).val() == 55) {
		$('#location').show('slow');
		$('#form_provinsi').show('slow');
		$('#form_kabupaten').show('slow');
		$('#form_kecamatan').show().removeClass('col-md-6').addClass('col-md-12');
		$('#form_kelurahan').hide('slow');
	} else if ($(this).val() >= 66) {
		$('#location').show('slow');
		$('#form_provinsi').show('slow');
		$('#form_kabupaten').show('slow');
		$('#form_kecamatan').show().removeClass('col-md-12').addClass('col-md-6');
		$('#form_kelurahan').show('slow');
	} else {
		$('#location').hide('slow');
	}
	return false;
});
$('#str_prov').change(function(){
	$.ajax({
		url: '" . CController::createUrl('site/loadkabupaten') . "',
		type: 'POST',
		data: {
			id_prov: $('#str_prov').val()
		},
		success: function (data) {
			$('#str_kab').html(data);
			$('#str_kab').select2().select2('val', '');
			$('#str_kab').trigger('change');
		}
	});
});
$('#str_kab').change(function(){
	$.ajax({
		url: '" . CController::createUrl('site/loadkecamatan') . "',
		type: 'POST',
		data: {
			id_kab: $('#str_kab').val()
		},
		success: function (data) {
			$('#str_kec').html(data);
			$('#str_kec').select2().select2('val', '');
			$('#str_kec').trigger('change');
		}
	});
});
$('#str_kec').change(function(){
	$.ajax({
		url: '" . CController::createUrl('site/loadkelurahan') . "',
		type: 'POST',
		data: {
			id_kec: $('#str_kec').val()
		},
		success: function (data) {
			$('#str_kel').html(data);
			$('#str_kel').select2().select2('val', '');
			$('#str_kel').trigger('change');
		}
	});
});
");
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'filter-form',));
?>
<div class="row col-lg-12">
	<div class="col-md-12"> 
		<label><?php echo "TINGKAT STRUKTUR KEPENGURUSAN" ?> </label>
		<?php echo Select2::dropDownList('str_level', '', CHtml::listdata(Helpers::getStrukturData('lokasi'), 'id', 'text'), array(
			'prompt' => 'PILIH TINGKAT STRUKTUR', 'class' => 'form-control' )); ?>
	</div>
	<div class="col-md-12">
		<div class="clearfix"></div></br>
		<hr style="border-bottom: 3px solid green;margin-top: 1px"/>
	</div>
	<div id="location" class="form-group" style="display: none;">
		<div class="col-md-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>LOKASI MENJABAT</b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-md-6" id="form_provinsi" style="display: none;"> 
			<label><?php echo "PROPINSI" ?> </label>
			<?php echo Select2::dropDownList('str_prov', '', CHtml::listdata(Helpers::getStrukturData('provinsi'), 'id', 'text'), array(
				'prompt' => 'PILIH PROPINSI', 'class' => 'form-control' )); ?>
		</div>
		<div class="col-md-6" id="form_kabupaten" style="display: none;"> 
			<label><?php echo "KABUPATEN" ?> </label>
			<?php echo Select2::dropDownList('str_kab', '', array(), array('prompt' => 'PILIH KABUPATEN', 'class' => 'form-control' )); ?>
		</div>
		<div class="col-md-6" id="form_kecamatan" style="display: none;"> 
			<label><?php echo "KECAMATAN" ?> </label>
			<?php echo Select2::dropDownList('str_kec', '', array(), array('prompt' => 'PILIH KECAMATAN', 'class' => 'form-control' )); ?>
		</div>
		<div class="col-md-6" id="form_kelurahan" style="display: none;"> 
			<label><?php echo "KELURAHAN" ?> </label>
			<?php echo Select2::dropDownList('str_kel', '', array(), array('prompt' => 'PILIH KELURAHAN', 'class' => 'form-control' )); ?>
		</div>
	</div>
	<div id="member_dept" class="form-group" style="display: none;">
		<div class="col-md-12"> 
			<label><?php echo "DIVISI / DEPARTEMEN" ?> </label>
			<?php echo Select2::dropDownList('str_dept', '', array(), array(
					'placeholder'=>'PILIH DIVISI / DEPARTEMEN',
					'class' => 'form-control',
					'select2Options'=>array(
						'ajax'=>array(
							'url'=> Yii::app()->createUrl('site/listTingkat'),
							'type'=>'GET',
							'dataType'=>'json',
							'data'=>new CJavaScriptExpression('function (level, prov, kab, kec, kel) { return { level: $("#str_level").val(), prov: $("#str_prov").val(), kab: $("#str_kab").val(), kec: $("#str_kec").val(), kel: $("#str_kel").val(), } }'),
							'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data};}'),						
						),
					)
			)); ?>
		</div>
		<div class="col-md-6"> 
			<label><?php echo "NAMA KADER" ?> </label>
			<?php echo Select2::dropDownList('member_name', '', array(), array('prompt' => 'PILIH NAMA KADER', 'class' => 'form-control' )); ?>
		</div>
		<div class="col-md-6"> 
			<label><?php echo "JABATAN" ?> </label>
			<?php echo Select2::dropDownList('position', '', array(), array('prompt' => 'PILIH JABATAN', 'class' => 'form-control' )); ?>
		</div>
		<div class="col-md-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>DOKUMEN PENDUKUNG</b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-md-12"> 
			<label><?php echo "SURAT KEPUTUSAN/DOKUMEN PENDUKUNG" ?> </label>
			<?php echo Select2::dropDownList('sk_dok', '', array(), array('prompt' => 'PILIH DOKUMEN/SK KADER', 'class' => 'form-control' )); ?>
		</div>
	</div>
</div><div class="clearfix"></div></br>
<?php $this->endWidget(); ?>