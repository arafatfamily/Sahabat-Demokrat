<style>
.croppedImg {
	width:inherit;
	height:inherit;
}
.cropContainerModal img {
	width:inherit;
	height:inherit;
}
</style>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/>
<header class="panel_header">
    <h2 class="title pull-left"> Pendafataran Acara
		<span class="badge badge-danger"> (*) Isian wajib di isi ! </span>
	</h2>
</header>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>