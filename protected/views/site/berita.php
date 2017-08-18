<div class="small-12 columns">
	<div class="page-title">
		<h2><?php echo $model->judul; ?></h2>
		<div class="breadcrumbs">
			Ditulis Oleh : <a href="#" title=""><?php echo Globals::findByRef("users","username","users_id='".$model->admin."'"); ?></a>
			Tanggal : <?php echo Globals::dateIndonesia($model->tgl_post); ?>
		</div>
	</div>
</div>
<section id="main" class="large-8 columns">
	<?php echo $model->isi_berita; ?>
</section>
<aside id="sidebar" class="large-4 columns">
	<div class="widget widget_metro_style">
		<ul class="metro_container">
			<li>
				<a class="icon-megaphone style-3" href="events.html">
					<span>Events</span>
					<i>Events</i>
				</a>
			</li>
			<li>
				<a class="style-1" href="donations.html">
					<span>Get Involved</span>
					<i>Get Involved</i>
				</a>
			</li>
			<li>
				<a class="style-4" href="issues.html">
					<span>Issues and Positions</span>
					<i>Issues and Positions</i>
				</a>
			</li>
			<li>
				<a class="icon-thumbs-up-5 style-2" href="volunteer.html">
					<span>Volunteer</span>
					<i>Volunteer</i>
				</a>
			</li>
		</ul>
	</div>
</aside>