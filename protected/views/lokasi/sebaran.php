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
<style type="text/css">
.popbox {
    display: none;
    position: absolute;
    z-index: 99999;
    width: 508px;
    padding: 0px;
    background: #EEEFEB;
    color: #000000;
    border: 1px solid #4D4F53;
    margin: 0px;
    -webkit-box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
    box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
}
</style>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">DATA LOKASI KADER</h2>
			<div class="actions panel_actions pull-right">
			<button id="search-button" class="btn btn-md btn-info" type="button">&nbsp;Pencarian Lnajutan&nbsp;<span class="fa fa-search-plus"></span></button>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form"><!--?php $this->renderPartial('_search',array('model'=>$model)); ?--></div>
			<?php $this->renderPartial('_sebaran',array('dataProvider'=>$dataProvider)); ?>			
			</div>
		</div>
	</section>
</div>
