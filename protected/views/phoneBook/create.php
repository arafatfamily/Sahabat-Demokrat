<?php
/* @var $this PhoneBookController */
/* @var $model PhBook */

$this->breadcrumbs=array(
	'Ph Books'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PhBook', 'url'=>array('index')),
	array('label'=>'Manage PhBook', 'url'=>array('admin')),
);
?>

<h1>Create PhBook</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>