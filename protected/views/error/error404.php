<?php if (Yii::app()->user->isAdmin()) { ?>
	<div class="col-xs-12">
		<section class="box ">
			<header class="panel_header">
				<h2 class="title pull-left"><?php echo $error->err_title; ?></h2>
				<div class="actions panel_actions pull-right">
				<span class="badge badge-danger"><?php echo $error->code; ?></span>
				</div>
			</header>
			<div class="content-body">
				<div class="row">
				<?php if ($error->ishtml == 'Y') {
					echo $error->htmltext;
				} else{
					echo $error->nonhtml;
				} ?>
				</div>
			</div>
		</section>
	</div>
<?php } else {
	echo "404";
}
?>