<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'album-form',
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
        <div class="col-sm-12">
        <?php
            echo $form->labelEx($model,'nama');
            echo $form->textField($model,'nama',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Album ...'));
            echo $form->error($model,'nama'); 
        ?>
        </div>
        <div class="col-sm-12"> 
        <?php 
            echo $form->labelEx($model,'keterangan');
            echo $form->textArea($model,'keterangan',array('class'=>'form-control', 'rows'=>6, 'placeholder'=>'Tulis keterangan Album ...'));
            echo $form->error($model,'keterangan'); 
        ?>
        </div>
    </div><div class="clearfix"></div></br>
    <div class="box-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN',array('class'=>'btn btn-block btn-flat btn-success')); ?>
    </div>
<?php $this->endWidget(); ?>
</div>