<?php
/* @var $this PhoneBookController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ph Books',
);

$this->menu=array(
	array('label'=>'Create PhBook', 'url'=>array('create')),
	array('label'=>'Manage PhBook', 'url'=>array('admin')),
);
?>

<h1>Ph Books</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
