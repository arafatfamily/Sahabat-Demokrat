<?php Yii::app()->clientScript->registerScript('search', "
	$('#search-button').click(function(){
		$('#advance-filter').fadeToggle(750);
		return false;
	});
"); ?>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">DATA REKANAN (MERCHANT)</h2>
			<div class="actions panel_actions pull-right">
			<?php if (Yii::app()->user->isSuperadmin()) { 
				echo CHtml::link('<span class="fa fa-plus-square"></span>&nbsp;REGISTRASI MERCHANT&nbsp;',array('merchant/registrasi'), array('class'=>'btn btn-success')); } ?>
			</div>
		</header>
		<div class="content-body">
			<div class="row">
			<div class="search-form"><?php $this->renderPartial('_search',array('model'=>$model)); ?></div>				
			</div>
		</div>
	</section>
	<div class="table-responsive col-sm-12"><?php $this->renderPartial('_view',array('dataProvider'=>$dataProvider)); ?></div>
</div>
