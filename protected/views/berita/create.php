<?php
/* @var $this BeritaController */
/* @var $model SiteNews */

$this->breadcrumbs=array(
	'Site News'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SiteNews', 'url'=>array('index')),
	array('label'=>'Manage SiteNews', 'url'=>array('admin')),
);
?>

<h1>Create SiteNews</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>