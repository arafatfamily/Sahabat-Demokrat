<?php
/* @var $this LokasiController */
/* @var $model Lokasi */

$this->breadcrumbs=array(
	'Lokasis'=>array('index'),
	$model->member_id,
);

$this->menu=array(
	array('label'=>'List Lokasi', 'url'=>array('index')),
	array('label'=>'Create Lokasi', 'url'=>array('create')),
	array('label'=>'Update Lokasi', 'url'=>array('update', 'id'=>$model->member_id)),
	array('label'=>'Delete Lokasi', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->member_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lokasi', 'url'=>array('admin')),
);
?>

<h1>View Lokasi #<?php echo $model->member_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'member_id',
		'mobile_lat',
		'mobile_lon',
		'address_lat',
		'address_lon',
	),
)); ?>
