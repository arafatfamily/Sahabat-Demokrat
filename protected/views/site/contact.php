<div class="small-12 columns">
	<div class="page-title">
		<h2>Tentang Kami</h2>
	</div>
</div>
<section id="main" class="medium-12 large-12 columns">
	<div class="section margin-top-off">
		<div class="contact-map" style="margin:1rem 0">
			<div id="map_address" class="google_map ""></div>		
		</div> 
	</div>
</section>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.gmap.min.js"></script>
<script type="text/javascript">
var MAPSET = (function ($, window) {
	return {
		objGoogleMap: {
			objMapAddress: {
				 address: "Wisma Proklamasi 41, Indonesia",
				 zoom: 14,
				 markers:[
					 {
						 address: "Wisma Proklamasi 41, Indonesia",
						 html: "DPP Partai Demokrat",
						 popup: true
					 }
				 ]
			},
			objMapExtended: {
				controls: false,
				scrollwheel: true,
				markers: [
					{
						latitude: -6.2021449,
						longitude: 106.8472434,
						icon: {
							image: "images/map/gmap_pin.png",
							iconsize: [44, 54],
							iconanchor: [12,46]
						}
					}
				],
				icon: {
					image: "images/map/gmap_pin.png", 
					iconsize: [44, 54],
					iconanchor: [12, 46]
				},
				latitude: -6.2021449,
				longitude: 106.8472434,
				zoom: 14
			}
			
		},
	}
}(jQuery, window));
if ($('.google_map').length || $('.google_map_expand').length) {
	if (!(typeof window.google === 'object' && window.google.maps)) {
		throw 'Google Maps API is required. Please register the following JavaScript library https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'
	}

	var methods = {
		mapAddress: function () {
			$('#map_address').gMap(MAPSET.objGoogleMap.objMapAddress);
		},
		mapExtended: function () {
			$('#map_extended').gMap(MAPSET.objGoogleMap.objMapExtended);
		}
	}
	methods.mapAddress();
	methods.mapExtended();
	if ($('.google_map_expand').length) {
		var $google_map_toggle = $('.google_map_toggle'),
			$google_map_close = $('.google_map_close');
		$google_map_toggle.on('click touchstart', function (e) {
			e.preventDefault();
			var $this = $(this);
			if (!$this.hasClass('expand')) {
				$this.addClass('expand');
				$google_map_close.addClass('active');
				$this.animate({
					height: '400'
				});
			}
		});
		$google_map_close.on('click touchstart', function (e) {
			e.preventDefault();
			if ($google_map_toggle.hasClass('expand')) {
				$google_map_toggle.removeClass('expand');
				$(this).removeClass('active');
				$google_map_toggle.animate({
					height: '140'
				});
			}
		});
	}
}
</script>