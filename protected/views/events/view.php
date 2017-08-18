<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
	<div class="page-title">
		<div class="pull-left">
			<h1 class="title"><?php echo $model->Nama; ?></h1>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12">
	<section class="box nobox">
		<div class="content-body">
			<div class="row">
				<div class="col-md-3 col-sm-4 col-xs-12">
					<div class="r1_graph1 db_box">
					<?php echo Select2::activeDropDownList('undangan', '', array(), array(
							'placeholder'=>'Silahkan Pilih Tamu Undangan',
							'class' => 'form-control',
							'select2Options'=>array(
								'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
								'minimumInputLength'=>'3',
								'ajax'=>array(
									'url'=> Yii::app()->createUrl('events/participant'),
									'type'=>'GET',
									'dataType'=>'json',
									'data'=>new CJavaScriptExpression('function (text, page) {return {q: text, page:page}}'),
									'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.participant};}'),						
								),
								'formatResult'=> new CJavaScriptExpression('function format(state) {
									var originalOption = state.element;
									return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
								}'),
								'formatSelection'=>new CJavaScriptExpression('function format(state) {
									var originalOption = state.element;
									return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
								}'),
							)
					)); ?>
					</div>
					<div class="uprofile-image">
						<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $admin->kader_id)); ?>" class="img-thumbnail img-responsive img-circle">
					</div>
					<div class="uprofile-name">
						<h3>
							<a class="text-uppercase" href="#"><?php echo $admin->username; ?></a>
							<span class="uprofile-status online"></span>
						</h3>
						<p class="uprofile-title">ADMIN ACARA</p>
					</div>
					<div class="uprofile-info">
						<ul class="list-unstyled">
							<li><i class='fa fa-home'></i> DPD. <?php echo Member::getKabProvKec($model->subdistrict, "nama_prov") ?></li>
							<li><i class='fa fa-home'></i> DPC. <?php echo Member::getKabProvKec($model->subdistrict, "nama_kab") ?></li>
							<li><i class='fa fa-users'></i> <?php echo Globals::Jumlah('EventMember', 'sesi_id', $sesi->ses_id, null); ?> TAMU/UNDANGAN</li>
						</ul>
					</div>
					<div class="uprofile-buttons">
					<?php if (Yii::app()->user->getAkses('3', '2') || Yii::app()->user->isSuperadmin()) {
						echo CHtml::button('EDIT ACARA', array('id'=>'btn-edit', 'class'=>'btn btn-warning btn-corner btn-block', 'submit'=>array('events/manage')));
					} ?>
					</div>
				</div>
				<div class="col-md-9 col-sm-8 col-xs-12">
					<div class="uprofile-content">
						<div class="enter_post col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="controls">
									<textarea class="form-control autogrow" id="field-7"  placeholder="Tulis komentar anda!"></textarea>
								</div>
							</div>
							<div class="enter_post_btns col-md-12 col-sm-12 col-xs-12">
								<a href="#" class="btn btn-md pull-right btn-primary">Post</a>
								<a href="#" class="btn btn-md pull-right btn-link"><i class="fa fa-image"></i></a>
								<a href="#" class="btn btn-md pull-right btn-link"><i class="fa fa-map-marker"></i></a>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="uprofile_wall_posts col-md-12 col-sm-12 col-xs-12">
							<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
								<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)); ?>">
							</div>
							<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
								<div class="username">
									<span class="bold text-uppercase">SUPERADMIN</span> mengomentari acara <span class="bold text-uppercase"><?php echo $model->Nama; ?></span>	
								</div>
								<div class="info text-muted">
									Tes komentar acara.
								</div>	
								<div class="info-details">
									<ul class="list-unstyled list-inline">
										<li><a href="#" class="text-muted">2 hari lalu</a></li>
										<li><a href="#" class="text-muted"><i class="fa fa-comment"></i> 1</a></li>
										<li><a href="#" class="text-orange"><i class="fa fa-heart"></i> 1</a></li>
										<li><a href="#" class="text-info"><i class="fa fa-reply"></i> Balas</a></li>
									</ul>
								</div>
								<div class="clearfix"></div>
								<div class="comment">
									<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
										<img data-src-retina="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)); ?>" data-src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)); ?>" src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)); ?>">
									</div>
									<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
										<div class="username">
											<span class="bold text-uppercase">SUPERADMIN</span> 
										</div>
										<div class="info text-muted">Balas komentar</div>	
										<div class="info-details">
											<ul class="list-unstyled list-inline">
												<li><a href="#" class="text-muted">1 hari lalu</a></li>
												<li><a href="#" class="text-orange"><i class="fa fa-heart"></i> Suka</a></li>
											</ul>
										</div>
									</div>	
									<div class="clearfix"></div>						
								</div>
								<div class="comment comment-input">
									<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
										<img data-src-retina="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>" data-src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>" src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>">
									</div>
									<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
										<div class="input-group primary  col-md-6">
											<input type="text" class="form-control" placeholder="Post a comment">
											<span class="input-group-addon">
												<i class="fa fa-rocket"></i>
											</span>
										</div>
									</div>
								</div>

							</div>	
							<div class="clearfix"></div>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>