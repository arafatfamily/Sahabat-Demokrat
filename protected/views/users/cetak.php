<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active" onclick="hideSearch()">
			<a href="#A4" data-toggle="tab">
				<i class="fa fa-home"></i> CETAK KTA (PVC A4)
			</a>
		</li>
		<li onclick="hideSearch()">
			<a href="#CR80" data-toggle="tab">
				<i class="fa fa-gears"></i> CETAK KTA (PVC CR80)
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="A4">
			<?php $this->renderPartial('_searchA4'); ?>
			<div class="col-lg-12">
				<section class="box">
					<header class="panel_header">
						<h2 class="title pull-left">PRINT MASSAL KTA (MODE A4)</h2>
						<div class="actions panel_actions col-md-8">
							<div class="pull-right">
								<button class="btn btn-sm btn-purple" id="search-kader" tabindex='-1' data-toggle='modal' onclick='search("A4")' type="button"><span class="fa fa-search-plus"></span>&nbsp;CARI KADER&nbsp;</button>
								<button class="btn btn-sm btn-danger" id="reload" onclick="window.location.reload()" type="button"><span class="fa fa-refresh"></span></button>
								<button class="btn btn-sm btn-primary" onclick="cetak('KTAA4-DEPAN')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA DEPAN&nbsp;</button>
								<button class="btn btn-sm btn-info" onclick="cetak('KTAA4-BELAKANG')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA BELAKANG&nbsp;</button>
							</div>
						</div>
					</header>
					<div id="KTAA4-DEPAN" class="content-body"></div>
					<div id="KTAA4-BELAKANG" class="content-body"></div>
				</section>
			</div>
			<div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="CR80">
			<?php $this->renderPartial('_searchCR80'); ?>
			<div class="col-lg-12">
				<section class="box">
					<header class="panel_header">
						<h2 class="title pull-left">PRINT MASSAL KTA KADER</h2>
						<div class="actions panel_actions col-md-8">
							<div class="pull-right">
							<button class="btn btn-sm btn-purple" id="cari-kader" tabindex='-1' data-toggle='modal' onclick='search("CR80")' type="button"><span class="fa fa-search-plus"></span>&nbsp;CARI KADER&nbsp;</button>
							<button class="btn btn-sm btn-danger" id="reload" onclick="window.location.reload()" type="button"><span class="fa fa-refresh"></span></button>
							<button class="btn btn-sm btn-primary" onclick="cetak('KTACR80-DEPAN')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA DEPAN&nbsp;</button>
							<button class="btn btn-sm btn-info" onclick="cetak('KTACR80-BELAKANG')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA BELAKANG&nbsp;</button>
							</div>
						</div>
					</header>
					<div id="KTACR80-DEPAN" class="content-body"></div>
					<div id="KTACR80-BELAKANG" class="content-body"></div>
				</section>
			</div>
			<div class="clearfix"></br></div>
		</div>
	</div>
	<div id="Temp_ktaA4" style="display: none;"></div>
</div>
<script type="text/javascript">
function search(mode) {
	if (mode == "A4") {
		$('#searchA4').show();
	} else {
		$('#searchCR80').show();
	}	
	$('#search-kader').hide();
	$('#cari-kader').hide();
	return false;
}
function hideSearch(mode) {
	$('#membership_id').select2('val', '');
	document.getElementById('total').innerHTML = '0 KADER DIPILIH';
	if (mode == "A4") {
		$('#searchA4').hide();
	} else {
		$('#searchCR80').hide();
	}
	$('#search-kader').show();
	$('#cari-kader').show();
	return false;
}
function statusPrint(list, i) {
	var len = list.split(",").length;
	if(i < len) {
		var part = list.split(",");
		$.ajax({
			url: "<?php echo CController::createUrl('users/statusPrint') ?>",
			type: 'POST',
			data: {
				id: part[i]
			},
			dataType: 'json',
			success: function (data) {
				statusPrint(list, (i + 1));
			},
		});
	}
}
function cetak(divName) {
	if(divName == 'KTAA4-DEPAN') {
		statusPrint($('#memberA4').val(), 0);
	}
	var printContents = document.getElementById(divName).innerHTML;
	w = window.open();
	w.document.write(printContents);
	w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
	w.document.close();
	w.focus();
	return true;
}
</script>