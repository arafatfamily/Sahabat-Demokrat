<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'merchant-grid',
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
			'name' => 'nama',
			'type' => 'raw',
			'headerHtmlOptions' => array('style' => 'text-align: center;height: 2px'),
			'value' => function($data) {
				return $data->nama;
			}
		),
	)
));