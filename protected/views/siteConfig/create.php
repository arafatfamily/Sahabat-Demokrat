<?php
/* @var $this SiteConfigController */
/* @var $model ImgSite */

$this->breadcrumbs=array(
	'Img Sites'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImgSite', 'url'=>array('index')),
	array('label'=>'Manage ImgSite', 'url'=>array('admin')),
);
?>

<h1>Create ImgSite</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>