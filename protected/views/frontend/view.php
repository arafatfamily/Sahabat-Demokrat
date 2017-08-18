<?php //Model Sementara
$settings = new SiteConfig;
?>
<div class="tab-content vertical col-lg-10 col-md-10 col-sm-9 col-xs-9 left-aligned primary">
	<div class="tab-pane fade in active" id="settings">
	<?php $this->renderPartial('_globalSet', array('settings'=>$settings)); ?>
	</div>
	<div class="tab-pane fade" id="Menu">
		<p><h2 class="text-center">Fitur ini masih dalam tahap pengembangan.</h2></p>
		<p class="text-center">Silahkan hubungi <a href="mailto:arafat.jr@icloud.com">WEBMASTER</a> untuk info lebih lanjut. </p>
	</div>
	<div class="tab-pane fade" id="slide">
	<?php $this->renderPartial('_slideForm', array('slider'=>$slider)); ?>
	</div>
	<div class="tab-pane fade" id="widget">
		<p><h2 class="text-center">Fitur ini masih dalam tahap pengembangan.</h2></p>
		<p class="text-center">Silahkan hubungi <a href="mailto:arafat.jr@icloud.com">WEBMASTER</a> untuk info lebih lanjut. </p>
	</div>
	<div class="tab-pane fade" id="content">
		<p><h2 class="text-center">Fitur ini masih dalam tahap pengembangan.</h2></p>
		<p class="text-center">Silahkan hubungi <a href="mailto:arafat.jr@icloud.com">WEBMASTER</a> untuk info lebih lanjut. </p>
	</div>
	<div class="tab-pane fade" id="meta">
		<p><h2 class="text-center">Fitur ini masih dalam tahap pengembangan.</h2></p>
		<p class="text-center">Silahkan hubungi <a href="mailto:arafat.jr@icloud.com">WEBMASTER</a> untuk info lebih lanjut. </p>
	</div>
	<div class="tab-pane fade" id="about">
		<p><h2 class="text-center">Fitur ini masih dalam tahap pengembangan.</h2></p>
		<p class="text-center">Silahkan hubungi <a href="mailto:arafat.jr@icloud.com">WEBMASTER</a> untuk info lebih lanjut. </p>
	</div>
</div>