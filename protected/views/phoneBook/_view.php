<?php
/* @var $this PhoneBookController */
/* @var $data PhBook */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ph_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ph_id), array('view', 'id'=>$data->ph_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('member_id')); ?>:</b>
	<?php echo CHtml::encode($data->member_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ph_number')); ?>:</b>
	<?php echo CHtml::encode($data->ph_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ph_grup')); ?>:</b>
	<?php echo CHtml::encode($data->ph_grup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_number')); ?>:</b>
	<?php echo CHtml::encode($data->other_number); ?>
	<br />


</div>