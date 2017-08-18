<div class="small-12 columns">
	<div class="page-title">
		<h2>Arsip Publik</h2>
	</div>
</div>
<section id="main" class="medium-8 large-8 columns"></br>
	<?php foreach($model as $data) {
		echo '<div class="testimonial">';
		echo '<div class="author-thumb">';
		if($data["file_type"] == "application/pdf") {
			echo '<img src="'.Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "pdf_icon")).'" alt="'.$data["name"].'" style="height: 8em;">';
		} else {
			echo '<img src="images/testimonials/testimonials.jpg" alt="Kathy Kerry">';
		}
		echo '</div>';
		echo '<h3>'.$data["name"].'</h3>';
		echo '<blockquote><p>'.$data["keterangan"].'</p></blockquote>';
		echo '<div class="quote-meta">'.Users::model()->findByPk($data["owner"])->username.'</div>';
		echo '</div>';
	} ?>
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