<div class="chat_container">
	<div class="col-sm-3 chat_sidebar">
		<div class="row">
			<div id="custom-search-input">
				<div class="input-group col-md-12">
					<input type="text" class="  search-query form-control" placeholder="cari percakapan" />
					<button class="btn btn-danger" type="button">
						<span class=" glyphicon glyphicon-search"></span>
					</button>
				</div>
			</div>
			<div class="dropdown all_conversation">
				<button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-weixin" aria-hidden="true"></i> Semua Pesan <span class="caret pull-right"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<li><a href="#"> Semua Pesan </a></li>
					<li><a href="#"> Pesan Non-Kader </a></li>
					<li><a href="#"> [GRUP] Staff PEW</a></li>
				</ul>
			</div>
			<div class="member_list">
				<ul class="list-unstyled">
					<li class="left clearfix">
						<span class="chat-img pull-left">
							<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)) ?>" alt="User Avatar" class="img-circle">
						</span>
						<div class="chat-body clearfix">
							<div class="header_sec">
								<strong class="primary-font">Yasir Arafat, A.Md</strong>
								<strong class="pull-right">00:45 AM</strong>
							</div>
							<div class="contact_sec">
							<small class="primary-font"><i class="glyphicon glyphicon-phone"></i> +6281365517100</small> <span class="badge pull-right">0</span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-9 message_section">
		<div class="row">
			<div class="new_message_head">
				<div class="pull-left"><button><i class="fa fa-plus-square-o" aria-hidden="true"></i> New Message</button></div>
				<div class="pull-right">
					<div class="dropdown">
						<button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-cogs" aria-hidden="true"></i>  Setting
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
							<li><a href="#">Action</a></li>
							<li><a href="#">Profile</a></li>
							<li><a href="#">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="chat_area">
				<ul class="list-unstyled">
					<li class="left clearfix">
						<span class="chat-img1 pull-left">
							<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)) ?>" alt="User Avatar" class="img-circle">
						</span>
						<div class="chat-body1 clearfix">
							<p>TEST TERIMA SMS !.</br><small class="badge badge-info chat_time pull-right"> 00:40 PM</small></p>
						</div>
					</li>
					<li class="left clearfix admin_chat">
						<span class="chat-img1 pull-right">
							<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)) ?>" alt="User Avatar" class="img-circle">
						</span>
						<div class="chat-body1 clearfix">
							<p>TEST KIRIM SMS !</br><small class="badge badge-info chat_time pull-left"> 00:45 PM</small></p>
						</div>
					</li>
				</ul>
			</div>
			<div class="message_write">
				<textarea class="form-control" placeholder="Balas ?"></textarea>
				<div class="clearfix"></div>
				<div class="chat_bottom">
					<a href="#" class="pull-left upload_btn"><i class="fa fa-cloud-upload" aria-hidden="true"></i>Add Files</a>
					<a href="#" class="pull-right btn btn-success"> K I R I M </a>
				</div>
			</div>
		</div>
	</div>
</div><div class="clearfix"></div>