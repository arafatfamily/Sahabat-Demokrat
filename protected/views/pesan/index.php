<div class="col-md-12 col-sm-12 col-xs-12">
	<ul class="nav nav-tabs nav-justified primary">
		<li class="active">
			<a href="#conversation" data-toggle="tab">
				<i class="fa fa-home"></i> PESAN SINGKAT
			</a>
		</li>
		<li <?php echo (!Yii::app()->user->isSuperadmin() ? 'style="display: none;"' : ''); ?>>
			<a href="#options" data-toggle="tab" onclick="LogContent();">
				<i class="fa fa-road"></i> GROUP & OPSI
			</a>
		</li>
		<li <?php echo (!Yii::app()->user->isSuperadmin() ? 'style="display: none;"' : ''); ?>>
			<a href="#settings" data-toggle="tab">
				<i class="fa fa-gears"></i> PENGATURAN
			</a>
		</li>
	</ul>
	<div class="tab-content primary">
		<div class="tab-pane fade in active" id="conversation">
			<?php $this->renderPartial('_default'); ?>
		</div>
		<div class="tab-pane fade" id="options">
			<div class="col-md-12">
			Loading Application log ... 
			</div><div class="clearfix"></br></div>
		</div>
		<div class="tab-pane fade" id="settings">
			<div class="col-md-12">
			Loading Application log ... 
			</div><div class="clearfix"></br></div>
		</div>
	</div>
</div>