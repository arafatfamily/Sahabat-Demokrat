<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="tile-counter bg-orange">
		<div class="content">
			<i class='fa fa-exclamation-circle icon-lg'></i>
			<h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('KritikSaran','status','P'); ?>">0</h2>
			<div class="clearfix"></div>
			<span><strong>D I T U N D A</strong></span>
		</div>
	</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="tile-counter bg-success">
		<div class="content">
			<i class='fa fa-retweet icon-lg'></i>
			<h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('KritikSaran','status','R'); ?>">0</h2>
			<div class="clearfix"></div>
			<span><strong>D I J A W A B</strong></span>
		</div>
	</div>
</div>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="tile-counter bg-secondary">
		<div class="content">
			<i class='fa fa-ban icon-lg'></i>
			<h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('KritikSaran','status','C'); ?>">0</h2>
			<div class="clearfix"></div>
			<span><strong>D I T U T U P</strong></span>
		</div>
	</div>
</div><div class="clearfix"></div>
<?php if(Globals::Total('KritikSaran','','') == 0) { ?>
	<div class="alert alert-info alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Info :</strong></br>Maaf! Saat ini anda belum memiliki Kritik atau Saran Untuk Developer.
	</div>
<?php } else { 
	foreach($dataProvider as $data) { ?>
		<div class="uprofile_wall_posts col-md-8 col-sm-8 col-xs-12">
			<hr style="border-bottom: 1px solid green;margin-top: 1px">
			<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
				<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)); ?>">
			</div>
			<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
				<div class="username">
					<span class="bold text-uppercase">SUPERADMIN</span>
						Memberi <?php echo $data->tipe_pesan == 'K' ? 'Kritik' : 'Saran'; ?>
					<span class="bold text-uppercase"> <?php echo $data->judul; ?></span>	
				</div>
				<div class="info text-muted"><?php echo $data->konten; ?></div>	
				<div class="info-details">
					<ul class="list-unstyled list-inline">
						<li class="text-muted"><i class="fa fa-clock-o"></i> <?php echo Globals::dateIndonesia($data->update_time); ?></li>
						<li><span class="bold text-uppercase badge badge-default"><?php echo $data->tipe_app == 'W' ? 'Website' : 'Mobile'; ?></span></li>
						<?php if(Globals::Total('KritikRespons','kritik_id',$data->id) == 0) { ?>
							<li><a href="#showResponse" id="showResponse_<?php echo $data->id; ?>" onclick="return alert('Tidak ada tanggapan dari Webmaster!')" class="text-orange">
								<span class="bold text-uppercase badge badge-orange">
									<i class="fa fa-eye-slash"></i> 0 TANGGAPAN</span></a></li>
						<?php } else { ?>
							<li>
								<a href="#showResponse" id="showResponse_<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>" class="text-orange">
									<span class="bold text-uppercase badge badge-orange">
										<i class="fa fa-eye"></i> <?php echo Globals::Total('KritikRespons','kritik_id',$data->id); ?> TANGGAPAN
									</span>
								</a>
							</li>
						<?php } if(Yii::app()->user->isSuperadmin()) { ?>
							<li><a href="#reply" onclick="$('#showReply_<?php echo $data->id; ?>').fadeToggle(750)" class="text-info">
								<span class="bold text-uppercase badge badge-purple"><i class="fa fa-reply"></i> BALAS</span></a></li>
						<?php } if($data->status == 'C') { ?>
							<li class="text-muted"><span class="bold text-uppercase badge badge-danger"><i class="fa fa-times-circle"></i> DITUTUP</span></li>
						<?php } ?>
					</ul>
				</div>
				<div class="clearfix"></div>
				<?php $response=KritikRespons::model()->findAllByAttributes(array('kritik_id'=>$data->id));
				if(count($response) > 0) {
					foreach($response as $comment) { ?>
						<div id="response_<?php echo $data->id; ?>" class="comment" style="display: none;">
							<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
								<img data-src-retina="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $comment->admin_id)); ?>" data-src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $comment->admin_id)); ?>" src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $comment->admin_id)); ?>">
							</div>
							<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
								<div class="username">
									<span class="bold text-uppercase badge badge-info"><?php echo $comment->admin_id == 1 ? 'Yasir Arafat, A.Md' : 'Webmaster'; ?></span>
									<i class="fa fa-clock-o"></i> <?php echo Globals::dateIndonesia($data->update_time); ?>
								</div>
								<div class="info text-muted"><?php echo $comment->konten; ?></div>
							</div>	
							<div class="clearfix"></div>						
						</div>
					<?php } ?>
				<?php } ?>
				<div id="showReply_<?php echo $data->id; ?>" class="comment comment-input" style="display: none;">
					<div class="pic-wrapper col-md-1 col-sm-1 col-xs-2 text-center">
						<img data-src-retina="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>" data-src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>" src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getuser("users_id"))); ?>">
					</div>
					<div class="info-wrapper col-md-11 col-sm-11 col-xs-10">					
						<div class="input-group default col-md-12">
							<input id="reply_<?php echo $data->id; ?>" data-id="<?php echo $data->id; ?>" type="text" class="form-control" placeholder="Tulis komentar anda !">
							<span class="input-group-addon" onclick="sendReply(<?php echo $data->id; ?>, $('#reply_<?php echo $data->id; ?>').val())">
								<a href="#"><i class="fa fa-send icon-info"></i></a>
							</span>
						</div>
					</div>
				</div>
			</div>					
		</div>
<?php }
} ?>