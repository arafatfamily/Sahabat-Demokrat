<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.css" rel="stylesheet" type="text/css" media="screen"/>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8ugY5V2XYnbpCZBmcsDMETON4LpMp5w&libraries=places" type="text/javascript"></script>
<style type="text/css">
.popbox {
    display: none;
    position: absolute;
    z-index: 99999;
    width: 508px;
    padding: 0px;
    background: #EEEFEB;
    color: #000000;
    border: 1px solid #4D4F53;
    margin: 0px;
    -webkit-box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
    box-shadow: 0px 0px 5px 0px rgba(164, 164, 164, 1);
}
</style>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">TRACKING LOKASI KADER</h2>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form">
				<div class="col-lg-12"> 
					<label><?php echo "CARI KADER (PILIH KADER)" ?></label>
					<span id="advance" class="badge badge-info pull-right">PENCARIAN LANJUTAN</span>
					<div class="clearfix"></div>
					<div class="col-lg-6">
					<?php echo CHtml::textField('log_time','',array('class'=>'form-control', 'id'=>'log_time')); ?>
					</div>
					<div class="col-lg-6">
					<?php echo Select2::dropDownList('member_name', '', array(), array(
						'placeholder'=>'Silahkan Pilih Kader',
						'class' => 'form-control',
						'select2Options'=>array(
							'minimumInputLength'=>'3',
							'ajax'=>array(
								'url'=> Yii::app()->createUrl('lokasi/loadMember'),
								'type'=>'GET',
								'dataType'=>'json',
								'data'=>new CJavaScriptExpression('function (text, page, prov, kab, kec, kel) {
									return {
										q: text,
										page:page,
										prov: $("#provinsi").val(),
										kab: $("#kabupaten").val(),
										kec: $("#kecamatan").val(),
										kel: $("#kelurahan").val(),
									}
								}'),
								'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.kader};}'),						
							),
						)
					)); ?>
					</div>
				</div>
			</div><div class="clearfix"></div></br>
			<?php $this->renderPartial('_perjalanan',array('dataProvider'=>$dataProvider)); ?>			
			</div>
		</div>
	</section>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/date_moment.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/daterangepicker.js"></script>
<script defer src="http://cdn.rawgit.com/chrisveness/geodesy/v1.1.1/latlon-spherical.js"></script>
<script defer src="http://cdn.rawgit.com/chrisveness/geodesy/v1.1.1/dms.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
var currentdate = new Date();
$('#log_time').daterangepicker({
	timePicker: true,
	opens: 'right',
    drops: 'down',
    locale: {
      format: 'DD/MM/YYYY HH:mm'
    },
    startDate: currentdate.getDate(),
    endDate: currentdate.getDate()
});
</script>