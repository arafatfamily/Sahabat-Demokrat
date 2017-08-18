<?php
/* @var $this StrukturController */
/* @var $model Struktur */

$this->breadcrumbs=array(
	'Strukturs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Struktur', 'url'=>array('index')),
	array('label'=>'Manage Struktur', 'url'=>array('admin')),
);
?>

<h1>Create Struktur</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>