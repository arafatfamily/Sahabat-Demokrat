<?php
Yii::app()->clientScript->registerScript('search', "
	$('#search-button').click(function(){
		$('#advance-filter').fadeToggle(750);
		return false;
	});
	$('#Member_membership_id').keyup(function(){
		  loadData();
		return false;
	});
	$('#Member_member_name').keyup(function(){
		  loadData();
		return false;
	});
	$('#Member_identity_number').keyup(function(){
		  loadData();
		return false;
	});
");
?>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">DATA ANGGOTA NON-AKTIF</h2>
			<div class="actions panel_actions pull-right">
			<?php if (Yii::app()->user->getAkses("7", "2") || Yii::app()->user->isSuperadmin()) {
				echo '<button class="btn btn-md btn-danger" onclick="downloadData()" type="button"><span class="fa fa-download"></span>&nbsp;Export Data Kader&nbsp;</button>'; } ?>
			<button id="search-button" class="btn btn-md btn-info" type="button">&nbsp;Pencarian Lnajutan&nbsp;<span class="fa fa-search-plus"></span></button>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form"><?php $this->renderPartial('_search',array('model'=>$model)); ?></div>				
			</div>
		</div>
	</section>
	<div class="table-responsive col-sm-12"><?php $this->renderPartial('_view',array('dataProvider'=>$dataProvider)); ?></div>
</div>
<script type="text/javascript">
function downloadData() {
	window.location.href = "exportxls?" + $('#filter-form').serialize();
}
function goPendaftaran() {
	window.location.href = "<?php echo CController::createUrl('member/tambah') ?>";
}
$( "#accept" ).click(function() {
  alert( "On Progress Update!" );
});
</script>