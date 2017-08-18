<div id="accountDialog" class="dialog">
	<div class="dialog-overlay"></div>
	<div class="dialog-content">
		<div class="morph-shape">
			<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 560 280" preserveAspectRatio="none">
				<rect x="3" y="3" fill="none" width="556" height="276"/>
			</svg>
		</div>
		<div class="dialog-inner">
			<form action="<?php echo Yii::app()->controller->createUrl('member/register') ?>">
				<fieldset class="login">
				<div id="error-ktp" style="visible:none;"></div>
					<p><input type="text" name="identity_number" id="identity_number" placeholder="MASUKAN NOMOR IDENTITAS (KTP)*" required="" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="16" onblur="readKTPFirst()"/></p>
					<p><input type="text" name="member_name" id="member_name" placeholder="MASUKAN NAMA LENGKAP*" required="" autocomplete="off"/></p>
					<p>
						<button id="register" class="button middle" type="submit">D A F T A R</button>
						&nbsp;
						<a href="#" data-login="loginDialog" class="button middle dialog-login-button" data-dialog-close>M A S U K</a>
					</p>
				</fieldset>
			</form>
			<i class="action-close" data-dialog-close>Close</i>
		</div>
	</div>
</div>
<div id="loginDialog" class="dialog">
	<div class="dialog-overlay"></div>
	<div class="dialog-content">
		<div class="morph-shape">
			<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 560 280" preserveAspectRatio="none">
				<rect x="3" y="3" fill="none" width="556" height="276"/>
			</svg>
		</div>
		<div class="dialog-inner">
			<form action="#<?php echo Yii::app()->controller->createUrl('site/login') ?>" method="post" class="account">
				<fieldset>
					<p><input type="text" name="log" id="user_login" placeholder="Username*" required="" autocomplete="off"/></p>
					<p><input type="password" name="pwd" id="user_pass" placeholder="Password*" required="" autocomplete="off"/></p>
					<p>
						<input type="checkbox" id="rememberme" class="tmm-checkbox" name="rememberme" value="forever">
						<label for="rememberme">Remember Me</label>
						<button class="button middle right" type="submit">M A S U K</button>
						<!--a href="#" class="reset-pass">Reset password</a-->
					</p>
				</fieldset>
			</form>
			<i class="action-close" data-dialog-close>Close</i>
		</div>

	</div>
</div>
<script type="text/javascript">
$('#register').attr('disabled','disabled');
function readKTPFirst() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/cekKTP') ?>",
		type: 'POST',
		data: {identity_number: $('#identity_number').val()},
		success: function (data) {
			if (data == 'salah') {
				$('#identity_number').attr('style', "border-radius: 5px; border:#FF0000 1px solid;");
				$('#error-ktp').text("Nomor KTP Tidak dikenal harap periksa kembali !");
				$('#error-ktp').attr('style', "color:red;visible:true;");
			} else if ($('#identity_number').val().length == 16 && data == 0) {
				$('#identity_number').attr('style', "border-radius: 5px; border:green 1px solid;");
				$('#error-ktp').text("Nomor KTP Valid");
				$('#error-ktp').attr('style', "color:green;visible:true;");
				$('#register').removeAttr('disabled');
			} else if ($('#identity_number').val().length != 16) {
				$('#identity_number').attr('style', "border-radius: 5px; border:#FF0000 1px solid;");
				$('#error-ktp').text("Nomor KTP Tidak Valid");
				$('#error-ktp').attr('style', "color:red;visible:true;");
			} else if ($('#identity_number').val().length == 16 && data == 1) {
				$('#identity_number').attr('style', "border-radius: 5px; border:#FF0000 1px solid;");
				$('#error-ktp').text("Nomor KTP Sudah Terdaftar !");
				$('#error-ktp').attr('style', "color:red;visible:true;");
			} 
		},
	});   
}
</script>  