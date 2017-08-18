var map, marker;
var geocoder;

$(document).ready(function() {
	geocoder = new google.maps.Geocoder();
	var mapOptions = {
		center: new google.maps.LatLng(-6.202087, 106.846381),
		zoom: 11,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
    map = new google.maps.Map(document.getElementById("clocationmap"), mapOptions);
	
	marker = new google.maps.Marker({
		position: new google.maps.LatLng(-6.202087, 106.846381),
		map: map
	});
	
	google.maps.event.addListener(map, 'drag', function() {
		onChange();
	});
	
	if($('.lat_<?php echo $randNumber; ?>').val()!='' && $('.lon_<?php echo $randNumber; ?>').val()!=''){
		var lokasi = new google.maps.LatLng(
			$('.lat_<?php echo $randNumber; ?>').val(), 
			$('.lon_<?php echo $randNumber; ?>').val());
		map.panTo(lokasi);
		marker.setPosition(lokasi);
	}else{
		$('.lat_<?php echo $randNumber; ?>').val(-6.202087);
		$('.lon_<?php echo $randNumber; ?>').val(106.846381);
		onChange();
	}
	
	$("#searchbutton").click(function(){
		geocodeFunct($("#searchtext").val());
		return false;
	});
});

function onChange() {
	var lokasi = map.getCenter();
	marker.setPosition(lokasi);
	$('.lat_<?php echo $randNumber; ?>').val(lokasi.lat().toFixed(5));
	$('.lon_<?php echo $randNumber; ?>').val(lokasi.lng().toFixed(5));
}

function geocodeFunct(name){
	geocoder.geocode( { 'address': name}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			marker.setPosition(results[0].geometry.location);
		}
		else
		{
			alert("ALAMAT TIDAK DITEMUKAN ! \nError code : " + status);
		}
	}); 
}