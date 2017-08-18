<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'SiteSlider-form',
	'enableAjaxValidation'=>false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); 
echo $form->errorSummary($slider); ?>
<div class="form-group">
	<div class="col-xs-6">
	<?php
	echo $form->labelEx($slider,'nama');
	echo $form->textField($slider,'nama',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Gambar ...'));
	?>
	</div>
	<div class="col-xs-3">
	<?php
	echo $form->labelEx($slider,'nomor');
	echo $form->textField($slider,'nomor',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Gambar ...'));
	?>
	</div>
	<div class="col-xs-3">
	<?php
	echo $form->labelEx($slider,'status') . "</br>";
	echo $form->radioButtonList($slider, 'status', array("P" => 'TERBIT',"D" => 'DRAFT'), array(
				'labelOptions' => array('class' => 'icheck-label form-label'),
				'separator' => ' ',));
	?>
	</div>
	<div class="col-xs-12">
	<?php
	echo $form->labelEx($slider,'heading');
	echo $form->textField($slider,'heading',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Gambar ...'));
	?>
	</div>
	<div class="col-xs-12">
	<?php
	echo $form->labelEx($slider,'paragraph');
	echo $form->textField($slider,'paragraph',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Gambar ...'));
	?>
	</div>
	<div class="col-xs-12">
	<?php
	echo $form->labelEx($slider,'images');
	echo CHtml::fileField('image_file');
	?>
	</div>
</div><div class="clearfix"></div></br>
<div class="col-xs-8 pull-right">
	<?php echo CHtml::submitButton($slider->isNewRecord ? 'TAMBAH' : 'SIMPAN',array('class'=>'btn btn-block btn-flat btn-success')); ?>
</div><div class="clearfix"></div>
<?php $this->endWidget(); ?>