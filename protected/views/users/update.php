<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->users_id=>array('view','id'=>$model->users_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'View Users', 'url'=>array('view', 'id'=>$model->users_id)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Ubah Admin</h2>
			<div class="actions panel_actions pull-right">
				<i class="box_toggle fa fa-chevron-down"></i>
			</div>
		</header>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>