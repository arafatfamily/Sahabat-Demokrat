<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'merchant-form',
	'method'=>'POST',
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>
	<div class="row">
		<div class="form-group">
			<div class="col-sm-12">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Informasi Merchant</b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
			</div>
			<div class="col-sm-4">
			<?php echo $form->labelEx($model,'member_id'); ?>
			<?php echo Select2::activeDropDownList($model, 'member_id', array(), array(
				'placeholder'=>'Pilih Pemilik...',
				'class' => 'form-control',
				'select2Options'=>array(
					'escapeMarkup'=>new CJavaScriptExpression('function (m) {return m;}'),
					'minimumInputLength'=>'3',
					'ajax'=>array(
						'url'=> Yii::app()->createUrl('merchant/loadMember'),
						'type'=>'GET',
						'dataType'=>'json',
						'data'=>new CJavaScriptExpression('function (text, page) {return {q: text, page:page}}'),
						'results'=>new CJavaScriptExpression('function (data, page) {return {results:  data.member};}'),						
					),
					'formatResult'=> new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
					}'),
					'formatSelection'=>new CJavaScriptExpression('function format(state) {
						var originalOption = state.element;
						return "<span class=\'glyphicon glyphicon-ok-circle\'></span> " + state.text;
					}'),
				)
			)); echo $form->error($model,'member_id'); ?>
			</div>
			<div class="col-sm-8">
			<?php echo $form->labelEx($model,'nama'); ?>
			<?php echo $form->textField($model, 'nama', array('class' => 'form-control', 'placeholder' => 'Tulis Nama Merchant')); ?>
			<?php echo $form->error($model,'nama'); ?>
			</div>
			<div class="col-sm-12">
			<?php echo $form->labelEx($model,'keterangan'); ?>
			<?php $this->widget('ext.useEditor.JqueryTE', array(
                'id'=>'contrl',
                'model'=>$model,
                'attribute'=>'keterangan',
                'value'=>$model->keterangan,
                'options'   => array(
                    'strike'=> false,
                    'sub'=>false,
                    'source'=>false,
                    'button'=>'SEND',
                    //'format'=>false,
                    'formats'=>'[["p","Paragraph"],["h1","My Head 1"]]',
                    'fsizes'=>'["10", "15", "20"]',   
                    'linktypes'=>'["Web URL", "E-mail", "Picture"]',
                ),
            )); ?>
			<?php echo $form->error($model,'keterangan'); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label><?php echo "PROPINSI"; ?></label>
				<?php echo Select2::dropDownList('provinsi', '', array('' => ''), array(
					'prompt' => 'PILIH PROVINSI', 'value' => '', 'onchange' => '{loadKabupaten()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="col-sm-6">
				<label><?php echo "KABUPATEN"; ?></label>
				<?php echo Select2::dropDownList('kabupaten', '', array('' => ''), array(
					'prompt' => 'PILIH KABUPATEN', 'onchange' => '{loadKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="col-sm-6">
				<label><?php echo "KECAMATAN"; ?></label>
				<?php echo Select2::dropDownList('kecamatan', '', array('' => ''), array(
					'prompt' => 'PILIH KECAMATAN', 'onchange' => '{loadKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
			</div>
			<div class="col-sm-6">
			<?php echo $form->labelEx($model,'subdistrict'); ?>
			<?php echo Select2::activeDropDownList($model, 'subdistrict', array(), array(
				'prompt' => 'PILIH KELURAHAN', 'class' => 'form-control', 'selected' => 'selected')); ?>
			<?php echo $form->error($model,'subdistrict'); ?>
			</div>
			<div class="col-sm-12">
			<?php echo $form->labelEx($model,'alamat'); ?>
			<?php echo $form->textField($model, 'alamat', array('class' => 'form-control', 'placeholder' => 'Tulis Alamat Merchant')); ?>
			<?php echo $form->error($model,'alamat'); ?>
			</div>
		</div>
		<div id="panel-dokument" class="form-group col-sm-6">
			<div class="col-sm-12">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Data Poster Merchant</b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
			</div>
			<div class="col-sm-12" align="center">
				<p class="bg-danger"><small class="text-uppercase">Catatan : Ukuran poster 1140pixels X 500pixels</small></p><div class="clearfix"></div>
				<span id="upload-Poster" class="close" onclick="imgEditor(this.id.split('-')[1], this.src)"><i class="fa fa-cloud-upload icon-xs icon-danger icon-rounded"></i></span>
				<?php echo CHtml::image(null, null, array('class'=>'img-thumbnail', 'id'=>'Poster', 'onclick'=>'imgEditor(this.id, this.src)', 'style'=>'width:570px;height:250px;background-color:#999')) ?>
				<input id="file-Poster" onchange="readImage(this)" type="file" style="visibility: hidden" accept="image/x-png, image/gif, image/jpeg">
			</div>
		</div>
		<div class="form-group col-sm-6">
			<div class="col-sm-12">
				<div class="clearfix"></div></br>
					<span class="bg-info text-uppercase"><b>Map Lokasi Merchant</b></span>
					<hr style="border-bottom: 1px solid green;margin-top: 1px">
			</div>
			<div class="col-sm-12">
				<?php $this->widget('ext.useLocationPicker.LocationPicker', array(
					'model' => $model,
					'latId' => "latitude",
					'lonId' => "longitude",
				)); ?>
			</div>
			<?php echo CHtml::hiddenField('postPoster'); ?>
		</div>
	</div><div class="clearfix"></div></br>
	<div class="col-lg-8 pull-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'D A F T A R' : 'S I M P A N', array('class' => 'btn btn-primary btn-block pull-right')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>