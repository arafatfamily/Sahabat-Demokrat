<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-manager-form',
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
		<?php echo $form->labelEx($model,'name');
			echo $form->textField($model,'name',array('class'=>'form-control', 'placeholder'=>'Nama Dokumen ...'));
			echo $form->error($model,'name');  ?>
		</div>
		<div class="col-sm-4">
		<?php echo $form->labelEx($model,'files');
			echo CHtml::fileField('dokumen','',array('class'=>'form-control'));
			echo $form->error($model,'files');  ?>
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
	</div><div class="clearfix"></div></br>
	<div class="form-group">
		<div class="box-footer">
			<?php echo CHtml::submitButton('T A M B A H',array('class'=>'btn btn-block btn-flat btn-success')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
</div>