<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active"><a href="#_add" data-toggle="tab"> TAMBAH STRUKTUR</a></li>
		<li><a href="#_data" data-toggle="tab"> DATA STRUKTUR</a></li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="_add">
			<div class="col-md-12">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div><div class="clearfix"></div>
		</div>
		<div class="tab-pane fade" id="_data">
			<div class="col-md-12">
			<!--?php $this->renderPartial('_bagan', array('model'=>$model)); ?-->
			</div><div class="clearfix"></br></div>
		</div>
	</div>
</div>