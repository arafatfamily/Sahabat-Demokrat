<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Tambah',
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Tambah Admin</h2>
			<div class="actions panel_actions pull-right">
				<!--i class="box_toggle fa fa-chevron-down"></i-->
			</div>
		</header>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>