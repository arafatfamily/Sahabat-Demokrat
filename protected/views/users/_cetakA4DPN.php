<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<?php foreach ($model as $data) {
		echo '<style type="text/css">
				@media print{
					.img-responsive {
						width: 20.4em;
						float: left;
						-moz-transform: scaleX(-1);
						-o-transform: scaleX(-1);
						-webkit-transform: scaleX(-1);
						transform: scaleX(-1);
						filter: FlipH;
						-ms-filter: "FlipH";
					}
				}
			</style>';
		echo '<div class="col-md-6">';
		echo '<img class="img-responsive" src="'.$this->createUrl('member/frontKTA') . '/' . $data['id'].'" alt="KTA DEPAN ' . $data['member_name'] . '" style="padding: 0.4em 1em 0.4em 0.9em;">';
		echo '</div>';
	} ?>
	</div>
</div>