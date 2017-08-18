<div class="col-lg-12">
<?php if (!Yii::app()->user->isSuperadmin()) { ?>
	<div class="alert alert-error alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>WEBMASTER MESSAGE :</strong> Jadwal Pembaruan <strong>{ENGINE}</strong> Sistem Keanggotaan !</br>
		Sehubungan dengan adanya update sistem engine pada web dan/atau server keanggotaan PARTAI DEMOKRAT, maka server akan mengalami gangguan selama (±) 6 Jam.</br>
		Yang terjadwal pada hari Kamis 17 Agustus 2017 Pukul 00.00 - 06.00.</br>
		<strong>code:msg[i]</strong> Webmaster.
	</div>
<?php } ?>
	<section class="box inverted">
		<header class="panel_header">
			<h2 class="title pull-left"><i class='fa fa-users icon-sm'></i> GLOBAL STATISTIK KADER PARTAI DEMOKRAT</h2>
		</header>
		<div class="content-body" style="padding: 30px 30px 0 30px;">
			<div class="row">
				<div class="col-lg-3 col-xs-12 col-sm-6">
					<div class="tile-counter bg-info" style="padding:15px;">
						<div class="content">
							<i class='fa fa-users icon-lg inviewport animated  animated-delay-600ms animated-duration-1400ms' data-vp-add-class='visible bounceIn'> <h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('Member','',''); ?>">0</h2></i>
							<div class="clearfix"></div>
							<span><b>T E R D A F T A R</b></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-12 col-sm-6">
					<div class="tile-counter bg-success" style="padding:15px;">
						<div class="content">
							<i class='fa fa-check-square-o icon-lg inviewport animated  animated-delay-600ms animated-duration-1400ms' data-vp-add-class='visible bounceIn'> <h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('Member','member_status','A'); ?>">0</h2></i>
							<div class="clearfix"></div>
							<span><b>TERVERIFIKASI</b></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-12 col-sm-6">
					<div class="tile-counter bg-warning" style="padding:15px;">
						<div class="content">
							<i class='fa fa-minus-circle icon-lg inviewport animated  animated-delay-600ms animated-duration-1400ms' data-vp-add-class='visible bounceIn'> <h2 class="number_counter" data-speed="3000" data-from="0" data-to="<?php echo Globals::Total('Member','member_status','N'); ?>">0</h2></i>
							<div class="clearfix"></div>
							<span><b>T E R T U N D A</b></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-12 col-sm-6">
					<div class="tile-counter bg-danger" style="padding:15px;">
						<div class="content">
							<i class='fa fa-times icon-lg inviewport animated  animated-delay-600ms animated-duration-1400ms' data-vp-add-class='visible bounceIn'> <h2 class="number_counter" data-speed="3000" data-from="<?php echo Globals::Total('Member','',''); ?>" data-to="<?php echo Globals::Total('Member','member_status','B'); ?>">0</h2></i>
							<div class="clearfix"></div>
							<span><b>D I B L O K I R</b></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-12">
	<section class="box inverted">
		<div class="content-body" style="padding: 5px 30px;">
			<div class="row carousel slide">
			<?php echo Settings::bestReference(); ?>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-3">
	<section class="box success">
		<header class="panel_header">
			<h2 class="title pull-left"><i class='fa fa-bar-chart icon-sm'></i> GRAFIK HARIAN</h2>
		</header>
		<div class="content-body" style="padding: 5px 30px 0 0;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<canvas id="bar-harian"></canvas>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-3">
	<section class="box primary">
		<header class="panel_header">
			<h2 class="title pull-left"><i class='fa fa-bar-chart icon-sm'></i> GRAFIK MINGGUAN</h2>
		</header>
		<div class="content-body" style="padding: 5px 30px 0 0;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<canvas id="bar-mingguan"></canvas>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-3">
	<section class="box info">
		<header class="panel_header">
			<h2 class="title pull-left"><i class='fa fa-bar-chart icon-sm'></i> GRAFIK BULANAN</h2>
		</header>
		<div class="content-body" style="padding: 5px 30px 0 0;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<canvas id="bar-bulanan"></canvas>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-lg-3">
	<section class="box purple">
		<header class="panel_header">
			<h2 class="title pull-left"><i class='fa fa-bar-chart icon-sm'></i> GRAFIK TAHUNAN</h2>
		</header>
		<div class="content-body" style="padding: 5px 30px 0 0;">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<canvas id="bar-tahunan"></canvas>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/countto.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/dashboard.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/chart-sparkline.js" type="text/javascript"></script>



