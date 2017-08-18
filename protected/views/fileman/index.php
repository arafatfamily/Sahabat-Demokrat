<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active">
			<a href="#dokumen" data-toggle="tab">
				<i class="fa fa-home"></i> Data Dokumen
			</a>
		</li>
		<li>
			<a href="#manage" data-toggle="tab">
				<i class="fa fa-gears"></i> Dokumen Manager
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="dokumen">
			<div class="col-md-12">
			<!--?php $this->renderPartial('_view', array('dataProvider' => $dataProvider)); ?-->
			</div><div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="manage">
			<div class="col-md-12">
			<?php $this->renderPartial('_form', array('model' => $model)); ?>
			</div><div class="clearfix"></br></div>
		</div>
	</div>
</div>