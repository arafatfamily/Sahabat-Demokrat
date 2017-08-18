<div class="alert alert-danger alert-dismissible fade in">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<strong>WARNING :</strong> Mohon isi semua kolom yang bertanda (*).
</div>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kritik-saran-form',
	'action'=>Yii::app()->createUrl('masukan/tambah'),
	'method'=>'POST',
	'enableAjaxValidation'=>false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>
	<div class="form-group">
		<div class="col-sm-4 text-center">
		<?php echo $form->labelEx($model,'tipe_pesan') . "</br>";
			echo $form->radioButtonList($model, 'tipe_pesan', array("S" => 'SARAN', "K" => 'KRITIK'), array(
				'labelOptions' => array('class' => 'iradio-label form-label'),
				'class' => 'skin-square-purple', 'separator' => ' '));
			echo $form->error($model,'tipe_pesan');  ?>
		</div>
		<div class="col-sm-4 text-center">
		<?php echo $form->labelEx($model,'tipe_app') . "</br>";
			echo $form->radioButtonList($model, 'tipe_app', array("W" => 'WEB APP',"R" => 'MOBILE APP'), array(
				'labelOptions' => array('class' => 'iradio-label form-label'),
				'class' => 'skin-square-purple', 'separator' => ' '));
			echo $form->error($model,'tipe_app');  ?>
		</div>
		<div class="col-sm-4">
		<?php echo $form->labelEx($model,'update_time');
			echo $form->textField($model,'update_time',array('class'=>'form-control', 'value'=>date("Y/m/d H:i:s"), 'disabled'=>true));
			echo $form->error($model,'update_time');  ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
		<?php echo $form->labelEx($model,'judul');
			echo $form->textField($model,'judul',array('class'=>'form-control', 'placeholder'=>'Tulis Judul Kritik/Saran ...'));
			echo $form->error($model,'judul');  ?>
		</div>
		<div class="col-sm-12">
		<?php echo $form->labelEx($model,'konten');
			$this->widget('ext.useEditor.JqueryTE', array(
                'id'=>'contrl',
                'model'=>$model,
                'attribute'=>'konten',
                'value'=>$model->konten,
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
			echo $form->error($model,'konten');  ?>
		</div>
	</div><div class="clearfix"></div></br>
	<div class="form-group">
		<div class="box-footer">
			<?php echo CHtml::submitButton('T A M B A H',array('class'=>'btn btn-block btn-flat btn-success')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>