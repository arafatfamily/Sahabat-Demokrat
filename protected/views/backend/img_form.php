<?php $model=new ImgSite('search');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ImgSite-form',
	'enableAjaxValidation'=>false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>
<div class="form-group">
	<div class="col-xs-6">
	<?php 
		echo $form->labelEx($model,'image');
		echo CHtml::fileField('image_file');
		echo $form->hiddenField($model,'img_type');
	?>
	</div>
	<div class="col-xs-6">
	<?php
		echo $form->labelEx($model,'params');
		$records = ImgSite::model()->findAll();
		$list = CHtml::listData($records, 'img_id', 'params');
		echo CHtml::dropDownList('img_id', null, $list, array('empty' => '--PILIH PARAMETER--', 'class'=>'form-control'));
	?>
	</div>
	<div class="col-xs-12">
	<?php
		echo $form->labelEx($model,'keterangan');
		echo CHtml::textArea('keterangan', '', array('readonly' => !(Yii::app()->user->isSuperadmin()), 'maxlength' => 110, 'rows' => 2, 'cols' => 50, 'class' => 'form-control')); 
	?>
	</div>
</div><div class="clearfix"></div></br>
<div class="col-xs-8 pull-right">
	<?php echo CHtml::submitButton('SIMPAN',array('class'=>'btn btn-block btn-flat btn-success')); ?>
</div><div class="clearfix"></div></br>
<?php $this->endWidget(); ?>
<div class="col-md-12 col-sm-12 col-xs-12">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#ID</th>
				<th>Parameter</th>
				<th>Keterangan</th>
			</tr>
		</thead>		
		<tbody>
		<?php $sql = "Select img_id,params,keterangan FROM img_site";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		foreach ($rows as $data) {
			echo '<tr><th scope="row">'.$data['img_id'].'</th><td>'.$data['params'].'</td><td>'.$data['keterangan'].'</td></tr>';
		} ?>
		</tbody>
	</table>
</div>