<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">REGISTRASI REKANAN (MERCHANT)<span class="badge badge-danger"> (*) Isian wajib di isi ! </span></h2>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form"><?php $this->renderPartial('_form',array('model'=>$model)); ?></div>				
			</div>
		</div>
	</section>
</div>
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w" type="text/javascript"></script>
<script type="text/javascript">
var featherEditor = new Aviary.Feather({
	apiKey: '1d756282daca4b2aadf0a95375daf7b2',
	tools: [
		'enhance',
		'orientation',
		'warmth',
		'crop',
		'brightness',
		'contrast',
		'saturation',
		'sharpness',
		'whiten'
	],
	initTool:'crop',
	language: 'id',
	enableCORS: true,
	noCloseButton: true,
	displayImageSize: true
});
$.ajax({
	url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
	type: 'POST',
	data: {},
	success: function (data) {
		$('#provinsi').html(data);
		$("#provinsi").select2().select2('val', '');
		loadKabupaten();
	},
	error: function (jqXHR, status, err) {
		alert(err);
	}
});
function imgEditor(id, src) {
	if (!src) {
		$("#file-"+id).trigger('click');
	} else {
		var el=document.getElementById(id);
		featherEditor.launch({
			image: id,
			url: src,
			cropPresets: [
				[id, el.offsetWidth+':'+el.offsetHeight]
			],
			onSave: function(imageID, newURL) {				
				var img = document.getElementById(imageID);
				img.src = newURL;
				$('#post'+imageID).val(newURL);
				featherEditor.close();
			}
		});
		return false;
	}
}
function readImage(input) {
	if (input.files && input.files[0]) {
        var fr = new FileReader();
        fr.onload = function (e) {
            $('#'+input.id.split("-")[1]).attr('src', e.target.result);
			imgEditor(input.id.split("-")[1], e.target.result);
        }
        fr.readAsDataURL(input.files[0]);
    }
}
function loadKabupaten() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#provinsi').val()},
		success: function (data) {
			$("#kabupaten").html(data);
			$("#kabupaten").select2().select2('val', '');
			loadKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#kabupaten').val()},
		success: function (data) {
			$('#kecamatan').html(data);
			$("#kecamatan").select2().select2('val', '');
			loadKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatan').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'subdistrict') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'subdistrict') ?>').select2().select2('val', '');
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
</script>