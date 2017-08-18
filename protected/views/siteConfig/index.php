<?php
/* @var $this SiteConfigController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Img Sites',
);

$this->menu=array(
	array('label'=>'Create ImgSite', 'url'=>array('create')),
	array('label'=>'Manage ImgSite', 'url'=>array('admin')),
);
?>

<h1>Img Sites</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
