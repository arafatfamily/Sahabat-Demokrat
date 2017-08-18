<?php
/* @var $this SiteConfigController */
/* @var $model ImgSite */

$this->breadcrumbs=array(
	'Img Sites'=>array('index'),
	$model->img_id=>array('view','id'=>$model->img_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImgSite', 'url'=>array('index')),
	array('label'=>'Create ImgSite', 'url'=>array('create')),
	array('label'=>'View ImgSite', 'url'=>array('view', 'id'=>$model->img_id)),
	array('label'=>'Manage ImgSite', 'url'=>array('admin')),
);
?>

<h1>Update ImgSite <?php echo $model->img_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>