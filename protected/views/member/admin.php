<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs=array(
	'Members'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Member', 'url'=>array('index')),
	array('label'=>'Create Member', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#member-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Members</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'member-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'membership_id',
		'member_name',
		'gender',
		'birth_place',
		'date_of_birth',
		/*
		'is_married',
		'blood_type',
		'occupation',
		'religion',
		'last_education_id',
		'sub_district_id',
		'address',
		'home_number',
		'rt',
		'rw',
		'postal_code',
		'member_sub_district_id',
		'member_address',
		'member_home_number',
		'member_rt',
		'member_rw',
		'member_postal_code',
		'couple_name',
		'children_name',
		'home_phone_number',
		'cellular_phone_number',
		'email',
		'facebook',
		'twitter',
		'member_type_id',
		'member_status',
		'member_active_number',
		'registered_time',
		'identity_number',
		'CARD_UID',
		'last_print',
		'total_print',
		'is_domisili',
		'is_other_position',
		'reference',
		'mobile_auth',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
