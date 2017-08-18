<div class="col-lg-12" id="searchA4" style="display: none;">
    <section class="box inverted">
		<div class="content-body">				
			<div class="col-lg-6">
				<label><?php echo "PROVINSI (DPD)"; ?></label>
				<?php echo Select2::dropDownList('provinsiA4', '', array('' => ''), array(
					'prompt' => 'PILIH PROVINSI',
					'value' => '',
					'onchange' => '{loadKabupatenA4()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KABUPATEN (DPC)"; ?></label>
				<?php echo Select2::dropDownList('kabupatenA4', '', array('' => ''), array(
					'prompt' => 'PILIH KABUPATEN',
					'onchange' => '{loadKecamatanA4()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KECAMATAN (DPAC)"; ?></label>
				<?php echo Select2::dropDownList('kecamatanA4', '', array('' => ''), array(
					'prompt' => 'PILIH KECAMATAN',
					'onchange' => '{loadKelurahanA4()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KELURAHAN/DESA (RANTING)"; ?></label>
				<?php echo Select2::activeDropDownList('kelurahanA4', '', array('' => ''), array(
					'prompt' => 'PILIH KELURAHAN',
					'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="clearfix"></div></br>
			<div class="col-lg-12"> 
				<label><?php echo "CARI KADER (PILIH KADER)" ?></label><span id="total" class="badge badge-danger pull-right">0 KADER DIPILIH</span>
				<?php
				echo Select2::multiSelect('memberA4', '', array(), array(
					'placeholder'=>'Silahkan Pilih Kader',
					'class' => 'form-control',
					'select2Options'=>array(
						'tags'=>true,
						'minimumInputLength'=>'3',
						'ajax'=>array(
							'url'=> Yii::app()->createUrl('users/loadKader'),
							'type'=>'GET',
							'dataType'=>'json',
							'data'=>new CJavaScriptExpression('function (text, page, prov, kab, kec, kel) {
								return {
									q: text,
									page:page,
									prov: $("#provinsiA4").val(),
									kab: $("#kabupatenA4").val(),
									kec: $("#kecamatanA4").val(),
									kel: $("#kelurahanA4").val(),
								}
							}'),
							'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.kader};}'),						
						),
					)
				));
				?>
			</div>
			<div class="clearfix"></div></br>
			<div class="col-lg-8 pull-right">
				<div class="btn-group btn-group-justified">         
					<a type="button" class="btn btn-danger bg-lg" onclick="hideSearch('A4')"><span class="fa fa-refresh"> BATAL </span></a>
					<a type="button" class="btn btn-success bg-lg" onclick="TampilA4()"><span class="fa fa-check-square-o"> PILIH </span></a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
    </section>
</div>
<?php
$admin = Users::model()->findByPk(Yii::app()->user->id);
?>
<script type="text/javascript">
$.ajax({
	url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
	type: 'POST',
	data: {},
	success: function (data) {
		$('#provinsiA4').html(data);
		$("#provinsiA4").select2().select2('val', '');
		if (<?php echo Yii::app()->user->getuser("role_id") ?> == 3) {
			$("#provinsiA4").select2().select2('val', '<?php echo $admin->id_prov ?>');
			$("#provinsiA4").prop('disabled', true);
		}
		loadKabupatenA4();
	}
});
function loadKabupatenA4() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#provinsiA4').val()},
		success: function (data) {
			$("#kabupatenA4").html(data);
			$("#kabupatenA4").select2().select2('val', '');
			if (<?php echo Yii::app()->user->getuser("role_id") ?> == 4) {
				$("#provinsiA4").select2().select2('val', '<?php echo $admin->id_kab ?>');
				$("#provinsiA4").prop('disabled', true);
			}
			loadKecamatanA4();
		}
	});
}
function loadKecamatanA4() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#kabupatenA4').val()},
		success: function (data) {
			$('#kecamatanA4').html(data);
			$("#kecamatanA4").select2().select2('val', '');
			if (<?php echo Yii::app()->user->getuser("role_id") ?> == 5) {
				$("#provinsiA4").select2().select2('val', '<?php echo $admin->id_kec ?>');
				$("#provinsiA4").prop('disabled', true);
			}
			loadKelurahanA4();
		}
	});
}
function loadKelurahanA4() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatanA4').select2().select2('val')},
		success: function (data) {
			$('#kelurahanA4').html(data);
			$('#kelurahanA4').select2().select2('val', '');
		}
	});
}
function TampilA4() {
	var dt = $('#memberA4').val();
	var count = dt.split(',').length;
	if (dt == '') {
		alert('TIDAK ADA KADER DIPILIH !');
	} else if (count < 1) {
		alert('ANDA MEMILIH '+count+' KADER!, MINIMAL CETAK 10 KADER !');
	} else {
		$('#KTAA4-DEPAN').load('<?php echo CController::createUrl('users/cetakA4DPN?') ?>'+'idkta='+dt);
		$('#KTAA4-BELAKANG').load('<?php echo CController::createUrl('users/cetakA4BLK?') ?>'+'idkta='+dt);
		$('#searchA4').hide();
		$('#search-kader').show();
		$('#cari-kader').show();
	}
}
$('#memberA4').change(function(){
	var data = $('#memberA4').val().split(',');
	document.getElementById('total').innerHTML = data.length+' KADER DIPILIH';
	$('#Temp_ktaA4').load('<?php echo CController::createUrl('member/cetak?') ?>'+'id='+data[data.length-1]);
});
</script>