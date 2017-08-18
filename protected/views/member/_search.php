<link href="<?php echo Yii::app()->theme->baseUrl ?>/css+js/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css+js/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css+js/bootstrap-timepicker.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css+js/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" media="screen"/>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'filter-form',));
?>
<div class="row col-lg-12">
	<div class="form-group">
		<div class="col-md-3"> 
			<label><?php echo "D P D" ?> </label>
			<?php
			echo Select2::dropDownList('filterdpd', '', array('' => ''), array(
				'prompt' => 'PILIH DPD',
				'onchange' => '{loadKabupaten()}',
				'class' => 'form-control', 'selected' => 'selected'
			));
			?>
		</div>
		<div class="col-md-3"> 
			<label><?php echo "D P C" ?> </label>
			<?php
			echo Select2::dropDownList('filterdpc', '', array('' => ''), array(
				'prompt' => 'PILIH DPC',
				'onchange' => '{loadKecamatan()}',
				'class' => 'form-control', 'selected' => 'selected'
			));
			?>
		</div>
		<div class="col-md-3"> 
			<label><?php echo "D P A C" ?> </label>
			<?php
			echo Select2::dropDownList('filterdpac', '', array('' => ''), array(
				'prompt' => 'PILIH ANAK CABANG',
				'onchange' => '{loadKelurahan()}',
				'class' => 'form-control', 'selected' => 'selected'
			));
			?>
		</div>
		<div class="col-md-3"> 
			<label><?php echo "RANTING" ?> </label>
			<?php
			echo Select2::dropDownList('filterdpar', '', array('' => ''), array(
				'prompt' => 'PILIH RANTING',
				'onchange' => '{loadData()}',
				'class' => 'form-control', 'selected' => 'selected'
			));
			?>
		</div>
	</div><div class="clearfix"></div>
	<div class="form-group">
		<div class="col-md-3">
			<?php echo $form->label($model, 'membership_id'); ?>
            <?php echo $form->textField($model, 'membership_id', array('size' => 10, 'maxlength' => 10, 'class' => 'form-control pull-right', 'placeholder' => 'Filter No KTA')); ?>
		</div>
		<div class="col-md-3">
			<?php echo $form->label($model, 'member_name'); ?>
            <?php echo $form->textField($model, 'member_name', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control pull-right', 'placeholder' => 'Filter Nama Anggota')); ?>
		</div>
		<div class="col-md-3">
			<?php echo $form->label($model, 'reference'); ?>
            <?php echo $form->textField($model, 'reference', array('size' => 10, 'maxlength' => 10, 'class' => 'form-control pull-right', 'placeholder' => 'Filter No. Referensi')); ?>
		</div>
		<div class="col-md-3 btn-group" data-toggle="buttons">
			<label><?php echo "STATUS KTA" ?> </label>
			<?php
			echo CHtml::dropDownList('is_print', '', array('All'=>'SEMUA', 'P'=>'CETAK SAJA', 'N'=>'BELUM CETAK'), array(
				'onchange' => '{loadData()}',
				'class' => 'form-control', 'selected' => 'selected'
			));
			?>
		</div>
		<!--div class="col-md-2" align="center">
			<b>Sudah Cetak</b>
			<div class="onoffswitch">
				<input type="checkbox" name="is_print_sudah" class="onoffswitch-checkbox" onchange="loadData()" id="is_print_sudah" checked>
				<label class="onoffswitch-label" for="is_print_sudah">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		<div class="col-md-2" align="center">
			<b>Belum Cetak</b>
			<div class="onoffswitch">
				<input type="checkbox" name="is_print_belum" class="onoffswitch-checkbox" onchange="loadData()" id="is_print_belum" checked>
				<label class="onoffswitch-label" for="is_print_belum">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		<div class="col-md-2" align="center">
			<b>Operator KTA</b>
			<div class="onoffswitch">
				<input type="checkbox" name="is_admin" class="onoffswitch-checkbox" onclick="loadData()" id="is_admin" disabled>
				<label class="onoffswitch-label" for="is_admin">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div-->
	</div><div class="clearfix"></div>
	<div class="form-group" id="advance-filter" style="display: none">
		<div class="clearfix"></div><hr style="border: 1px solid #2355FA;">
		<div class="form-group">
			<div class="col-md-4">
				<?php echo $form->label($model, 'identity_number'); ?>
				<?php echo $form->textField($model, 'identity_number', array('size' => 16, 'maxlength' => 16, 'class' => 'form-control', 'placeholder' => 'Filter Nomor Identitas')); ?>
			</div>
			<div class="col-md-4">
				<?php echo $form->label($model, 'last_print'); ?>
				<div class="row">
					<div class="col-md-6">
					<input id="Member_tglmulai" name="Member[tglmulai]" type="text" onchange="loadData()" class="form-control datepicker" data-format="yyyy-mm-dd" placeholder="dari">
					</div><div class="col-md-6">
					<input id="Member_tglakhir" name="Member[tglakhir]" type="text" onchange="loadData()" class="form-control datepicker" data-format="yyyy-mm-dd" placeholder="s/d">
					</div></div>
			</div>					
			<div class="col-md-4">
				<label><?php echo "ADMIN CETAK" ?> </label>
				<?php echo Select2::dropDownList('Member_adm_print', '', array('' => ''), array(
					'prompt' => 'PILIH ADMIN CETAK',
					'onchange' => '{loadData()}',
					'class' => 'form-control', 'selected' => 'selected'
				));
				?>
			</div>
		</div><div class="clearfix"></div>
		<!--div class="form-group">
			<div class="col-md-3">
			<!?php echo $form->label($model, 'membership_id'); ?>
				<!?php echo $form->textField($model, 'identity_number', array('size' => 120, 'maxlength' => 190, 'class' => 'form-control', 'placeholder' => 'Filter Nomor Identitas')); ?>
			</div>
			<div class="col-md-3">
			<!?php echo $form->label($model, 'membership_id'); ?>
				<!?php echo $form->textField($model, 'identity_number', array('size' => 120, 'maxlength' => 190, 'class' => 'form-control', 'placeholder' => 'Filter Nomor Identitas')); ?>
			</div>
			<div class="col-md-3">
			<!?php echo $form->label($model, 'membership_id'); ?>
				<!?php echo $form->textField($model, 'identity_number', array('size' => 120, 'maxlength' => 190, 'class' => 'form-control', 'placeholder' => 'Filter Nomor Identitas')); ?>
			</div>
			<div class="col-md-3">
			<!?php echo $form->label($model, 'membership_id'); ?>
				<!?php echo $form->textField($model, 'identity_number', array('size' => 120, 'maxlength' => 190, 'class' => 'form-control', 'placeholder' => 'Filter Nomor Identitas')); ?>
			</div>
		</div-->
	</div>
</div>
<?php $this->endWidget();
$admin = Users::model()->findByPk(Yii::app()->user->id);
?>
<script type="text/javascript">
function loadProvinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#filterdpd').html(data);
			$("#filterdpd").select2().select2('val', '');
			if (<?php echo Yii::app()->user->getuser("role_id") ?> == 3) {
				$("#filterdpd").select2().select2('val', '<?php echo $admin->id_prov ?>');
				$("#filterdpd").prop('disabled', true);
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
		data: {id_prov: $('#filterdpd').val()},
		success: function (data) {
			$('#filterdpc').html(data);
			$("#filterdpc").select2().select2('val', '');
			if (<?php echo Yii::app()->user->getuser("role_id") ?> == 4) {
				$("#filterdpc").select2().select2('val', '<?php echo $admin->id_kab ?>');
				$("#filterdpc").prop('disabled', true);
			}
			loadKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err)
		}
	});
}	
function loadKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#filterdpc').val()},
		success: function (data) {
			$('#filterdpac').html(data);
			$("#filterdpac").select2().select2('val', '');
			if (<?php echo Yii::app()->user->getuser("role_id") ?> == 5) {
				$("#filterdpac").select2().select2('val', '<?php echo $admin->id_kec ?>');
				$("#filterdpac").prop('disabled', true);
			}
			loadKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err)
		}
	});
}
function loadKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#filterdpac').val()},
		success: function (data) {
			$('#filterdpar').html(data);
			$("#filterdpar").select2().select2('val', '');
			loadData();
		},
		error: function (jqXHR, status, err) {
			alert(err)
		}
	});
}
function loadAdmin() {
	$.ajax({
		url: "<?php echo CController::createUrl('member/loadAdmin') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#Member_adm_print').html(data);
			$("#Member_adm_print").select2().select2('val', '');
			loadData();
		},
		error: function (jqXHR, status, err) {
			alert(err)
		}
	});
}
function loadData() {
	$.fn.yiiGridView.update('member-grid', {
		data: $('#filter-form').serialize()
	});
}
$(document).ready(function () {
	loadProvinsi();
	loadAdmin();
	/*$('#is_print_sudah').val("Y");
	$('#is_print_belum').val("Y");
	$('[type="checkbox"].onoffswitch-checkbox').change(function(e) {
		var isChecked = $(this).is(":checked");
		$(this.id).val(isChecked?"Y":"N");
	});	*/
	//$('#advance-filter').hide();
});
</script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/css+js/datepicker.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/css+js/moment.min.js" type="text/javascript"></script> 
<script src="<?php echo Yii::app()->theme->baseUrl ?>/css+js/daterangepicker.js" type="text/javascript"></script> 
<script src="<?php echo Yii::app()->theme->baseUrl ?>/css+js/bootstrap-timepicker.min.js" type="text/javascript"></script> 
<script src="<?php echo Yii::app()->theme->baseUrl ?>/css+js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
