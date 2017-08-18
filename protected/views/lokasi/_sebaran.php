<script src="https://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<div id="map" style="height:500px"></div>
<div class="clearfix"></div>
<script type="text/javascript">
//$(.sidebar-toggle-wrap).('click',TampilMap());TampilMap();
//function TampilMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		zoom:5,
		center: new google.maps.LatLng(-2.4538264, 118.0723276),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	//LoadOffice();
	infowindow = new google.maps.InfoWindow();
	var json_data = {};
	json_data.limit = 'NOPE';
	$.ajax({
		url: "<?php echo CController::createUrl('lokasi/loadMemberAddress') ?>",
		dataType: 'json',
		mode: 'queue',
		type: 'POST',
		data: {},
		success: function (data) {
			if (!$.isEmptyObject(data)) {
				var marker, i;
				for (i = 0; i < data.length; i++) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(data[i].latitude, data[i].longitude),
						map: map,
						icon: '<?php echo Yii::app()->controller->createUrl('backend/loadImgSite', array('param'=>'person_marker')) ?>'
					});
					google.maps.event.addListener(marker, 'click', (function (marker, i) {
						return function () {
							 var str = "";
							 for (j = 0; j < data.length; j++) {
							 if (data[j].latitude == data[i].latitude && data[j].longitude == data[i].longitude){
									str += "<a href='#' data-popbox='pop1' onmouseover='showDialog(" + data[j].membership_id + ")' class='popper' style='font-weight:bold;color: #0D47A1; font-size: 14px;'>" + data[j].member_name.toUpperCase() + "</a><br/>";
								}
								
							 }
							infowindow.setContent("<center>"+str+"</center>");
							infowindow.open(map, marker);
						}
					})(marker, i));
				}

			}
		}
	});
//}
function showDialog(id){
	var moveLeft = 0;
	var moveDown = 0;
	var content = "<img src='http://sahabat.demokratbpokk.org/upload/images/kta/" + id + "_front.png' width='508px' height='324px'>";
	$('a.popper').hover(function (e) {
		$( "div#pop1" ).html(content);
		console.log(e);
		var target = '#' + ($(this).attr('data-popbox'));
		$(target).show();
		moveLeft = $(this).outerWidth();
		moveDown = ($(target).outerHeight() / 2);
	}, function () {
		var target = '#' + ($(this).attr('data-popbox'));
		if (!($("a.popper").hasClass("show"))) {
			$(target).hide();
		}
	});

	$('a.popper').mousemove(function (e) {
		console.log(e);
		var target = '#' + ($(this).attr('data-popbox'));
		leftD = e.pageX + parseInt(moveLeft);
		maxRight = leftD + $(target).outerWidth();
		windowLeft = $(window).width() - 40;
		windowRight = 0;
		maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 20);

		if (maxRight > windowLeft && maxLeft > windowRight) {
			leftD = maxLeft;
		}
		topD = e.pageY - parseInt(moveDown);
		maxBottom = parseInt(e.pageY + parseInt(moveDown) + 20);
		windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
		maxTop = topD;
		windowTop = parseInt($(document).scrollTop());
		if (maxBottom > windowBottom) {
			topD = windowBottom - $(target).outerHeight() - 20;
		} else if (maxTop < windowTop) {
			topD = windowTop + 20;
		}

		$(target).css('top', topD).css('left', leftD);
	});
	$('a.popper').click(function (e) {
		console.log(e);
		var target = '#' + ($(this).attr('data-popbox'));
		if (!($(this).hasClass("show"))) {
			$(target).show();
		}
		$(this).toggleClass("show");
	});
}
function LoadOffice() {
	var json_data = {};
	json_data.limit = 'NOPE';
	$.ajax({
		url: "<?php echo CController::createUrl('lokasi/loadOffice') ?>",
		dataType: 'json',
		mode: 'queue',
		type: 'POST',
		data: {
			
		},
		success: function (data) {
			if (!$.isEmptyObject(data)) {
				var marker, i;
				for (i = 0; i < data.length; i++) {
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(data[i].latitude, data[i].longitude),
						map: map,
						icon: '<?php echo Yii::app()->controller->createUrl('backend/loadImgSite', array('param'=>'office_marker')) ?>'
					});

					google.maps.event.addListener(marker, 'click', (function (marker, i) {
						return function () {
							infowindow.setContent("<center><span class='bold' style='color: #0D47A1; font-size: 14px;'>" + data[i].membername.toUpperCase() + "</span><br/>"+data[i].address.toUpperCase()+"</center>");
							infowindow.open(map, marker);
						}
					})(marker, i));
				}
			}
		}
	});
}
</script>