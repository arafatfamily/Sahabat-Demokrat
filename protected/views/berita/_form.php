<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'berita-form',
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
	<div class="box-body">
		<div class="col-sm-4">
		<?php
			echo $form->labelEx($model,'kategori');
			echo $form->textField($model,'kategori',array('class'=>'form-control', 'placeholder'=>'Tulis kategori Berita ...'));
			echo $form->error($model,'kategori'); 
		?>
		</div>
		<div class="col-sm-8">
		<?php
			echo $form->labelEx($model,'judul');
			echo $form->textField($model,'judul',array('class'=>'form-control', 'placeholder'=>'Tulis Judul Berita ...'));
			echo $form->error($model,'judul'); 
		?>
		</div>
		<div class="col-sm-12">	
		<?php echo $form->labelEx($model,'isi_berita'); ?>
		<?php echo $form->textArea($model,'isi_berita',array('class'=>'form-control', 'rows'=>6, 'placeholder'=>'Tulis Berita Anda ...')); ?>
		<?php echo $form->error($model,'isi_berita'); ?>
		</div>
		<div class="col-sm-3" align="center">	
		<?php echo $form->labelEx($model,'status'); ?></br>
		<?php 
			echo $form->radioButtonList($model, 'status', array("P" => 'TERBIT',"D" => 'DRAFT'), array(
				'labelOptions' => array('class' => 'icheck-label form-label'),
				'separator' => ' ',));
			echo $form->error($model,'status'); 
		?>
		</div>
		<div class="col-sm-2" align="center">	
		<?php echo $form->labelEx($model,'sticky'); ?></br>
		<?php 
			echo $form->radioButtonList($model, 'sticky', array("Y" => 'YA',"N" => 'TIDAK'), array(
				'labelOptions' => array('class' => 'icheck-label form-label'),
				'separator' => ' ',));
			echo $form->error($model,'sticky'); 
		?>
		</div>
		<div class="col-sm-7">	
		<?php echo $form->labelEx($model,'news_img'); ?>
		<?php echo CHtml::fileField('news_img'); ?>
		<?php echo $form->error($model,'news_img'); ?>
		</div>
	</div><div class="clearfix"></div></br>
	<div class="box-footer">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN',array('class'=>'btn btn-block btn-flat btn-success')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>