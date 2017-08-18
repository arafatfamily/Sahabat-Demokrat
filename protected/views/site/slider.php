<?php
$vid = "SELECT videos,vd_type,position as posisi FROM site_video WHERE status='P' LIMIT 1";
$cQuery = Yii::app()->db->createCommand($vid)->queryAll();
$Slide = "SELECT id_slide, nama, heading, paragraph, nomor FROM site_slider WHERE status='P'";
$cSlide = Yii::app()->db->createCommand($Slide)->queryAll();
if (count($cQuery) == 1) {
	echo "<div class='video'><img src='https://t4.ftcdn.net/jpg/00/80/43/37/500_F_80433730_SVjZDFWQ1F6yGawvBwowh37w71LksvmB.jpg'/></div>";
	echo '<div id="layerslider_1_1" class="ls-wp-container" style="width:785px;height:500px;max-width:785px;margin:0 auto;margin-bottom: 0px; float: right">';
	foreach ($cSlide as $data) {
		echo '<div class="ls-slide" data-ls="transition2d:11;"><img src="' . Yii::app()->controller->createUrl('frontend/loadImgSlide', array('id'=>$data['id_slide'])) . '" class="ls-bg" alt="slide-' . $data['id_slide'] . '"/>';
		if ($data['heading'] != '' && $data['paragraph'] != '') {
			echo '<h2 class="ls-l" style="top:210px;left:50%;font-size:48px;white-space: nowrap;" data-ls="offsetxin:0;durationin:600;delayin:500;easingin:easeInOutSine;scalexin:0.5;scaleyin:0.5;offsetxout:0;durationout:600;easingout:easeInOutExpo;scalexout:0;scaleyout:0;">' . $data['heading'] . '</h2><div class="ls-l" style="top:175px;left:50%;width:752px;height:1px;white-space: nowrap;" data-ls="offsetxin:0;durationin:700;delayin:800;easingin:linear;scalexin:0;offsetxout:0;durationout:600;scalexout:0;"><hr></div><div class="ls-l" style="top:267px;left:50%;width:752px;height:1px;white-space: nowrap;" data-ls="ut:0;durationout:600;scalexout:0;"><hr></div><div class="ls-l" style="top:310px;left:0px;width: 80%; left: 50%; @include transform(translateX(-50%));white-space: nowrap;" data-ls="offsetxin:0;offsetyin:20;durationin:500;delayin:1400;easingin:linear;scalexin:0.7;scaleyin:0.7;offsetxout:0;durationout:600;easingout:easeInOutExpo;scalexout:0;scaleyout:0;"><p class="text-center">' . $data['paragraph'] . '</p></div>';
		}
		echo '</div>';
	}
	echo "</div>";
} else {
	echo '<div id="layerslider_1_1" class="ls-wp-container" style="width:1140px;height:500px;max-width:1140px;margin:0 auto;margin-bottom: 0px;">';
	foreach ($cSlide as $data) {
		echo '<div class="ls-slide" data-ls="transition2d:11;"><img src="' . Yii::app()->controller->createUrl('frontend/loadImgSlide', array('id'=>$data['id_slide'])) . '" class="ls-bg" alt="slide-' . $data['id_slide'] . '"/>';
		if ($data['heading'] != '' && $data['paragraph'] != '') {
			echo '<h2 class="ls-l" style="top:210px;left:50%;font-size:48px;white-space: nowrap;" data-ls="offsetxin:0;durationin:600;delayin:500;easingin:easeInOutSine;scalexin:0.5;scaleyin:0.5;offsetxout:0;durationout:600;easingout:easeInOutExpo;scalexout:0;scaleyout:0;">' . $data['heading'] . '</h2><div class="ls-l" style="top:175px;left:50%;width:752px;height:1px;white-space: nowrap;" data-ls="offsetxin:0;durationin:700;delayin:800;easingin:linear;scalexin:0;offsetxout:0;durationout:600;scalexout:0;"><hr></div><div class="ls-l" style="top:267px;left:50%;width:752px;height:1px;white-space: nowrap;" data-ls="ut:0;durationout:600;scalexout:0;"><hr></div><div class="ls-l" style="top:310px;left:0px;width: 80%; left: 50%; @include transform(translateX(-50%));white-space: nowrap;" data-ls="offsetxin:0;offsetyin:20;durationin:500;delayin:1400;easingin:linear;scalexin:0.7;scaleyin:0.7;offsetxout:0;durationout:600;easingout:easeInOutExpo;scalexout:0;scaleyout:0;"><p class="text-center">' . $data['paragraph'] . '</p></div>';
		}
		echo '</div>';
	}
	echo '</div>';
}
?>