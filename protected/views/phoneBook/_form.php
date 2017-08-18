<?php
/* @var $this PhoneBookController */
/* @var $model PhBook */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ph-book-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'member_id'); ?>
		<?php echo $form->textField($model,'member_id'); ?>
		<?php echo $form->error($model,'member_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textArea($model,'Name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ph_number'); ?>
		<?php echo $form->textField($model,'ph_number',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'ph_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ph_grup'); ?>
		<?php echo $form->textArea($model,'ph_grup',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'ph_grup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_number'); ?>
		<?php echo $form->textArea($model,'other_number',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'other_number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->