<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" media="screen"/>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changelog-form',
	'method'=>'POST',
	'enableAjaxValidation'=>false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
));
echo $form->errorSummary($model); ?>
	<div class="form-group">
		<div class="col-sm-8">
		<?php echo $form->labelEx($model,'nama');
			echo $form->textField($model,'nama',array('class'=>'form-control', 'placeholder'=>'Tulis Judul Log ...'));
			echo $form->error($model,'nama');  ?>
		</div>
		<div class="col-sm-4">
		<?php echo $form->labelEx($model,'date');
			echo $form->textField($model,'date',array('class'=>'form-control', 'value'=>date("Y/m/d H:i:s"), 'disabled'=>true));
			echo $form->error($model,'nama');  ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
		<?php echo $form->labelEx($model,'keterangan');
			$this->widget('ext.useEditor.JqueryTE', array(
                'id'=>'contrl',
                'model'=>$model,
                'attribute'=>'keterangan',
                'value'=>$model->keterangan,
                'options'   => array(
                    'strike'=> false,
                    'sub'=>false,
                    'source'=>false,
                    'button'=>'SEND',
                    //'format'=>false,
                    'formats'=>'[["p","Paragraph"],["h1","My Head 1"]]',
                    'fsizes'=>'["10", "15", "20"]',   
                    'linktypes'=>'["Web URL", "E-mail", "Picture"]',
                ),
            ));
			echo $form->error($model,'keterangan');  ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
		<?php echo $form->labelEx($model,'icon_mark');
			echo Select2::activeDropDownList($model, 'icon_mark', array(), array(
				'placeholder'=>'Silahkan Pilih Icons',
				'class' => 'form-control',
				'select2Options'=>array(
					'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
					'minimumInputLength'=>'1',
					'ajax'=>array(
						'url'=> Yii::app()->createUrl('webmaster/glyphicon'),
						'type'=>'GET',
						'dataType'=>'json',
						'data'=>new CJavaScriptExpression('function (text, page) {return {q: text, page:page}}'),
						'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.glyphicon};}'),						
					),
					'formatResult'=> new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-" + state.id + "\'></span> " + state.text;
					}'),
					'formatSelection'=>new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-" + state.id + "\'></span> " + state.text;
					}'),
				)
			));
			echo $form->error($model,'icon_mark');  ?>
		</div>
		<div class="col-sm-4 text-center">
		<?php echo $form->labelEx($model,'posisi') . "</br>";
			echo $form->radioButtonList($model, 'posisi', array("L" => 'KIRI',"R" => 'KANAN'), array(
				'labelOptions' => array('class' => 'iradio-label form-label'),
				'class' => 'skin-square-purple', 'separator' => ' | ',));
			echo $form->error($model,'posisi');  ?>
		</div>
		<div class="col-sm-4">
		<?php echo $form->labelEx($model,'warna_icon'); ?>		
		<div class="input-group">
			<span class="input-group-addon">
				<i class="sel-color" style="background-color:#000000;"></i>
			</span>
		<?php echo $form->textField($model,'warna_icon',array('class'=>'form-control colorpicker', 'data-format'=>'hex', 'value'=>'#000000')); ?>
		</div>
		<?php echo $form->error($model,'warna_icon');  ?>
		</div>
	</div><div class="clearfix"></div></br>
	<div class="form-group">
		<div class="box-footer">
			<?php echo CHtml::submitButton('T A M B A H',array('class'=>'btn btn-block btn-flat btn-success')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	function val() {
		d = document.getElementById("<?php echo CHtml::activeId($model, 'icon_mark') ?>").value;
		alert(d);
	}
})
</script>