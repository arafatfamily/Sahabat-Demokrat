<div class="col-lg-12">
	<section class="box">
		<header class="panel_header">
			<h2 class="title pull-left">Management Berita Situs</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<ul class="nav nav-tabs nav-justified primary">
						<li>
							<a href="#list-berita" data-toggle="tab">
								<i class="fa fa-newspaper-o"></i> Data Berita
							</a>
						</li>
						<li class="active">
							<a href="#buat-berita" data-toggle="tab">
								<i class="fa fa-plus-square"></i> Buat Berita 
							</a>
						</li>
					</ul>

					<div class="tab-content primary">
						<div class="tab-pane fade" id="list-berita">
							<div>
							<?php $this->widget('zii.widgets.CListView', array(
								'dataProvider'=>$dataProvider,
								'itemView'=>'_view',
							)); ?>
							</div>
						</div>
						<div class="tab-pane fade in active" id="buat-berita">
						<?php $this->renderPartial('_form', array('model'=>$model)); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-12">
	<section class="box">
		<header class="panel_header bg-purple">
			<h2 class="title pull-left" style="color: #ffffff">Pengaturan Berita Situs</h2>
		</header>
		<div class="content-body">
			<div class="row">
			
			</div>
		</div>
	</section>
</div>