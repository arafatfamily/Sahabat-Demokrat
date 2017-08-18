<ul class="block-with-icons" style="margin-bottom: 2rem">
	<li>
		<a href="#" data-kader="kaderDialog">
			<i class="icon-group"></i>
			<h5>Check KTA</h5>
			<span>Check Status KTA Online</span>
		</a>
	</li>
	<li>
		<a target="_blank" href="http://pemilu.sahabatdemokrat.org">
			<i class="icon-thumbs-up-4"></i>
			<h5>Pemilu</h5>
			<span>Hasil Rekapitulasi Pemilu</span>
		</a>
	</li>
	<li>
		<a href="#">
			<i class="icon-calendar-inv"></i>
			<h5>Agenda</h5>
			<span>Agenda Event BPOKK</span>
		</a>
	</li>
</ul>
<div id="kaderDialog" class="dialog">
	<div class="dialog-overlay"></div>
	<div class="dialog-content">
		<div class="morph-shape">
			<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 560 280" preserveAspectRatio="none">
				<rect x="3" y="3" fill="none" width="556" height="276"/>
			</svg>
		</div>
		<div class="dialog-inner">
			<form action="<?php echo Yii::app()->controller->createUrl('member/info') ?>" method="post">
				<fieldset>
				<div id="error-kta" style="visible:none;"></div>
					<p><input type="text" name="cek_KTA" id="cek_KTA" placeholder="SCAN RFID/BARCODE ATAU MASUKAN NO. KTA ANDA !" required="" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="10" onkeyup="readKTAFirst()"/></p>
					<p><button id="cKTA" class="button middle right" type="submit">CEK KTA</button></p>
				</fieldset>
			</form>
			<i class="action-close" data-dialog-close>Close</i>
		</div>

	</div>
</div>
<script type="text/javascript">
var dlgCheck = document.querySelector('[data-kader]');
var	kaderDialog = document.getElementById( dlgCheck.getAttribute( 'data-kader' ) );
var	dlgC = new DialogFx(kaderDialog);
	
	dlgCheck.addEventListener( 'click', dlgC.toggle.bind(dlgC) );
$('#cKTA').attr('disabled','disabled');
function readKTAFirst() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/validateKTA') ?>",
		type: 'POST',
		data: {nokta: $('#cek_KTA').val()},
		success: function (data) {
			if (data == 0) {
				$('#cek_KTA').attr('style', "border-radius: 5px; border:#FF0000 1px solid;");
				$('#error-kta').text("Nomor KTA/RFID Tidak dikenal harap periksa kembali !");
				$('#error-kta').attr('style', "color:red;visible:true;");
			} else if (data == 1) {
				$('#cek_KTA').attr('style', "border-radius: 5px; border:green 1px solid;");
				$('#error-kta').text("Nomor KTA/RFID Valid");
				$('#error-kta').attr('style', "color:green;visible:true;");
				$('#cKTA').removeAttr('disabled');
			}
		},
	});
}
</script>