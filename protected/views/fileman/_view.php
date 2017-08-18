<?php
/* @var $this FilemanController */
/* @var $data FileManager */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_file')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_file), array('view', 'id'=>$data->id_file)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_time')); ?>:</b>
	<?php echo CHtml::encode($data->date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('owner')); ?>:</b>
	<?php echo CHtml::encode($data->owner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('files')); ?>:</b>
	<?php echo CHtml::encode($data->files); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keterangan')); ?>:</b>
	<?php echo CHtml::encode($data->keterangan); ?>
	<br />


</div>