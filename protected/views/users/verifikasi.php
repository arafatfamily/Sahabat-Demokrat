<?php
/* @var $this UsersController */

$this->breadcrumbs=array(
	'Users'=>array('/users'),
	'Admin',
);

$this->menu = array(
    array('label' => 'List Users', 'url' => array('index')),
    array('label' => 'Create Users', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="page-title">
        <div class="pull-left">
            <h1 class="title">
                Data User
            </h1>
        </div>
        <div class="pull-right hidden-xs">
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'homeLink' => CHtml::link('Dashboard'),
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php //echo CHtml::link('Pencarian', '#', array('class' => 'search-button')); ?>
<!--<div class="search-form" style="display:none">
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
</div> search-form -->
<div class="clearfix"></div>
<div class="col-lg-2 pull-right">
    <?php echo CHtml::button('Tambah', array('onclick' => 'js:document.location.href="create"', 'class' => 'btn btn-primary btn-block')); ?>
</div>
<div class="clearfix"></div>
<div class="table-responsive" style="">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'users-grid',
        'itemsCssClass' => 'table table-hover',
        'dataProvider' => $dataProvider,
        'pager' => array(
            'header' => '',
            'cssFile' => false,
            'htmlOptions' => array(
                'class' => 'pagination pagination-lg',
            ),
        ),
        'columns' => array(/*
            array(
                'header' => '',
                'name' => 'photo',
                'type' => 'html',
                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px;'),
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => '$data->photo==""?CHtml::link(CHtml::image(Yii::app()->controller->createUrl("member/loadimagephoto", array("id" => $data->member_id)),"",array("width"=>70,"height"=>80)), array("update", "id"=>$data->id)):'
                . 'CHtml::link(CHtml::image(Yii::app()->controller->createUrl("users/loadimagephoto", array("id" => $data->id)),"",array("width"=>70,"height"=>80)), array("update", "id"=>$data->id))',
            ),*/
            array(
                'header' => '',
                'name' => 'username',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'value' => function($data) {
					return
					CHtml::link($data['username'], array("update", "id" => $data->users_id)) . " " .
                    ($data->status == "A" ? '<span STYLE="background-color: green;font-size:11px;color:#FFF;padding:3px;font-weight:bold;">AKTIF</span>' : '<span STYLE="background-color: red;font-size:11px;color:#FFF;padding:3px;font-weight:bold;">NON AKTIF</span>')
                    . "<br/>DPD " . $data->prov_nama . ", DPC " . $data->kab_nama . "";
				},
            ),/*
            array(
                'template' => '{update}{delete}',
                'class' => 'CButtonColumn',
                'htmlOptions' => array('width' => 90, 'style' => 'text-align: center;'),
                'buttons' => array(
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("/users/update", array("id"=>$data["id"]))',
                        'visible' => '(!Yii::app()->user->getprivileges("edit", "1") && !Yii::app()->user->isSuperadmin())?0:1',
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("/users/delete", array("id"=>$data["id"]))',
                        'visible' => '(!Yii::app()->user->getprivileges ("del", "1") && !Yii::app()->user->isSuperadmin())?0:1',
                    ),
                ),
            ),*/
        ),
    ));
    ?>
</div>