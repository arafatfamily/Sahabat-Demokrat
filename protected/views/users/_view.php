<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('users_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->users_id), array('view', 'id'=>$data->users_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
	<?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kader_id')); ?>:</b>
	<?php echo CHtml::encode($data->kader_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_prov')); ?>:</b>
	<?php echo CHtml::encode($data->id_prov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_kab')); ?>:</b>
	<?php echo CHtml::encode($data->id_kab); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_kec')); ?>:</b>
	<?php echo CHtml::encode($data->id_kec); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kdprint')); ?>:</b>
	<?php echo CHtml::encode($data->kdprint); ?>
	<br />

	*/ ?>

</div>