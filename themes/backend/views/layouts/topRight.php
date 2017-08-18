<div class='pull-right'>
	<ul class="info-menu right-links list-inline list-unstyled">
		<li class="profile">
			<a href="#" data-toggle="dropdown" class="toggle">
				<img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => Yii::app()->user->getUser("kader_id"))); ?>" alt="user-image" class="img-circle img-inline">
				<span><?php echo Yii::app()->user->getUser("username") ?> <i class="fa fa-angle-down"></i></span>
			</a>
			<ul class="dropdown-menu profile animated fadeIn">
				<li>
					<a href="#settings">
						<i class="fa fa-wrench"></i>
						Settings
					</a>
				</li>
				<li>
					<a href="#profile">
						<i class="fa fa-user"></i>
						Profil
					</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->createUrl('backend/bantuan'); ?>">
						<i class="fa fa-info"></i>
						Bantuan !
					</a>
				</li>
				<li class="last">
					<a href="<?php echo Yii::app()->createUrl('users/logout'); ?>">
						<i class="fa fa-lock"></i>
						Logout
					</a>
				</li>
			</ul>
		</li>
		<li class="chat-toggle-wrapper">
			<a href="#" data-toggle="chatbar" class="toggle_chat">
				<i class="fa fa-comments"></i>
				<?php
				$cSQL = "SELECT COUNT(status) as unread from users_chat where status = 'U' AND users_id = '".Yii::app()->user->getUser("users_id")."'";
				$rows = Yii::app()->db->createCommand($cSQL)->queryAll();
				foreach ($rows as $ttl) {
					echo '<span class="badge badge-warning">'.$ttl['unread'].'</span>';
				}
				?>
				<i class="fa fa-times"></i>
			</a>
		</li>
	</ul>			
</div>	