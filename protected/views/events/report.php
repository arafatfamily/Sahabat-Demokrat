<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="screen"/>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">LAPORAN ACARA PARTAI DEMOKRAT</h2>
		</header>
		<div class="content-body">
			<div class="row">
			<?php echo Select2::activeDropDownList('reportList', '', array(), array(
				'placeholder'=>'Cari Laporan Acara...',
				'class' => 'form-control',
				'select2Options'=>array(
					'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
					'minimumInputLength'=>'3',
					'ajax'=>array(
						'url'=> Yii::app()->createUrl('events/cariAcara'),
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
			<div class="clearfix"></div></br>
			<div class="col-xs-4"></div>
			<div class="col-xs-8">
				<table id="reportAbsen" class="display table table-hover table-condensed" cellspacing="0" width="100%"></table>
			</div>
			<div class="clearfix"></div></br>
		</div>
	</section>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$('#reportList').on('change', function (evt) {
	$.ajax({
		url: "<?php echo CController::createUrl('events/loadReport') ?>",
		type: 'POST',
		data: {sesi: evt.val},
		success: function (e) {
			var json = [];
			for (var i = 0; i < e.absen.length; i++){
				json.push([
					e.absen[i].member_name.toUpperCase(),
					e.absen[i].akses_code == 'M' ? 'MASUK' : 'KELUAR',
					e.absen[i].timestamp,
					e.absen[i].status == 'A' ? 'ACCEPTED' : 'REJECTED' 
				]);
			}
			$('#reportAbsen').DataTable({
				"paging": false,
				"ordering": false,
				"info": false,
				"searching": false,
				"destroy": true,
				"language": {
					"search": "Cari:",
					"emptyTable": "Tidak ada data !",
				},
				"data": eval(JSON.stringify(json)),
				"columns": [
					{"title": "NAMA LENGKAP"},
					{"title": "KODE AKSES"},
					{"title": "W A K T U"},
					{"title": "STATUS"}
				]
			});
		}
	});
});
</script>