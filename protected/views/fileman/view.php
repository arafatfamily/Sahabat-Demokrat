<?php
/* @var $this FilemanController */
/* @var $model FileManager */

$this->breadcrumbs=array(
	'File Managers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List FileManager', 'url'=>array('index')),
	array('label'=>'Create FileManager', 'url'=>array('create')),
	array('label'=>'Update FileManager', 'url'=>array('update', 'id'=>$model->id_file)),
	array('label'=>'Delete FileManager', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_file),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FileManager', 'url'=>array('admin')),
);
?>

<h1>View FileManager #<?php echo $model->id_file; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_file',
		'name',
		'date_time',
		'owner',
		'files',
		'keterangan',
	),
)); ?>
