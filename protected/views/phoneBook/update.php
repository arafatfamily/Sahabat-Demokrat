<?php
/* @var $this PhoneBookController */
/* @var $model PhBook */

$this->breadcrumbs=array(
	'Ph Books'=>array('index'),
	$model->Name=>array('view','id'=>$model->ph_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PhBook', 'url'=>array('index')),
	array('label'=>'Create PhBook', 'url'=>array('create')),
	array('label'=>'View PhBook', 'url'=>array('view', 'id'=>$model->ph_id)),
	array('label'=>'Manage PhBook', 'url'=>array('admin')),
);
?>

<h1>Update PhBook <?php echo $model->ph_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>