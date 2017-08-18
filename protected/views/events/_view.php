<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/fullcalendar.min.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/fullcalendar.print.css" rel="stylesheet" media="print"/>
<div id="calender-event" class="col-md-9 col-sm-8 col-xs-8"></div>
<div class="col-md-3 col-sm-4 col-xs-4">
	<div class="btn-group btn-group-justified">
	<?php if (Yii::app()->user->getAkses('28', '4') || Yii::app()->user->isSuperadmin()) {
		echo CHtml::link('BUAT ACARA',array('events/manage'), array('class'=>'btn btn-success')); 
	} ?>
	</div><div class="clearfix"></div>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id' => 'event-grid',
		'dataProvider' => $dataProvider,
		'template' => '{items}{pager}',
		'pagerCssClass' => Yii::app()->theme->baseUrl."/css+js/style.css",
		'pager' => array(
			'prevPageLabel' => '<',
			'nextPageLabel' => '>',
			'firstPageLabel' => '<<',
			'lastPageLabel' => '>>',
			'header' => '',
			'selectedPageCssClass' => 'active',
			'maxButtonCount'=>1,
			'htmlOptions' => array(
				'class' => 'pagination pagination-sm pull-right',
			),
		),
		'columns' => array(
			array(
				'header' => 'DAFTAR ACARA',
				'name' => 'nama',
				'type' => 'raw',
				'headerHtmlOptions' => array('style' => 'text-align: left;height: 2px'),
				'value' => function($data){
					return '<b class="text-uppercase">'. CHtml::link($data['Nama'], array("view", "id" => $data->ev_id)) . '</b> ';
				}
			),
		)
	)); ?>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/fullcalendar_moment.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/lang-all.js" type="text/javascript"></script>
