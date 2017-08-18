<link href="<?php echo Yii::app()->theme->baseUrl ?>/css+js/bootstrap-editable.css" rel="stylesheet" type="text/css" media="screen"/>
<script src="//select2.github.io/select2/select2-3.4.1/select2.js"></script>
<link rel="stylesheet" type="text/css" href="//select2.github.io/select2/select2-3.4.1/select2.css"/>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left bold">
				<i class="fa fa-sitemap icon-md icon-primary"></i> STRUKTUR ORGANISASI PARTAI DEMOKRAT
			</h2>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form col-md-12 col-sm-12 col-xs-12 text-uppercase bold">
				<?php $admin = Users::model()->findByPk(Yii::app()->user->id);
				$form = $this->beginWidget('CActiveForm', array(
					'action' => Yii::app()->createUrl($this->route),
					'method' => 'get',
					'id' => 'filter-form',
				));
				echo '<i class="fa fa-bank icon-xs icon-primary">&nbsp;</i>';
				echo '<span class="text-danger">&nbsp; DIVISI & DEPARTEMEN : </span>';
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';
				echo CHtml::link('BADAN PEMBINAAN ORGANISASI, KEANGGOTAAN DAN KADERISASI',array('#divisi_dept'),array('data-type'=>'select2','id'=>'divisi_dept'));				
				echo '<div class="clearfix"></div>';
				echo '&nbsp;<i class="fa fa-building icon-xs icon-primary">&nbsp;</i>';
				echo '<span class="text-danger">&nbsp; DEWAN PIMPINAN : </span>';
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';		
				echo CHtml::link('DEWAN PIMPINAN PUSAT',array('#level'),array('data-type'=>'select2','id'=>'level'));
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';		
				echo CHtml::link('DKI JAKARTA',array('#provinsi'),array('data-type'=>'select2','id'=>'dpd'));
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';		
				echo CHtml::link('JAKARTA BARAT',array('#kabupaten'),array('data-type'=>'select2','id'=>'dpc'));
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';
				echo CHtml::link('JATIPULO',array('#kecamatan'),array('data-type'=>'select2','id'=>'pac'));
				echo '&nbsp;<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>';
				echo CHtml::link('PALMERAH',array('#kelurahan'),array('data-type'=>'select2','id'=>'ranting'));
				$this->endWidget(); ?>
			</div><div class="clearfix"></div></br>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<ul class="nav nav-tabs nav-justified primary">
					<li class="active">
						<a href="#_list" data-toggle="tab">
							<i class="fa fa-list-alt"></i> DAFTAR DEWAN PIMPINAN
						</a>
					</li>
					<li>
						<a href="#_bagan" data-toggle="tab">
							<i class="fa fa-sitemap"></i> BAGAN STRUKTUR ORGANISASI
						</a>
					</li>
					<li>
						<a href="#_manage" data-toggle="tab">
							<i class="fa fa-gear"></i> PENGATURAN STRUKTUR ORGANISASI
						</a>
					</li>
				</ul>
				<div class="tab-content primary">
					<div class="tab-pane fade in active" id="_list">
						<div class="col-md-12">
						<!--?php $this->renderPartial('_StrukturList', array('dataProvider'=>$dataProvider)); ?-->
						</div><div class="clearfix"></div>
					</div>
					<div class="tab-pane fade" id="_bagan">
						<div class="col-md-12">
						<!--?php $this->renderPartial('_StrukturBagan', array('model'=>$model)); ?-->
						</div><div class="clearfix"></br></div>
					</div>
					<div class="tab-pane fade" id="_bagan">
						<div class="col-md-12">
						<!--?php $this->renderPartial('_StrukturBagan', array('model'=>$model)); ?-->
						</div><div class="clearfix"></br></div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</section>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap-editable.min.js" type="text/javascript"></script>
<script type="text/javascript">
 $('#divisi_dept').editable({});
 $('#level').editable({});
 $('#dpd').editable({});
 $('#dpc').editable({});
 $('#pac').editable({});
 $('#ranting').editable({});
 
 /*
$('#pos_level').editable({
	select2: {
		placeholder: 'Klik untuk Merubah!',
		allowClear: true,
		minimumInputLength: 1,
		id: function (item) {
			return item.id;
		},
		ajax: {
			url: '<?php echo CController::createUrl('#member/loadAdmin') ?>',
			dataType: 'json',
			data: data(term, page),
			results: results(data, page)
		},
		initSelection: function (element, callback) {
			return $.get('<?php echo CController::createUrl('site/loadJsonMulti') ?>', {
				q: element.val(),
				lvl: null
			}, function (data) {
				callback(data);
			});
		},
		formatResult: formatResult(item),
		formatSelection: formatSelection(item)
	}  
});
function data(term, page) {
	return { query: term };
}
function results(data, page) {
	return { results: data };
}
function formatResult(item) {
	return item.text;
}
function formatSelection(item) {
	return item.CountryName;
}*/
</script>
