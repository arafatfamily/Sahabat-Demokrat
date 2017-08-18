<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">MANAGEMENT ACARA PARTAI DEMOKRAT</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-4">
				<?php $this->renderPartial('_widget', array('model'=>$model, 'sesi'=>$sesi)); ?>
				</div>
				<div class="col-md-8">
				<?php $this->renderPartial('_form', array('model'=>$model, 'sesi'=>$sesi)); ?>
				</div>
			</div>
		</div>
	</section>
</div>