<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">DATA LOKASI SEKRETARIAT</h2>
			<div class="actions panel_actions pull-right">
			<?php echo CHtml::link('TAMBAH SEKRETARIAT', array('lokasi/tambah'), array('class'=>'btn btn-md btn-primary')); ?>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
			<div id="map" style="height:500px"></div>
			<!--?php $this->renderPartial('_sekretariat',array('model'=>$model)); ?-->			
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 5,
	center: new google.maps.LatLng(-2.4538264, 118.0723276),
	mapTypeId: google.maps.MapTypeId.ROADMAP
});
</script>