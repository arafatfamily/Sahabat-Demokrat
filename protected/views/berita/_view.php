<?php
/* @var $this BeritaController */
/* @var $data SiteNews */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->news_id), array('view', 'id'=>$data->news_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin')); ?>:</b>
	<?php echo CHtml::encode($data->admin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('judul')); ?>:</b>
	<?php echo CHtml::encode($data->judul); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isi_berita')); ?>:</b>
	<?php echo CHtml::encode($data->isi_berita); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('news_img')); ?>:</b>
	<?php echo CHtml::encode($data->news_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sticky')); ?>:</b>
	<?php echo CHtml::encode($data->sticky); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgl_post')); ?>:</b>
	<?php echo CHtml::encode($data->tgl_post); ?>
	<br />


</div>