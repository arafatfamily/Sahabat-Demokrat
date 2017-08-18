<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'config-grid',
	'template' => '{items}',
	'enableSorting' => false,
	'itemsCssClass' => 'table table-striped',
	'dataProvider' => $settings->search(),
	'ajaxUrl' => $this->createUrl('frontend/'.$this->action->id),
	'columns' => array(
		array(
			'header' => 'KONFIGURASI TEMA',
			'name' => 'params',
			'type' => 'raw',
			'headerHtmlOptions' => array('class' => 'col-xs-4'),
			'htmlOptions' => array('style' => 'vertical-align: middle;'),
			'value' => function($data) {
				return '<b>' . $data['params'] . '.</b>';
			},
		),
		array(
			'header' => 'OPSI',
			'name' => 'options',
			'type' => 'raw',
			'headerHtmlOptions' => array('class' => 'col-xs-2', 'style'=>'text-align: center;'),
			'value' => function($data) {
				return CHtml::dropDownList('options', $data['options'], array('TRUE'=>'TAMPILKAN', 'FALSE'=>'SEMBUNYIKAN'), array('class'=>'form-control input-sm m-bot15'));
			},
		),
		array(
			'header' => 'WARNA',
			'name' => 'bg_color',
			'type' => 'raw',
			'headerHtmlOptions' => array('class' => 'col-xs-2', 'style'=>'text-align: center;'),
			'htmlOptions' => array('style' => 'text-align: center;'),
			'value' => function($data) {
				return CHtml::colorField('bg_color', $data['bg_color'], array('style'=>'border: 0px'));
			},
		),
		array(
			'header' => 'KONTEN',
			'name' => 'konten',
			'type' => 'raw',
			'headerHtmlOptions' => array('class' => 'col-xs-4', 'style'=>'text-align: center;'),
			'value' => function($data) {
				return CHtml::dropDownList('konten', $data['konten'], array(''=>'TIDAK ADA DATA KONTEN'), array('class'=>'form-control input-sm m-bot15'));
			},
		),
	),
)); ?>