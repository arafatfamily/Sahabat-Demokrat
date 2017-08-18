<?php
/* @var $this SiteConfigController */
/* @var $model ImgSite */

$this->breadcrumbs=array(
	'Img Sites'=>array('index'),
	$model->img_id,
);

$this->menu=array(
	array('label'=>'List ImgSite', 'url'=>array('index')),
	array('label'=>'Create ImgSite', 'url'=>array('create')),
	array('label'=>'Update ImgSite', 'url'=>array('update', 'id'=>$model->img_id)),
	array('label'=>'Delete ImgSite', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->img_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImgSite', 'url'=>array('admin')),
);
?>

<h1>View ImgSite #<?php echo $model->img_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'img_id',
		'params',
		'image',
		'img_type',
	),
)); ?>
