<?php
/* @var $this FrontEndController */

$this->breadcrumbs=array(
	'Front End',
);
?>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">FrontEnd Settings</h2>
			<div class="actions panel_actions pull-right">
			</div>
		</header><div class="clearfix"></div></br>
		<div class="row col-xs-12">
			<div class="col-xs-12">
				<ul class="nav nav-tabs vertical col-lg-2 col-md-2 col-sm-3 col-xs-3 left-aligned primary">
					<li class="active"><a href="#settings" data-toggle="tab"><i class="fa fa-sliders"></i>Konfigurasi Tema</a></li>
					<li><a href="#Menu" data-toggle="tab"><i class="fa fa-th-list"></i>Layout Menu</a></li>
					<li><a href="#slide" data-toggle="tab"><i class="fa fa-toggle-right"></i>Home Slider</a></li>
					<li><a href="#widget" data-toggle="tab"><i class="fa fa-tasks"></i>Widget Settings </a></li>
					<li><a href="#content" data-toggle="tab"><i class="fa fa-slack"></i>Konten Settings </a></li>
					<li><a href="#meta" data-toggle="tab"><i class="fa fa-code"></i>Meta Settings </a></li>
					<li><a href="#about" data-toggle="tab"><i class="fa fa-info-circle"></i>Tentang Situs</a></li>
				</ul>
				<?php $this->renderPartial('view', array('slider'=>$slider)); ?>
			</div>
		</div><div class="clearfix"></div></br>
	</section>
</div>