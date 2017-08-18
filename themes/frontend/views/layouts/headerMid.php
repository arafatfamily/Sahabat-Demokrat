<div class="header-middle">
	<div class="row">
		<div class="large-12 columns">
			<div class="header-middle-entry">
				<div class="logo">
					<span class="tmm_logo">
						<a title="Sahabat Demokrat" href="<?php echo Yii::app()->getBaseUrl(true); ?>"><b>Sahabat </b>Demokrat</a>
					</span>
				</div>
				<div class="account" style="position: static;">
					<ul style="float: right;">
						<li style="padding: 0px; position: static;" data-account="accountDialog">
                        <?php if (Yii::app()->user->isGuest) { ?>
							<a href="#" class="button large donate" style="margin-bottom: 0px;margin-bottom: 0;font-size: x-large;box-shadow: 3px -3px 10px 0px black;"> PENDAFTARAN </a>
                        <?php } else { ?>
							<a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="button large donate" style="margin-bottom: 0px;margin-bottom: 0;font-size: x-large;box-shadow: 3px -3px 10px 0px black;"> KELUAR </a>
						<?php } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>