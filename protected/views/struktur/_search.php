<!--?php Yii::app()->clientScript->registerScript('x-editable', "$('#level').editable({ source: ".CJSON::encode(Helpers::getStrukturData('lokasi'))." })"); ?-->
<div class="search-form col-md-12 col-sm-12 col-xs-12 text-uppercase bold">
	<?php $admin = Users::model()->findByPk(Yii::app()->user->id);
	$form = $this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'select-form',
	)); ?>
	<i class="fa fa-building icon-xs icon-primary">&nbsp;</i><span class="text-danger">DEWAN PIMPINAN : </span>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('DEWAN PIMPINAN PUSAT',array('#'),array('data-type'=>'select2','id'=>'level')); ?>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('DKI JAKARTA',array('#'),array('data-type'=>'select2','id'=>'dpd')); ?>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('JAKARTA BARAT',array('#'),array('data-type'=>'select2','id'=>'dpc')); ?>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('JATIPULO',array('#'),array('data-type'=>'select2','id'=>'pac')); ?>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('PALMERAH',array('#'),array('data-type'=>'select2','id'=>'ranting')); ?>
	<div class="clearfix"></div>
	<i class="fa fa-building-o icon-xs icon-primary">&nbsp;</i><span class="text-danger">DIVISI & DEPARTEMEN : </span>
	<i class="fa fa-arrow-circle-right icon-xs icon-primary">&nbsp;</i>
	<?php echo CHtml::link('BADAN PEMBINAAN ORGANISASI, KEANGGOTAAN DAN KADERISASI',array('#'),array('data-type'=>'select2','id'=>'divisi_dept'));
	$this->endWidget(); ?>
</div><div class="clearfix"></div></br>