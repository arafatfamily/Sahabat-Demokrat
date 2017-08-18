<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left bold">
				<i class="fa fa-sitemap icon-md icon-primary"></i> STRUKTUR ORGANISASI PARTAI DEMOKRAT
			</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<?php $this->renderPartial('_search', array()); ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<ul class="nav nav-tabs nav-justified primary">
						<li>
							<a href="#_list" data-toggle="tab">
								<i class="fa fa-list-alt"></i> DAFTAR DEWAN PIMPINAN
							</a>
						</li>
						<li>
							<a href="#_bagan" data-toggle="tab">
								<i class="fa fa-sitemap"></i> BAGAN STRUKTUR ORGANISASI
							</a>
						</li>
						<li class="active">
							<a href="#_manage" data-toggle="tab">
								<i class="fa fa-gear"></i> PENGATURAN STRUKTUR ORGANISASI
							</a>
						</li>
					</ul>
					<div class="tab-content primary">
						<div class="tab-pane fade" id="_list">
							<div class="col-md-12">
							<!--?php $this->renderPartial('_list', array('dataProvider'=>$dataProvider)); ?-->
							</div><div class="clearfix"></div>
						</div>
						<div class="tab-pane fade" id="_bagan">
							<div class="col-md-12">
							<!--?php $this->renderPartial('_bagan', array('model'=>$model)); ?-->
							</div><div class="clearfix"></br></div>
						</div>
						<div class="tab-pane fade in active" id="_manage">
							<div class="col-md-12">
							<?php $this->renderPartial('_manage', array('model'=>$model)); ?>
							</div><div class="clearfix"></br></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>