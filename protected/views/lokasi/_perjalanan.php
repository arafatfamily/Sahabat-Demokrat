<div id="floating-track-info">
	<span id="info" class="badge badge-info bold text-uppercase"> INFORMASI RUTE </br>0 KM </br> 0 JAM </br> 0 WPTS</span>
</div>
<div id="map" style="height:500px"></div>
<div class="clearfix"></div></br>
<div class="row">
	<!--div class="col-md-4 col-sm-6 col-xs-12">
		<div class="r3_weather">
			<div class="wid-weather wid-weather-small">
				<div class="center" style="text-align: -webkit-center; padding: 1em;">
					<!?php echo CHtml::image(Yii::app()->controller->createUrl("member/loadPhoto", array("id" => 1)),"",array("class"=>"img-responsive img-thumbnail", "style"=>"padding: 1em;")); ?>
					<div class="clearfix"></div></br>
					<div class="weekdays bg-white">
					</div>
				</div>
			</div>
		</div>
	</div-->
	<div class="col-md-8 col-sm-6 col-xs-12">
		<table id="track_info" class="table table-small-font table-bordered table-striped nowrap"/>
	</div>
</div>
<script type="text/javascript">
var routeMarkers = [], routeLines = [], routeKM = 0, member_id;
directionsService = new google.maps.DirectionsService(), routeTime = 0,
map = new google.maps.Map(document.getElementById('map'), {
	zoom: 5,
	center: new google.maps.LatLng(-2.4538264, 118.0723276),
	mapTypeId: google.maps.MapTypeId.ROADMAP
}), service = new google.maps.places.PlacesService(map);
function checkAirPort(arrLatLng, i) {
	if (i < arrLatLng.length) {
		var coordinates = new google.maps.LatLng(arrLatLng[i].track_lat,arrLatLng[i].track_lon);
		service.nearbySearch({
			location: coordinates,
			radius: '350',
			type: ['airport']
		}, function(results, status) {
			if (i != (arrLatLng.length-1)) {
				const src = new LatLon(Dms.parseDMS(arrLatLng[i].track_lat), Dms.parseDMS(arrLatLng[i].track_lon));
				const dst = new LatLon(Dms.parseDMS(arrLatLng[i+1].track_lat), Dms.parseDMS(arrLatLng[i+1].track_lon));
				const jarak = parseFloat(src.distanceTo(dst).toPrecision(4));
				if (status == google.maps.places.PlacesServiceStatus.OK && jarak >= 50000) { // 500000 Meter
					placeMarker(coordinates);
					placeMarker(results[0].geometry.location);
					findDstAirPort(arrLatLng, i+1);
				} else {
					placeMarker(coordinates);
					setTimeout(function() {
						checkAirPort(arrLatLng, i+1); 
					}, 1000);
				}
			} else {
				placeMarker(coordinates);
				setTimeout(function() {
					checkAirPort(arrLatLng, i+1); 
				}, 1000);			
			}
		});
	}
}
function findDstAirPort(arrLatLng, i) {
	var destination = new google.maps.LatLng(arrLatLng[i].track_lat,arrLatLng[i].track_lon);
	service.nearbySearch({
		location: destination,
		radius: '50000',
		type: ['airport']
	}, function(results, status) {
		if (status == google.maps.places.PlacesServiceStatus.OK) {
			placeMarker(results[0].geometry.location);
			checkAirPort(arrLatLng, i+1);
		} else {
			console.log(google.maps.places.PlacesServiceStatus.OK);
		}
	});
}
function placeMarker(latlng, flightMode) {
	marker = new google.maps.Marker({
		position: latlng,
		icon: '<?php echo Yii::app()->controller->createUrl('backend/loadImgSite', array('param'=>'person_marker')) ?>',
		map: map,
		draggable: false
	})
	marker.uid = routeMarkers.length;
	routeMarkers.push(marker);
	if (routeMarkers.length > 1) {
		calcMemberRoute();
	}
}
function calcMemberRoute(index) {
	if(typeof(index) == 'undefined') {
		index = "new";
		var rStart = routeMarkers[routeMarkers.length - 2].getPosition();
		var rEnd   = routeMarkers[routeMarkers.length - 1].getPosition();
	} else {
		var rStart = routeMarkers[index - 1].getPosition();
		var rEnd   = routeMarkers[index - 0].getPosition();

	}

	directionsService.route({
		origin: rStart,
		destination: rEnd,
		travelMode: google.maps.DirectionsTravelMode.DRIVING
	}, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {			
			const src = new LatLon(Dms.parseDMS(rStart.lat()), Dms.parseDMS(rStart.lng()));
			const dst = new LatLon(Dms.parseDMS(rEnd.lat()), Dms.parseDMS(rEnd.lng()));
			const jarak = parseFloat(src.distanceTo(dst).toPrecision(4));
			var path = result.routes[0].overview_path;
			if (jarak >= 50000) {
				path = [rStart,rEnd];
			}
			var sumKM = 0;
			var sumTime = 0;
			var myroute = result.routes[0];
			for (var i = 0; i < myroute.legs.length; i++) {
				sumKM += myroute.legs[i].distance.value;
				sumTime += myroute.legs[i].duration.value;
			}
			sumKM = sumKM / 1000;
			writeRoute(path, sumKM, index, sumTime);
		} /*else if (status == google.maps.DirectionsStatus.ZERO_RESULTS) {
			alert("Could not find a route between these points");
		} else {
			console.log(status);
			alert("Directions request failed");
		}*/
	});
}
function writeRoute(path, routekm, index, routetime) {
	routeLine = new google.maps.Polyline({
		map: map,
		path: path,
		strokeColor: 'blue',
		strokeOpacity: 1.0,
		strokeWeight: 3,
		editable: false
	});
	routeLine.km = routekm;
	routeLine.uid = routeLines.length;
	routeLines.push(routeLine);
	routeKM += routekm;
	routeTime += routetime;
	document.getElementById('info').innerHTML = 'KALKULASI RUTE</br>' + routeKM + ' KM</br>' + routeTime.toHHMMSS() +  ' JAM</br>' + routeMarkers.length + ' WPTS';
}
function getMemberData(id, logTime) {
	if (id != '') {
		$.ajax({
			url: "<?php echo CController::createUrl('lokasi/loadMemberRute') ?>",
			dataType: 'json',
			type: 'POST',
			data: {
				id: id,
				dateLog: logTime
			},
			beforeSend: function() {
				if (member_id != id && member_id != 'undefined') {
					console.log('clearing data');
					for (var i in routeMarkers) {
					  routeMarkers[i].setMap(null);
					}					
					routeMarkers = [];
					for (var i in routeLines) {
					  routeLines[i].setMap(null);
					}
					routeLines = [];
					routeKM = 0;
				}
			},
			success: function(data) {
				if (data.wayPoint.length == 0) {
					alert('Kader Tidak Memiliki Track Record Perjalan !');
				} else if (data.wayPoint.length == 1) {
					placeMarker(new google.maps.LatLng(data.wayPoint[0].track_lat,data.wayPoint[0].track_lon));
				} else {
					checkAirPort(data.wayPoint, 0);
				}
				getMemberActivity(id, data.wayPoint);
			}
		});		
		member_id = id;
	}
}
$('#member_name').on('change', function () {
	getMemberData($('#member_name').val(), $('#log_time').val());
});
$('#log_time').on('change', function (data) {
	getMemberData($('#member_name').val(), $('#log_time').val());
});
function getMemberActivity(id, arrLatLng) {
	var json = [], images = '<?php echo CHtml::image(Yii::app()->controller->createUrl('backend/loadImgSite', array('param'=>'person_marker'))); ?>';
	for (var i = 0; i < arrLatLng.length; i++){
		json.push([
			i+1,
			arrLatLng[i].track_lat,
			arrLatLng[i].track_lon,
			arrLatLng[i].time,
			'-',
			'<a href="http://maps.google.com/maps?q=' + arrLatLng[i].track_lat + ',' + arrLatLng[i].track_lon + '" target="_blank">' + images + ' G-Map</a>'
		]);
	}
	var Table = $('#track_info').DataTable({
		"paging": false,
		"ordering": false,
		"info": false,
		"searching": false,
		//"scrollX": true,
		"destroy": true,
		"ScrollY": true,
		"language": {
			"search": "Cari:",
			"emptyTable": "Tidak ada data !",
		},
		"data": eval(JSON.stringify(json)),
		"columns": [
			{"title": "#"},
			{"title": "Latitude"},
			{"title": "Longitude"},
			{"title": "Tanggal / Jam"},
			{"title": "Keterangan"},
			{"title": "Ext. Map"}
		]
	});
}
Number.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}
</script>