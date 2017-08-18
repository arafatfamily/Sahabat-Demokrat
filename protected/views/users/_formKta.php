<style>
.croppedImg {
	width:inherit;
	height:inherit;
}
.cropContainerModal img {
	width:inherit;
	height:inherit;
}
</style>
<div class="panel-group primary" id="accordion-dpn" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion-dpn" href="#collapseOne-dpn" aria-expanded="false" aria-controls="collapseOne-dpn">
					<i class='fa fa-credit-card'></i> Template Kartu Tanda Anggota Depan
				</a>
			</h4>
		</div>
		<div id="collapseOne-dpn" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body" style="padding-left: 3px;">
				<div class="col-lg-12">
					<div id="cropKTAdpn" class="cropContainerModal" style="width:420px;height:268px;background-color:rgba(162, 162, 162, 0.32);position: relative;">
						<?php
						if ($model->users_id != "") {
							echo CHtml::image(Yii::app()->controller->createUrl('users/loadKtadpn', array('id' => $model->users_id), array('class' => 'img-thumbnail')));
						}
						?>  
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingTwo">
			<h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion-blk" href="#collapseTwo-blk" aria-expanded="false" aria-controls="collapseTwo-blk">
					<i class='fa fa-credit-card'></i> Template Kartu Tanda Anggota Belakang
				</a>
			</h4>
		</div>
		<div id="collapseTwo-blk" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body" style="padding-left: 3px;">
				<div class="col-lg-12">
					<div id="cropKTAblk" class="cropContainerModal" style="width:420px;height:268px;background-color:rgba(162, 162, 162, 0.32);position: relative;">
						<?php
						if ($model->users_id != "") {
							echo CHtml::image(Yii::app()->controller->createUrl('users/loadKtablk', array('id' => $model->users_id), array('class' => 'img-thumbnail')));
						}
						?>  
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo CHtml::hiddenField('KtaDPN'); ?>                           
<?php echo CHtml::hiddenField('KtaBLK'); ?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.css" rel="stylesheet">
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/croppic.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.mousewheel.min.js"></script>  
<script type="text/javascript">
var OptionsCropKTADPN = {
	uploadUrl: '<?php echo CController::createUrl('users/uploadimage') ?>',
	cropUrl: '<?php echo CController::createUrl('users/cropTemplate') ?>',
	modal: true,
	enableMousescroll: true,
	loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onBeforeImgUpload: function () {
		console.log('onBeforeImgUpload')
	},
	onAfterImgUpload: function () {
		console.log('onAfterImgUpload')
	},
	onImgDrag: function () {
		console.log('onImgDrag')
	},
	onImgZoom: function () {
		console.log('onImgZoom')
	},
	onBeforeImgCrop: function () {
		console.log('onBeforeImgCrop')
	},
	onAfterImgCrop: function (e) {
		changeKTADPN(e.url);
	},
	onReset: function () {
		console.log('onReset')
	},
	onError: function (errormessage) {
		console.log('onError:' + errormessage)
	},
}
var cropKTAdpn = new Croppic('cropKTAdpn', OptionsCropKTADPN);
function changeKTADPN(f) { $('#KtaDPN').val(f); }

var OptionsCropKTABLK = {
	uploadUrl: '<?php echo CController::createUrl('users/uploadimage') ?>',
	cropUrl: '<?php echo CController::createUrl('users/cropTemplate') ?>',
	modal: true,
	enableMousescroll: true,
	loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
	onBeforeImgUpload: function () {
		console.log('onBeforeImgUpload')
	},
	onAfterImgUpload: function () {
		console.log('onAfterImgUpload')
	},
	onImgDrag: function () {
		console.log('onImgDrag')
	},
	onImgZoom: function () {
		console.log('onImgZoom')
	},
	onBeforeImgCrop: function () {
		console.log('onBeforeImgCrop')
	},
	onAfterImgCrop: function (e) {
		changeKTABLK(e.url);
	},
	onReset: function () {
		console.log('onReset')
	},
	onError: function (errormessage) {
		console.log('onError:' + errormessage)
	},
}
var cropKTAblk = new Croppic('cropKTAblk', OptionsCropKTABLK);
function changeKTABLK(f) { $('#KtaBLK').val(f); }
</script>