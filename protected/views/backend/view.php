<div class="tab-content vertical col-lg-9 col-md-9 col-sm-8 col-xs-8 left-aligned primary">
	<div class="tab-pane fade in active" id="Tampilan">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<ul class="nav nav-tabs nav-justified primary">
				<li class="active">
					<a href="#active" data-toggle="tab">
						<i class="fa fa-home"></i> Gambar digunakan
					</a>
				</li>
				<li <?php echo (!Yii::app()->user->isSuperadmin() ? 'style="display: none;"' : ''); ?>>
					<a href="#manage" data-toggle="tab">
						<i class="fa fa-gears"></i> Ubah Gambar
					</a>
				</li>
			</ul>
			<div class="tab-content primary">
				<div class="tab-pane fade in active" id="active">
					<div class="col-md-12">
					<?php $this->renderPartial('tampilan'); ?>
					</div><div class="clearfix"></br></div>
				</div>
				<div class="tab-pane fade" id="manage">
					<div class="col-md-12">
					<?php $this->renderPartial('img_form'); ?>
					</div><div class="clearfix"></br></div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="tab-pane fade" id="Menu">
		<?php $this->renderPartial('menu'); ?>
	</div>
	<div class="tab-pane fade" id="Akses">
		<?php $this->renderPartial('hak_akses'); ?>
	</div>
</div>