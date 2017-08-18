<?php
/* @var $this SiteConfigController */
/* @var $data ImgSite */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->img_id), array('view', 'id'=>$data->img_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_type')); ?>:</b>
	<?php echo CHtml::encode($data->img_type); ?>
	<br />


</div>