<?php

$baseUrl = 
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
		<div class="col-lg-2 pull-right">
		<?php  if (Yii::app()->user->getAkses("37", "1") || Yii::app()->user->isSuperadmin()) {
			echo CHtml::button('Tambah', array('onclick' => 'js:document.location.href="users/tambah"', 'class' => 'btn btn-success btn-md-2 btn-block'));
		} ?>
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
<div class="table-responsive col-lg-12">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'users-grid',
		//'template'=>'{items}{summary}{pager}',
		'template'=>'{items}{pager}',
        'itemsCssClass' => 'display table table-hover table-condensed dataTable no-footer',
        'dataProvider' => $dataProvider,
        'pager' => array(
            'header' => '',
            'cssFile' => false,
            'htmlOptions' => array(
                'class' => 'pager',
            ),
        ),
        'columns' => array(
            array(
                'header' => '',
                'name' => 'photo',
                'type' => 'html',
                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px;'),
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => 'CHtml::link(CHtml::image(Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $data->kader_id)),"",array("width"=>70,"height"=>80),"",array("class"=>"img-responsive img-circle")), array("profil","id"=>$data->users_id))',
				/*'$data->img_photo==""?CHtml::link(CHtml::image(Yii::app()->controller->createUrl("member/loadimagephoto", array("id" => $data->member_id)),"",array("width"=>70,"height"=>80)), array("update", "id"=>$data->id)):'
                . 'CHtml::link(CHtml::image(Yii::app()->controller->createUrl("users/loadimagephoto", array("id" => $data->id)),"",array("width"=>70,"height"=>80)), array("update", "id"=>$data->id))',*/
            ),
            array(
                'header' => '',
                'name' => 'username',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'value' => function($data) {
					return
					CHtml::link($data['username'], array("ubah", "id" => $data->users_id)) . " " .
                    ($data->status == "A" ? '<span STYLE="background-color: green;font-size:9px;color:#FFF;padding:3px;font-weight:bold;">ADMIN AKTIF</span>' : '<span STYLE="background-color: red;font-size:9px;color:#FFF;padding:3px;font-weight:bold;">TIDAK AKTIF</span>')
                    . "<br/>DPD " . $data->prov_nama . ", DPC " . $data->kab_nama . "";
				},
            ),
            array(
                'template' => '{update}',
                'class' => 'CButtonColumn',
                'htmlOptions' => array('width' => '35px', 'style' => 'text-align: center;'),
                'buttons' => array(
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("/users/ubah", array("id"=>$data["users_id"]))',
						'imageUrl' => Yii::app()->theme->baseUrl . '/images/Edit.png',
						'visible' => '(!Yii::app()->user->getAkses("35", "1") && !Yii::app()->user->isSuperadmin())?0:1',
                    ),
                ),
            ),			
            array(
                'template' => '{delete}',
                'class' => 'CButtonColumn',
                'htmlOptions' => array('width' => '35px', 'style' => 'text-align: center;'),
                'buttons' => array(
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("/users/hapus", array("id"=>$data["users_id"]))',
						'imageUrl' => Yii::app()->theme->baseUrl . '/images/delete.png',
						'visible' => '(!Yii::app()->user->getAkses("36", "1") && !Yii::app()->user->isSuperadmin())?0:1',
                    ),
                ),
            ),
        ),
    ));
    ?>
</div>
