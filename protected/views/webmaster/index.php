<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active">
			<a href="#changelog" data-toggle="tab">
				<i class="fa fa-home"></i> Webmaster Changelog
			</a>
		</li>
		<li <?php echo (!Yii::app()->user->isSuperadmin() ? 'style="display: none;"' : ''); ?>>
			<a href="#loging" data-toggle="tab" onclick="LogContent();">
				<i class="fa fa-road"></i> Log Aplikasi
			</a>
		</li>
		<li <?php echo (!Yii::app()->user->isSuperadmin() ? 'style="display: none;"' : ''); ?>>
			<a href="#manage" data-toggle="tab">
				<i class="fa fa-gears"></i> Tambah Perubahan
			</a>
		</li>
		<li>
			<a href="#profile" data-toggle="tab">
				<i class="fa fa-user"></i> Webmaster Info 
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="changelog">
			<div class="col-md-12">
			<?php $this->renderPartial('_view'); ?>
			</div><div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="loging">
			<div class="col-md-12">
			Loading Application log ... 
			</div><div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="manage">
			<div class="col-md-12">
			<?php $this->renderPartial('_form', array('model' => $model)); ?>
			</div><div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="profile">
			<div class="col-md-12">
			<p>No Information Here. </p>
			</div><div class="clearfix"></br></div>
		</div>
	</div>
</div>
<!--script type="text/javascript">
$.ajax({
	url: "<!?php echo CController::createUrl('_api/getdistrict') ?>",
	type: 'GET',
	data: {subdistrict: '1101012001'},
	dataType: "json",
	header: {
		"authorization": "Basic c3VwZXJhZG1pbjpBcmFmYXQxMjA2MTQh"
		},
	success: function (res) {
		console.log(res.data.nama_kab);
	},
	error: function (jqXHR, status, err) {
		alert(err);
	}
});
</script-->
