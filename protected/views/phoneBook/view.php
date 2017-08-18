<?php
/* @var $this PhoneBookController */
/* @var $model PhBook */

$this->breadcrumbs=array(
	'Ph Books'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List PhBook', 'url'=>array('index')),
	array('label'=>'Create PhBook', 'url'=>array('create')),
	array('label'=>'Update PhBook', 'url'=>array('update', 'id'=>$model->ph_id)),
	array('label'=>'Delete PhBook', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ph_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PhBook', 'url'=>array('admin')),
);
?>

<h1>View PhBook #<?php echo $model->ph_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ph_id',
		'member_id',
		'Name',
		'ph_number',
		'ph_grup',
		'other_number',
	),
)); ?>
