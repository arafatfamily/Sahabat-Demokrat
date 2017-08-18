<?php
/* @var $this GaleriController */
/* @var $model SiteGalery */

$this->breadcrumbs=array(
	'Site Galeries'=>array('index'),
	$model->galeri_id,
);

$this->menu=array(
	array('label'=>'List SiteGalery', 'url'=>array('index')),
	array('label'=>'Create SiteGalery', 'url'=>array('create')),
	array('label'=>'Update SiteGalery', 'url'=>array('update', 'id'=>$model->galeri_id)),
	array('label'=>'Delete SiteGalery', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->galeri_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SiteGalery', 'url'=>array('admin')),
);
?>

<h1>View SiteGalery #<?php echo $model->galeri_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'galeri_id',
		'admin',
		'album',
		'images',
		'nama',
		'keterangan',
		'tgl_upload',
	),
)); ?>
