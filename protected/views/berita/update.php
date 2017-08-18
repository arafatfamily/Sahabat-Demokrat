<?php
/* @var $this BeritaController */
/* @var $model SiteNews */

$this->breadcrumbs=array(
	'Site News'=>array('index'),
	$model->news_id=>array('view','id'=>$model->news_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SiteNews', 'url'=>array('index')),
	array('label'=>'Create SiteNews', 'url'=>array('create')),
	array('label'=>'View SiteNews', 'url'=>array('view', 'id'=>$model->news_id)),
	array('label'=>'Manage SiteNews', 'url'=>array('admin')),
);
?>

<h1>Update SiteNews <?php echo $model->news_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>