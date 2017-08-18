<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active">
			<a href="#dataSaran" data-toggle="tab">
				<i class="fa fa-envelope-square"></i> DATA KRITIK & SARAN
			</a>
		</li>
		<li>
			<a href="#sugest" data-toggle="tab">
				<i class="fa fa-pencil-square"></i> KIRIM KRITIK & SARAN
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="dataSaran">
			<div class="col-md-12">
			<?php $this->renderPartial('_view', array('dataProvider'=>$dataProvider)); ?>
			</div><div class="clearfix"></div>
		</div>
		<div class="tab-pane fade" id="sugest">
			<div class="col-md-12">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div><div class="clearfix"></br></div>
		</div>
	</div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/countto.js" type="text/javascript"></script>
<script type="text/javascript">
$("input[id^='reply_']").keypress(function (e) {
	if (e.which == 13) {
		sendReply($(this).data('id'), $(this).val());
	}
});
$('a[id^="showResponse_"]').click(function () {
	$('div[id^="response_' + $(this).data('id') + '"').fadeToggle(750);
});
function sendReply(kritik, saran) {
	if(saran == '') {
		alert('Komentar Tidak Boleh Kosong !');
	} else {
		$.ajax({
			url: "<?php echo CController::createUrl('masukan/balas') ?>",
			type: 'POST',
			data: {id: kritik, reply: saran},
			dataType: 'json',
			success: function (data) {
				if(data.success) {
					location.reload();
				}
			},
		});
	}
}
</script>