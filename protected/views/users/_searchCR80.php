<div class="col-lg-12" id="searchCR80" style="display: none;">
    <section class="box inverted">
		<div class="content-body">				
			<div class="col-lg-6">
				<label><?php echo "PROVINSI (DPD)"; ?></label>
				<?php echo Select2::dropDownList('provinsiCR80', '', array('' => ''), array(
					'prompt' => 'PILIH PROVINSI',
					'value' => '',
					'onchange' => '{loadKabupatenCR80()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KABUPATEN (DPC)"; ?></label>
				<?php echo Select2::dropDownList('kabupatenCR80', '', array('' => ''), array(
					'prompt' => 'PILIH KABUPATEN',
					'onchange' => '{loadKecamatanCR80()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KECAMATAN (DPAC)"; ?></label>
				<?php echo Select2::dropDownList('kecamatanCR80', '', array('' => ''), array(
					'prompt' => 'PILIH KECAMATAN',
					'onchange' => '{loadKelurahanCR80()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="col-lg-6">
				<label><?php echo "KELURAHAN/DESA (RANTING)"; ?></label>
				<?php echo Select2::activeDropDownList('kelurahanCR80', '', array('' => ''), array(
					'prompt' => 'PILIH KELURAHAN',
					'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="clearfix"></div></br>
			<div class="col-lg-12"> 
				<label><?php echo "CARI KADER (PILIH KADER)" ?></label>
				<?php
				echo Select2::multiSelect('membership_id', '', array(), array(
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
									prov: $("#provinsiCR80").val(),
									kab: $("#kabupatenCR80").val(),
									kec: $("#kecamatanCR80").val(),
									kel: $("#kelurahanCR80").val()
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
					<a type="button" class="btn btn-danger bg-lg" onclick="hideSearch('CR80')"><span class="fa fa-refresh"> BATAL </span></a>
					<a type="button" class="btn btn-success bg-lg" onclick="tampilA4()"><span class="fa fa-check-square-o"> PILIH </span></a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
    </section>
</div>
<script type="text/javascript">
$.ajax({
	url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
	type: 'POST',
	data: {},
	success: function (data) {
		$('#provinsiCR80').html(data);
		$("#provinsiCR80").select2().select2('val', '');
		loadKabupatenCR80();
	}
});
function loadKabupatenCR80() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#provinsiCR80').val()},
		success: function (data) {
			$("#kabupatenCR80").html(data);
			$("#kabupatenCR80").select2().select2('val', '');
			loadKecamatanCR80();
		}
	});
}
function loadKecamatanCR80() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#kabupatenCR80').val()},
		success: function (data) {
			$('#kecamatanCR80').html(data);
			$("#kecamatanCR80").select2().select2('val', '');
			loadKelurahanCR80();
		}
	});
}
function loadKelurahanCR80() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatanCR80').select2().select2('val')},
		success: function (data) {
			$('#kelurahanCR80').html(data);
			$('#kelurahanCR80').select2().select2('val', '');
		}
	});
}
function TampilCR80() {
	var dt = $('#membership_id').val();
	var count = dt.split(',').length;
	if (dt == '') {
		alert('TIDAK ADA KADER DIPILIH !');
	} else if (count < 2) {
		alert('ANDA MEMILIH '+count+' KADER!, MINIMAL CETAK 10 KADER !');
	} else {
		$('#KTACR80-DEPAN').load('<?php echo CController::createUrl('users/cetakA4DPN?') ?>'+'idkta='+dt);
		$('#KTACR80-BELAKANG').load('<?php echo CController::createUrl('users/cetakA4BLK?') ?>'+'idkta='+dt);
		$('#search').hide();
		$('#search-kader').show();
		$('#cari-kader').show();
	}
}
</script>