<section class="box inverted">
	<div class="content-body">
		<div class="row">
		<?php echo Select2::activeDropDownList('fAcara', '', array(), array(
				'placeholder'=>'Cari Data Acara...',
				'class' => 'form-control',
				'select2Options'=>array(
					'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
					'minimumInputLength'=>'3',
					'ajax'=>array(
						'url'=> Yii::app()->createUrl('events/treeAcara'),
						'type'=>'GET',
						'dataType'=>'json',
						'data'=>new CJavaScriptExpression('function (text, page) {return {q: text, page:page}}'),
						'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.acara};}'),						
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
</section>
<section class="box inverted">
<style type="text/css">
th {
	text-align: left !important;
	padding: 0.5em !important;
}
</style>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'cssFile' => Yii::app()->theme->baseUrl."/css+js/style.css",
	'attributes' => array(
		array(
			'label' => '<i class="fa fa-calendar-o"></i>',
			'type' => 'text',
			'value' => 'Tidak ada acara dipilih !',
		)
	),
)); ?>
</section>
<script type="text/javascript">
var currentdate = new Date(), subdistrictId = null, sesiTime = currentdate.getDate();
$('#fAcara').on('change', function (evt) {
	$.ajax({
		url: "<?php echo CController::createUrl('events/loadEvent') ?>",
		type: 'POST',
		data: {eventId: evt.val},
		success: function (e) {
			subdistrictId = e.data.subdistrict; loadprovinsi();
			//$('#submitBtn').attr('disabled', true).val("S I M P A N");
			$('#submitBtn').val("S I M P A N");
			$('#<?php echo CHtml::activeId($model, 'Nama') ?>').val(e.data.Nama);
			$('#<?php echo CHtml::activeId($model, 'lokasi') ?>').val(e.data.lokasi);
			$('#event_time').val(reFormat(e.data.mulai)+' - '+reFormat(e.data.akhir));
			$('#<?php echo CHtml::activeId($model, 'keterangan') ?>').val(e.data.keterangan);
			$('#<?php echo CHtml::activeId($sesi, 'nama') ?>').val(e.sesi.nama);
			$('#<?php echo CHtml::activeId($sesi, 'lokasi') ?>').val(e.sesi.lokasi);
			$('#sesi_time').val(reFormat(e.sesi.mulai)+' - '+reFormat(e.sesi.akhir));
			$('#undangan').select2('data', e.tamu).trigger('change'); //showDetail();
			$('#event-form').attr('action', '<?php echo CController::createUrl("events/update"); ?>/'+e.data.ev_id);
		}
	});
});
function reFormat(dates) {
	var tanggal = dates.split(" ")[0],
	jam = dates.split(" ")[1],
	tgl = tanggal.split("-")[2],
	bln = tanggal.split("-")[1],
	thn = tanggal.split("-")[0];
	return tgl+'/'+bln+'/'+thn+' '+jam.substr(0, 5);
}
function showDetail(id) {
	$.ajax({
		url: "<?php echo CController::createUrl('events/loadDetail') ?>",
		type: "POST",
		data: {ev_id: id},
		success: function (e) {
			console.log(e);
		}
	});
}
</script>