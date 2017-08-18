<style type="text/css"> th { text-align: left !important; } </style>
<div class="col-lg-6">
	<section class="box nobox">
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="wid-blog">
						<div class="bg-poster wid-blog-title" style="background: url('<?php echo Yii::app()->createUrl('merchant/loadPoster', array('id'=>$model->idm)); ?>'); ">
							<h3 class="bold text-uppercase bg-info transparent"><?php echo $model->nama; ?></h3>
							<span class="actions"><i class="fa fa-pencil-square icon-rounded icon-purple"></i></span>
						</div>
						<div class="bg-white bg-poster wid-blog-content">
							<div class="pic-wrapper col-md-2 col-sm-2 col-xs-3 text-center">
							<?php echo CHtml::image(Yii::app()->createUrl('member/loadPhoto', array('id'=>$model->member_id)), '', array('class'=>'img-responsive')) ?>
							</div>
							<div class="info-wrapper col-md-10 col-sm-10 col-xs-9">					
								<div class="username">
									<h4 class="bold text-uppercase bg-primary"><?php echo $member->member_name; ?></h4>
								</div>
								<div class="info text-muted"><?php echo $model->keterangan; ?></div>	
								<div class="info-details">
									<ul class="list-unstyled list-inline">
										<li class="text-muted"><?php echo Globals::dateIndonesia($model->date_join); ?></li>
										<li><a href="#" class="text-muted"><i class="fa fa-comment"></i> 0</a></li>
										<li><a href="#" class="text-orange"><i class="fa fa-heart"></i> 0</a></li>
									</ul>
								</div>
								<div class="clearfix"></div>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-6">
	<section class="box">
		<header class="panel_header">
			<h2 class="title pull-left"><i class="fa fa-info-circle icon-sm"></i> INFORMASI MERCHANT</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						array(
							'name' => 'date_join',
							'type' => 'raw',
							'value' => Globals::dateIndonesia($model->date_join)
						),
						array(
							'name' => 'member_id',
							'type' => 'raw',
							'value' => $member->member_name
						),
						'nama',
						array(
							'name' => 'alamat',
							'type' => 'raw',
							'value' => $model->alamat . ',</br>Kel. ' . Member::getKabProvKec($model->subdistrict, "nama_kel") . ', Kec. ' . Member::getKabProvKec($model->subdistrict, "nama_kec") . ',</br>Kab. ' . Member::getKabProvKec($model->subdistrict, "nama_kab") . ' - ' . Member::getKabProvKec($model->subdistrict, "nama_prov")
						),
						array(
							'name' => 'keterangan',
							'type' => 'raw',
							'value' => $model->keterangan
						),
					),
				)); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-12">
	<section class="box">
		<header class="panel_header">
			<h2 class="title pull-left"><i class="fa fa-map-marker icon-sm"></i> INFORMASI LOKASI MERCHANT</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<div id="mapLokasi"></div>
			</div>
		</div>
	</section>
</div>