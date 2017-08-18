<?php
/* @var $this BeritaController */
/* @var $model SiteNews */

$this->breadcrumbs=array(
	'Site News'=>array('index'),
	$model->news_id,
);

$this->menu=array(
	array('label'=>'List SiteNews', 'url'=>array('index')),
	array('label'=>'Create SiteNews', 'url'=>array('create')),
	array('label'=>'Update SiteNews', 'url'=>array('update', 'id'=>$model->news_id)),
	array('label'=>'Delete SiteNews', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->news_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SiteNews', 'url'=>array('admin')),
);
?>

<h1>View SiteNews #<?php echo $model->news_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'news_id',
		'admin',
		'judul',
		'isi_berita',
		'news_img',
		'sticky',
		'tgl_post',
	),
)); ?>
