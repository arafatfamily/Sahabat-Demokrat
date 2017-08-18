<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'member-grid',
	'template' => '{summary}{items}{pager}',
	'hideHeader'=> true,
	'itemsCssClass' => 'table table-hover',
	'pagerCssClass' => 'dataTables_paginate paging_bootstrap pull-right',
	'dataProvider' => $dataProvider,
	'pager' => array(
		'cssFile'=>Yii::app()->theme->baseUrl."/css+js/style.css",
		'prevPageLabel' => '<<',
		'nextPageLabel' => '>>',
		'header' => '',
        'selectedPageCssClass' => 'active',
		'maxButtonCount'=>10,
		'htmlOptions' => array(
			'class' => 'pagination',
		),
	),
	'columns' => array(
		array(
			'header' => '',
			'name' => 'photo',
			'type' => 'html',
			'headerHtmlOptions' => array('style' => 'text-align: center;width: 90px;height: 2px;'),
			'htmlOptions' => array('style' => 'text-align: center;width: 90px;'),
			'value' => 'MemberPhoto::model()->findByPk($data->id) == NULL ? CHtml::link(CHtml::image(Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "default_profile_".$data->gender)),"",array("class"=>"img-responsive img-circle")), array("view", "id" => $data->id)) :' . 'CHtml::link(CHtml::image(Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $data->id)),"",array("class"=>"img-responsive img-circle")), array("view", "id" => $data->id))',
		),
		array(
			'header' => '',
			'name' => 'membership_id',
			'type' => 'raw',
			'headerHtmlOptions' => array('style' => 'text-align: center;height: 2px'),
			'value' => function($data) {
		return '<b class="text-uppercase">'. CHtml::link($data['member_name'], array("view", "id" => $data->id)) . '</b> ' . ($data->last_print != NULL ? '<span class="badge" STYLE="background-color: green;font-size: 11px;color: #FFF;padding: 3px;font-weight bold;">&nbsp;<i class="fa fa-print"> SUDAH DICETAK</i>&nbsp;</span>' : '<span class="badge" STYLE="background-color: red;font-size:11px;color:#FFF;padding:3px;font-weight:bold;">&nbsp;<i class="fa fa-times-circle-o"> BELUM DICETAK</i>&nbsp;</span>') . "<br/>DPD " . Member::getKabProvKec($data['member_sub_district_id'], "nama_prov") . ", DPC " . Member::getKabProvKec($data['member_sub_district_id'], "nama_kab") . "<br/>No. Seluler : " . $data['cellular_phone_number'] . "&nbsp;<span class='badge badge-info'>" . ($data->member_active_number != NULL ? "<i class='fa fa-mobile'></i>" : "") . "</span><br/><span class='badge badge-orange'>Referensi : <b>" . Globals::findByRef("member","member_name","membership_id='".$data['reference']."'") . "</b></span>"; },
		),
		array(
			'header' => '',
			'name' => 'last_print',
			'type' => 'raw',
			'headerHtmlOptions' => array('style' => 'text-align: center;height: 2px'),
			'value' => function($data) {
				return (strpos(end(explode('/', Yii::app()->request->url)), "verifikasi") === 0 ? ('<b>TANGGAL DAFTAR ONLINE</b><h3>' . Globals::dateIndonesia($data['registered_time']) . '</h3><b class="badge badge-purple">Status Penerimaan : Tertunda</b>') : ($data['last_print'] == NULL ? '' : '<b>TANGGAL TERAKHIR CETAK</b><h3>' . Globals::dateIndonesia($data['last_print']) . '</h3><b class="badge badge-purple">Total KTA Tercetak : ' . Globals::Jumlah('LogPrint','status','PRINT KTA',$data->id) . ' Pcs</b>')); },
		),
		array(
			'template' => strpos(end(explode('/', Yii::app()->request->url)), "verifikasi") === 0 ? '{accept}{reject}' : '{update}{delete}',
			'class' => 'CButtonColumn',
			'htmlOptions' => array('width' => 90, 'style' => 'text-align: right;height: 2px'),
			'buttons' => array(
				'update' => array(
					'url' => 'Yii::app()->createUrl("member/ubah", array("id"=>$data["id"]))',
					'imageUrl' => Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "admin_edit")),
					'visible' => '(!Yii::app()->user->getAkses("3", "2") && !Yii::app()->user->isSuperadmin())?0:1',
				),
				'delete' => array(
					'url' => 'Yii::app()->createUrl("member/hapus", array("id"=>$data["id"]))',
					'imageUrl' => Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "admin_hapus")),
					'visible' => '(!Yii::app()->user->getAkses("4", "2") && !Yii::app()->user->isSuperadmin())?0:1',
				),
				'accept' => array(
					'url' => 'Yii::app()->createUrl("member/terima", array("id"=>$data["id"]))',
					'imageUrl' => Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "adm_terima")),
					'visible' => '(!Yii::app()->user->getAkses("39", "13") && !Yii::app()->user->isSuperadmin())?0:1',
					'click'=>"function(){ $.fn.yiiGridView.update('member-grid', { type:'POST', url:$(this).attr('href'), success:function(data) { $.fn.yiiGridView.update('member-grid'); } }); return false; }",
				),
				'reject' => array(
					'url' => 'Yii::app()->createUrl("member/tolak", array("id"=>$data["id"]))',
					'imageUrl' => Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "adm_tolak")),
					'visible' => '(!Yii::app()->user->getAkses("47", "2") && !Yii::app()->user->isSuperadmin())?0:1',
					'click'=>"function(){ $.fn.yiiGridView.update('member-grid', { type:'POST', url:$(this).attr('href'), success:function(data) { $.fn.yiiGridView.update('member-grid'); } }); return false; }",
				),
			),
		),
	),
)); ?>