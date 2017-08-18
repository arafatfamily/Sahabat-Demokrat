<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/>
<header class="panel_header">
    <h2 class="title pull-left"><?php echo $model->isNewRecord ? 'Pendafataran Anggota Kader' : 'Ubah Data Kader'; ?>
		<span class="badge badge-danger"> (*) Isian wajib di isi ! </span>
	</h2>
</header>
<div class="content-body">
    <div class="row">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'member-form',
		'method'=>'POST',
		'enableAjaxValidation'=>true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			//'afterValidate' => 'js:chkForm'
		),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
        //'focus'=>($model->hasErrors()) ? '.error:first' : array($model, 'title')
	)); ?>
	<div class="form-group" <?php echo $model->isNewRecord ? '' : 'style="display: none;"'; ?>>
		<div class="col-lg-10">
		<?php echo $form->labelEx($model,'reference'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model' => $model->reference,
			'value' => $model->reference,
			'name' => 'Member[reference]',
			'sourceUrl' => $this->createUrl('member/reference'),
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => '3',
				'select' => 'js:function(event, ui) {$(this).val(ui.item.value);  return false;}'
			),
			'htmlOptions' => array(
				'class' => 'form-control', 'placeholder' => 'Masukan No. KTA Referensi'
			),
		));
		?>		
		<?php echo $form->error($model,'reference'); ?>
		<?php echo CHtml::hiddenField('is_have_position'); ?>
		</div>
		<div class="col-lg-2" align="center">
			<label>Status Pengurus</label>
			<div class="onoffswitch">
				<input type="checkbox" name="Switch[is_have_position]" class="onoffswitch-checkbox" onchange="pengurus();" id="Switch_is_have_position" <?php echo ($model->is_have_position == 'N' || $model->isNewRecord ? '' : 'checked'); ?>>
				<label class="onoffswitch-label" for="Switch_is_have_position"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
	</div>
	<div id="panel-pengurus" class="form-group" <?php echo ($model->is_have_position == 'Y' ? '' : 'style="display: none;"'); ?>>
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>Informasi Jabatan Kader Partai Demokrat</b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-lg-12">
			<?php echo $form->labelEx($model,'membership_id'); ?>
                <?php echo $form->textField($model, 'membership_id', array('readonly' => !(Yii::app()->user->isSuperadmin()), 'maxlength' => 10, 'class' => 'form-control', 'placeholder' => 'No KTA Akan dibuat otomatis')); ?>
			<?php echo $form->error($model,'membership_id'); ?>
		</div>
		<div class="col-lg-3">
			<?php echo $form->labelEx($dokumen,'nama_dok'); ?>
                <?php echo $form->textField($dokumen, 'nama_dok', array('readonly' => !(Yii::app()->user->isSuperadmin()), 'maxlength' => 10, 'class' => 'form-control', 'placeholder' => 'ex.', 'disabled' => true)); ?>
			<?php echo $form->error($dokumen,'nama_dok'); ?>
		</div>
		<div class="col-lg-3">
			<?php echo $form->labelEx($dokumen,'no_dok'); ?>
                <?php echo $form->textField($dokumen, 'no_dok', array('readonly' => !(Yii::app()->user->isSuperadmin()), 'maxlength' => 10, 'class' => 'form-control', 'placeholder' => 'ex.', 'disabled' => true)); ?>
			<?php echo $form->error($dokumen,'no_dok'); ?>
		</div>
		<div class="col-lg-2">
			<?php echo $form->labelEx($dokumen,'lampiran'); ?>
                <?php echo $form->fileField($dokumen, 'lampiran', array('readonly' => !(Yii::app()->user->isSuperadmin()), 'maxlength' => 10, 'class' => 'form-control', 'disabled' => true)); ?>
			<?php echo $form->error($dokumen,'lampiran'); ?>
		</div>
		<div class="col-lg-4">
			<?php echo $form->labelEx($posisi,'level'); ?>
			<?php echo Select2::activeDropDownList($posisi, 'level', array('' => ''), array(
				'prompt' => 'PILIH TINGKATAN',
				'onchange' => '{loadPosisiUtama()}', 'class' => 'form-control', )); ?>
		</div>
		<div class="col-lg-5">
			<?php echo $form->labelEx($posisi,'position'); ?>
			<?php echo Select2::activeDropDownList($posisi, 'position', array('' => ''), array(
				'prompt' => 'PILIH POSISI',
				'onchange' => '{loadJabatanUtama()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
		</div>
		<div class="col-lg-5">
			<?php echo $form->labelEx($posisi,'position_as'); ?>
			<?php echo Select2::activeDropDownList($posisi, 'position_as', array('' => ''), array(
				'prompt' => 'PILIH JABATAN',
				'class' => 'form-control', 'selected' => 'selected' )); ?>
		<?php echo CHtml::hiddenField('is_other_position'); ?>
		</div>
		<div class="col-lg-2" align="center">
			<label>Jabatan Lain</label>
			<div class="onoffswitch">
				<input type="checkbox" name="Switch[is_other_position]" class="onoffswitch-checkbox" onchange="jabatan();" id="Switch_is_other_position" <?php echo ($model->is_other_position == 'N' || $model->isNewRecord ? '' : 'checked'); ?>>
				<label class="onoffswitch-label" for="Switch_is_other_position"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
		<div id="panel-jabatan" class="form-group" style="display: <?php echo ($model->is_other_position == 'Y' ? '' : 'none;'); ?>">
		<div class="clearfix"></div></br><hr style="border-bottom: 1px solid green;margin-top: 1px">
			<div class="col-lg-4">
			<?php echo $form->labelEx($posisi,'level'); ?>
			<?php echo Select2::dropDownList('level_lain', '', array('' => ''), array(
				'prompt' => 'PILIH PENGURUS LAIN',
				'value' => '',
				'onchange' => '{loadPosisiKedua()}', 'class' => 'form-control', )); ?>
			</div>
			<div class="col-lg-4">
			<?php echo $form->labelEx($posisi,'position'); ?>
			<?php echo Select2::dropDownList('Posisi_lain', '', array('' => ''), array(
				'prompt' => 'PILIH JABATAN LAIN',
				'onchange' => '{loadJabatanKedua()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
			<div class="col-lg-4">
			<?php echo $form->labelEx($posisi,'position_as'); ?>
			<?php echo Select2::dropDownList('jabatan_lain', '', array('' => ''), array(
				'prompt' => 'PILIH JABATAN LAIN',
				'class' => 'form-control', 'selected' => 'selected' )); ?>
			</div>
		</div>
	</div>
	<div id="panel-info" class="form-group">
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Data Kader Partai Demokrat </b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-sm-3">
		<label><?php echo "Jenis Identitas *" ?></label><br/>
		<?php echo $form->dropDownList( $posisi,'position_as', array('KTP' => 'KARTU TANDA PENDUDUK (KTP)','SIM' => 'SURAT UZUN MENGEMUDI (SIM)','PASSPORT' => 'PASSPORT'), array('class'=>'form-control', 'disabled'=>true)); ?>
		</div>
		<div class="col-lg-9">
		<label><?php echo "No. KTP / <strike>NO. SIM</strike> / <strike>NO. PASPOR</strike> *"; ?></label>
		<!--?php echo $form->labelEx($model,'identity_number'); ?-->
			<?php echo $form->textField($model,'identity_number',array('class'=>'form-control','onblur'=>'{readKTP(this.value)}','placeholder'=>'No. KTP (wajib 16 digit)')); ?>
			<?php echo $form->error($model,'identity_number'); ?>
		</div>
		<div class="col-lg-12">
		<?php echo $form->labelEx($model,'member_name'); ?>
			<?php echo $form->textField($model,'member_name',array('class'=>'form-control','placeholder'=>'Nama Calon Kader')); ?>
			<?php echo $form->error($model,'member_name'); ?>
		</div>
		<div class="col-lg-6">
		<?php echo $form->labelEx($model,'birth_place'); ?>
			<?php echo $form->textField($model,'birth_place',array('class'=>'form-control','placeholder'=>'Tempat Lahir (sesuai KTP)')); ?>
			<?php echo $form->error($model,'birth_place'); ?>
		</div>
		<div class="col-lg-6">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'language' => 'id',
            'attribute' => 'date_of_birth',
            'htmlOptions' => array('readonly' => false, 'class' => 'form-control', 'data-mask'=>'date', 'placeholder'=>'Tanggal Lahir (sesuai KTP)')
        ));
        ?>
        <?php echo $form->error($model,'date_of_birth'); ?>
		</div><div class="clearfix"></div>
		<div class="col-sm-3">
		<?php echo $form->labelEx($model,'gender'); ?><br/>
		<?php echo $form->radioButtonList($model, 'gender', array("L" => 'Pria',"P" => 'Wanita'), array(
				'labelOptions' => array('class' => 'icheck-label form-label'),
				'separator' => ' ',)); ?>
		<?php echo $form->error($model,'gender'); ?>
		</div>
		<div class="col-lg-3">
			<?php echo $form->labelEx($model, 'blood_type'); ?><br/>
			<?php echo $form->radioButtonList($model, 'blood_type', array("A" => 'A',"B" => 'B',"O" => 'O',"AB" => 'AB'), array(
				'labelOptions' => array('class' => 'icheck-label form-label'),
				'separator' => ' ',)); ?>   
			<?php echo $form->error($model, 'blood_type'); ?>
		</div>
		<div class="col-sm-6">
		<?php echo $form->labelEx($model,'is_married'); ?><br/>
		<?php echo $form->dropDownList($model,'is_married', array('Y' => 'MENIKAH','N' => 'BELUM MENIKAH','C' => 'JANDA / DUDA'), array('class'=>'form-control','onchange'=>'statusKader()')); ?>
		<?php echo $form->error($model,'is_married'); ?>
		</div><div class="clearfix"></div>
		<div id="panel-couple_name" class="col-lg-6" style="display: <?php echo ($model->is_married == 'Y' ? '' : 'none;'); ?>">
		<?php echo $form->labelEx($model,'couple_name'); ?>
			<?php echo $form->textField($model,'couple_name',array('class'=>'form-control','placeholder'=>'Nama Pasangan (suami/istri)')); ?>
			<?php echo $form->error($model,'couple_name'); ?>
		</div>
		<div id="panel-children" class="<?php echo ($model->is_married == 'Y' ? 'col-lg-6"' : ($model->is_married == 'C' ? '12"' : '6"  style="display: none;')); ?>">
		<?php echo $form->labelEx($model,'children_name'); ?>
			<?php echo $form->textField($model,'children_name',array('class'=>'form-control','placeholder'=>'Nama Anak (pisahkan dengan tanda koma (,) jika lebih dari 1')); ?>
			<?php echo $form->error($model,'children_name'); ?>
		</div><div class="clearfix"></div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'religion'); ?>
		<?php echo $form->dropDownList($model,'religion', array('ISLAM' => 'ISLAM','PROTESTAN' => 'PROTESTAN','KHATOLIK' => 'KHATOLIK','HINDU' => 'HINDU','BUDDHA' => 'BUDDHA','KONG HU CU' => 'KONG HU CU'), array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'religion'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'last_education_id'); ?>
		<?php echo Select2::activeDropDownList($model, 'last_education_id', array('' => ''), array(
			'prompt' => 'PILIH PENDIDIKAN',
			'class' => 'form-control', 'selected' => 'selected')); ?>
		<?php echo $form->error($model, 'last_education_id'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'occupation'); ?>
			<?php echo $form->textField($model,'occupation',array('class'=>'form-control','placeholder'=>'Pekerjaan')); ?>
			<?php echo $form->error($model,'occupation'); ?>
		</div>
	</div>
	<div id="domisili-ktp" class="form-group">
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Data Domisili Kader Partai Demokrat </b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-lg-6">
			<label><?php echo "Propinsi (sesuai Kartu Identitas)"; ?></label>
			<?php echo Select2::dropDownList('provinsi', '', array('' => ''), array(
				'prompt' => 'PILIH PROVINSI',
				'value' => '',
				'onchange' => '{loadKabupaten()}', 'class' => 'form-control', )); ?>
		</div>
		<div class="col-lg-6">
			<label><?php echo "Kabupaten (sesuai Kartu Identitas)"; ?></label>
			<?php echo Select2::dropDownList('kabupaten', '', array('' => ''), array(
				'prompt' => 'PILIH KABUPATEN',
				'onchange' => '{loadKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
		</div>
		<div class="col-lg-6">
			<label><?php echo "Kecamatan (sesuai Kartu Identitas)"; ?></label>
			<?php echo Select2::dropDownList('kecamatan', '', array('' => ''), array(
				'prompt' => 'PILIH KECAMATAN',
				'onchange' => '{loadKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
		</div>
		<div class="col-lg-6">
		<?php echo $form->labelEx($model,'sub_district_id'); ?>
		<?php echo Select2::activeDropDownList($model, 'sub_district_id', array('' => ''), array(
			'prompt' => 'PILIH KELURAHAN',
			'class' => 'form-control', 'selected' => 'selected')); ?>
		<?php echo $form->error($model, 'sub_district_id'); ?>
		</div>
		<div class="col-lg-10">
		<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textField($model,'address',array('class'=>'form-control','placeholder'=>'Alamat (Sesuai KTP)')); ?>
			<?php echo $form->error($model,'address'); ?>
		</div>
		<div class="col-lg-2">
		<?php echo $form->labelEx($model,'home_number'); ?>
			<?php echo $form->textField($model,'home_number',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'home_number'); ?>
		</div>
		<div class="col-lg-3">
		<?php echo $form->labelEx($model,'rt'); ?>
			<?php echo $form->textField($model,'rt',array('class'=>'form-control','placeholder'=>'RT (Sesuai KTP)')); ?>
			<?php echo $form->error($model,'rt'); ?>
		</div>
		<div class="col-lg-3">
		<?php echo $form->labelEx($model,'rw'); ?>
			<?php echo $form->textField($model,'rw',array('class'=>'form-control','placeholder'=>'RW (Sesuai KTP)')); ?>
			<?php echo $form->error($model,'rw'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'postal_code'); ?>
			<?php echo $form->textField($model,'postal_code',array('class'=>'form-control','placeholder'=>'Kode POS (Sesuai KTP)')); ?>
			<?php echo $form->error($model,'postal_code'); ?>
		<?php echo CHtml::hiddenField('is_domisili'); ?>
		</div>
		<div class="col-lg-2" align="center">
		<?php echo $form->labelEx($model,'is_domisili'); ?>
			<div class="onoffswitch">
				<input type="checkbox" name="Switch[is_domisili]" class="onoffswitch-checkbox" onchange="domisili();" id="Switch_is_domisili" <?php echo ($model->is_domisili == 'Y' || $model->isNewRecord ? 'checked' : ''); ?>>
				<label class="onoffswitch-label" for="Switch_is_domisili"><span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>
				</label>
			</div>
		</div>
	</div>	
	<div id="panel-domisili" class="form-group" style="<?php echo ($model->is_domisili == 'Y' || $model->isNewRecord ? 'display:none;' : 'display:block;'); ?>">
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-lg-6">
			<label><?php echo "Propinsi (sesuai Domisili)"; ?></label>
			<?php echo Select2::dropDownList('dpd', '', array('' => ''), array(
				'prompt' => 'PILIH PROVINSI',
				'value' => '',
				'onchange' => '{loadMemberKabupaten()}', 'class' => 'form-control', )); ?>
		</div>
		<div class="col-lg-6">
			<label><?php echo "Kabupaten (sesuai Domisili)"; ?></label>
			<?php echo Select2::dropDownList('dpc', '', array('' => ''), array(
				'prompt' => 'PILIH KABUPATEN',
				'onchange' => '{loadMemberKecamatan()}', 'class' => 'form-control', 'selected' => 'selected' )); ?>
		</div>
		<div class="col-lg-6">
			<label><?php echo "Kecamatan (sesuai Domisili)"; ?></label>
			<?php echo Select2::dropDownList('pac', '', array('' => ''), array(
				'prompt' => 'PILIH KECAMATAN',
				'onchange' => '{loadMemberKelurahan()}', 'class' => 'form-control', 'selected' => 'selected')); ?>
		</div>
		<div class="col-lg-6">
		<?php echo $form->labelEx($model,'member_sub_district_id'); ?>
			<?php echo Select2::activeDropDownList($model, 'member_sub_district_id', array('' => ''), array(
			'prompt' => 'PILIH KELURAHAN',
			'class' => 'form-control', 'selected' => 'selected')); ?>
			<?php echo $form->error($model,'member_sub_district_id'); ?>
		</div>
		<div class="col-lg-10">
		<?php echo $form->labelEx($model,'member_address'); ?>
			<?php echo $form->textField($model,'member_address',array('class'=>'form-control','placeholder'=>'Alamat (sesuai domisili)')); ?>
			<?php echo $form->error($model,'member_address'); ?>
		</div>
		<div class="col-lg-2">
		<?php echo $form->labelEx($model,'member_home_number'); ?>
			<?php echo $form->textField($model,'member_home_number',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'member_home_number'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'member_rt'); ?>
			<?php echo $form->textField($model,'member_rt',array('class'=>'form-control','placeholder'=>'RT (sesuai domisili)')); ?>
			<?php echo $form->error($model,'member_rt'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'member_rw'); ?>
			<?php echo $form->textField($model,'member_rw',array('class'=>'form-control','placeholder'=>'RW (sesuai domisili)')); ?>
			<?php echo $form->error($model,'member_rw'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'member_postal_code'); ?>
			<?php echo $form->textField($model,'member_postal_code',array('class'=>'form-control','placeholder'=>'Kode POS (sesuai domisili)')); ?>
			<?php echo $form->error($model,'member_postal_code'); ?>
		</div>
	</div>
	<div id="panel-kontak" class="form-group">
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>Informasi Kontak Kader Partai Demokrat </b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'home_phone_number'); ?>
			<?php echo $form->textField($model,'home_phone_number',array('class'=>'form-control','placeholder'=>'Masukan Nomor Telpon Rumah (jika ada)')); ?>
			<?php echo $form->error($model,'home_phone_number'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'cellular_phone_number'); ?>
			<?php echo $form->textField($model,'cellular_phone_number',array('class'=>'form-control','placeholder'=>'Masukan Nomor Seluler (wajib)')); ?>
			<?php echo $form->error($model,'cellular_phone_number'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'member_active_number'); ?>
			<?php echo $form->textField($model,'member_active_number',array('class'=>'form-control','placeholder'=>'Informasi Nomor Terverifikasi (otomatis)','disabled'=>'disabled')); ?>
			<?php echo $form->error($model,'member_active_number'); ?>
		</div><div class="clearfix"></div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'Masukan Alamat Surel (jika ada)')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'facebook'); ?>		
		<div class="input-group">
		  <span class="input-group-addon" id="fb-link">facebook.com/</span>
			<?php echo $form->textField($model,'facebook',array('class'=>'form-control','aria-describedby'=>'fb-link','placeholder'=>'Masukan Profil Facebook')); ?>
		</div>
			<?php echo $form->error($model,'facebook'); ?>
		</div>
		<div class="col-lg-4">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<div class="input-group">
		  <span class="input-group-addon" id="twitter-link">twitter.com/</span>
			<?php echo $form->textField($model,'twitter',array('class'=>'form-control','aria-describedby'=>'twitter-link','placeholder'=>'Masukan Username Twitter')); ?>
		</div>
			<?php echo $form->error($model,'twitter'); ?>				
		<?php echo CHtml::hiddenField('postIdentitas'); ?>
		<?php echo CHtml::hiddenField('postPhoto'); ?>
		</div>
		<div class="col-lg-12">
			<div class="clearfix"></div></br>
				<span class="bg-info text-uppercase"><b>Informasi Kelengkapan Dokumen Kader Partai Demokrat </b></span>
				<hr style="border-bottom: 1px solid green;margin-top: 1px">
        </div>
	</div>
	<div id="panel-dokument" class="form-group">
		<div class="col-lg-8 col-lg-7 col-lg-12" align="center">
			<label>UNGGAH HASIL SCAN KTP/SIM/PASPOR ANGGOTA.</label></br>
			<span id="del-Identitas" class="close"  onclick="imgEditor(this.id.split('-')[1], this.src)"><i class="fa fa-cloud-upload icon-xs icon-danger icon-rounded"></i></span>
			<?php $imgId = null;
			if(MemberIdentity::model()->findByPk($model->id)) {
				$imgId = Yii::app()->controller->createUrl('member/loadKtp', array('id' => $model->id));
			}
			echo CHtml::image($imgId, null, array('class'=>'img-thumbnail', 'id'=>'Identitas', 'onclick'=>'imgEditor(this.id, this.src)', 'style'=>'width:420px;height:260px;background-color:#999')) ?>
			<input id="file-Identitas" onchange="readImage(this)" type="file" style="visibility: hidden" accept="image/x-png, image/gif, image/jpeg">
		</div>
		<div class="col-lg-4 col-lg-5 col-lg-12" align="center">
			<label>UNGGAH PAS FOTO ANGGOTA.</label></br>
			<span id="del-Photo" class="close" onclick="imgEditor(this.id.split('-')[1], this.src)"><i class="fa fa-cloud-upload icon-xs icon-danger icon-rounded"></i></span>
			<?php $imgFt = null;
			if(MemberPhoto::model()->findByPk($model->id)) {
				echo '';
				$imgFt = Yii::app()->controller->createUrl('member/loadPhoto', array('id' => $model->id));
			}
			echo CHtml::image($imgFt, null, array('class'=>'img-thumbnail', 'id'=>'Photo', 'onclick'=>'imgEditor(this.id, this.src)', 'style'=>'width:224px;height:260px;background-color:#999')) ?>
			<input id="file-Photo" onchange="readImage(this)" type="file" style="visibility: hidden" accept="image/x-png, image/gif, image/jpeg">
		</div>
		<div class="clearfix"></div></br>
		<hr style="border-bottom: 1px solid green;margin-top: 1px"><hr style="border-bottom: 1px solid green;margin-top: 1px">
		<div class="col-lg-8 pull-right">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN', array('class' => 'btn btn-primary btn-block pull-right')); ?>
		</div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
</div>
<?php
$ismode = "add";
if (!$model->isNewRecord) {
    $ismode = "edit";
}
$domisili = Member::getKabProvKecID($model->sub_district_id);
$member_domisili = Member::getKabProvKecID($model->member_sub_district_id);
$position = Member::getLvlPosisiJabatanID($model->id);
$position2 = Member::getLvlPosisiJabatanID2($model->id);
?>
<script type="text/javascript" src="http://feather.aviary.com/imaging/v3/editor.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.mousewheel.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/messenger-theme-future.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script type="text/javascript">
function loadProvinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#provinsi').html(data);
			$("#provinsi").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#provinsi").select2().select2('val', '<?php echo $domisili['id_prov'] ?>');
			}
			loadKabupaten();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKabupaten() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#provinsi').val()},
		success: function (data) {
			$("#kabupaten").html(data);
			$("#kabupaten").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#kabupaten").select2().select2('val', '<?php echo $domisili['id_kab'] ?>');
			}

			loadKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#kabupaten').val()},
		success: function (data) {
			$('#kecamatan').html(data);
			$("#kecamatan").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#kecamatan").select2().select2('val', '<?php echo $domisili['id_kec'] ?>');
			}

			loadKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#kecamatan').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'sub_district_id') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'sub_district_id') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$('#' + '<?php echo CHtml::activeId($model, 'sub_district_id') ?>').select2().select2('val', '<?php echo $model->sub_district_id ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberProvinsi() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#dpd').html(data);
			$("#dpd").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#dpd").select2().select2('val', '<?php echo $member_domisili['id_prov'] ?>');
			}
			loadMemberKabupaten();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKabupaten() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
		type: 'POST',
		data: {id_prov: $('#dpd').val()},
		success: function (data) {
			$("#dpc").html(data);
			$("#dpc").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#dpc").select2().select2('val', '<?php echo $member_domisili['id_kab'] ?>');
			}
			loadMemberKecamatan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKecamatan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
		type: 'POST',
		data: {id_kab: $('#dpc').val()},
		success: function (data) {
			$('#pac').html(data);
			$("#pac").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#pac").select2().select2('val', '<?php echo $member_domisili['id_kec'] ?>');
			}
			loadMemberKelurahan();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadMemberKelurahan() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadkelurahan') ?>",
		type: 'POST',
		data: {id_kec: $('#pac').select2().select2('val')},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').html(data);
			$('#' + '<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$('#' + '<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').select2().select2('val', '<?php echo $model->member_sub_district_id ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadEducation() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadeducation') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#<?php echo CHtml::activeId($model, 'last_education_id') ?>').html(data);
			$("#<?php echo CHtml::activeId($model, 'last_education_id') ?>").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#<?php echo CHtml::activeId($model, 'last_education_id') ?>").select2().select2('val', '<?php echo $model->last_education_id; ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadTingkatUtama() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadTingkat') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#<?php echo CHtml::activeId($posisi, 'level') ?>').html(data);
			$("#<?php echo CHtml::activeId($posisi, 'level') ?>").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#<?php echo CHtml::activeId($posisi, 'level') ?>").select2().select2('val', '<?php echo $position['id_lvl'] ?>');
			}
			loadPosisiUtama();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadPosisiUtama() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadPosisi') ?>",
		type: 'POST',
		data: {id_level: $('#<?php echo CHtml::activeId($posisi, 'level') ?>').val()},
		success: function (data) {
			$('#<?php echo CHtml::activeId($posisi, 'position') ?>').html(data);
			$("#<?php echo CHtml::activeId($posisi, 'position') ?>").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#<?php echo CHtml::activeId($posisi, 'position') ?>").select2().select2('val', '<?php echo $position['id_pos'] ?>');
			}
			loadJabatanUtama();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadJabatanUtama() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadJabatan') ?>",
		type: 'POST',
		data: {id_Posisi: $('#<?php echo CHtml::activeId($posisi, 'position') ?>').val()},
		success: function (data) {
			$('#<?php echo CHtml::activeId($posisi, 'position_as') ?>').html(data);
			$("#<?php echo CHtml::activeId($posisi, 'position_as') ?>").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#<?php echo CHtml::activeId($posisi, 'position_as') ?>").select2().select2('val', '<?php echo $position['id_jab'] ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadTingkatKedua() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadTingkat') ?>",
		type: 'POST',
		data: {},
		success: function (data) {
			$('#level_lain').html(data);
			$("#level_lain").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#level_lain").select2().select2('val', '<?php echo $position2['id_lvl'] ?>');
			}
			loadPosisiKedua();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadPosisiKedua() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadPosisi') ?>",
		type: 'POST',
		data: {id_level: $('#<?php echo CHtml::activeId($posisi, 'level') ?>').val()},
		success: function (data) {
			$('#Posisi_lain').html(data);
			$("#Posisi_lain").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#Posisi_lain").select2().select2('val', '<?php echo $position2['id_pos'] ?>');
			}
			loadJabatanKedua();
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function loadJabatanKedua() {
	$.ajax({
		url: "<?php echo CController::createUrl('site/loadJabatan') ?>",
		type: 'POST',
		data: {id_Posisi: $('#<?php echo CHtml::activeId($posisi, 'position') ?>').val()},
		success: function (data) {
			$('#jabatan_lain').html(data);
			$("#jabatan_lain").select2().select2('val', '');
			if ("<?php echo $ismode ?>" == "edit") {
				$("#jabatan_lain").select2().select2('val', '<?php echo $position2['id_jab'] ?>');
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function pengurus() {
	loadTingkatUtama();
	$('#panel-pengurus').fadeToggle(750);
	if ($('#Switch_is_have_position').is(':checked') == true) {
		$('#is_have_position').val('Y');
	} else {
		$('#is_have_position').val('N');
		$('#is_other_position').val('N');
	}
}
function jabatan() {	
	loadTingkatKedua();
	$('#panel-jabatan').fadeToggle(750);
	if ($('#Switch_is_other_position').is(':checked') == true) {
		$('#is_other_position').val('Y');
	} else {
		$('#is_other_position').val('N');
	}
}
function statusKader() {
	if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'N') {
		$('#panel-couple_name').hide();
		$("#panel-children").hide();
	} if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'C') {
		$('#panel-couple_name').hide();
		$("#panel-children").show().removeClass('col-lg-6').addClass('col-lg-12');
	} if($('#<?php echo CHtml::activeId($model, 'is_married') ?>').val() == 'Y') {
		$("#panel-couple_name").show();
		$("#panel-children").show().removeClass('col-lg-12').addClass('col-lg-6');
	}
}
function domisili() {
	loadMemberProvinsi();
	$('#panel-domisili').fadeToggle(750);
	if ($('#Switch_is_domisili').is(':checked') == true) {
		$('#is_domisili').val('Y');
	} else {
		$('#is_domisili').val('N');
		$('#<?php echo CHtml::activeId($model, 'member_sub_district_id') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_address') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_home_number') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_rt') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_rw') ?>').val('');
		$('#<?php echo CHtml::activeId($model, 'member_postal_code') ?>').val('');
	}
}
var featherEditor = new Aviary.Feather({
	apiKey: '1d756282daca4b2aadf0a95375daf7b2',
	tools: [
		'enhance',
		'orientation',
		'warmth',
		'crop',
		'brightness',
		'contrast',
		'saturation',
		'sharpness',
		'whiten'
	],
	initTool:'crop',
	language: 'id',
	enableCORS: true,
	noCloseButton: true,
	displayImageSize: true
});
function imgEditor(id, src) {
	if (!src) {
		$("#file-"+id).trigger('click');
	} else {
		var el=document.getElementById(id);
		featherEditor.launch({
			image: id,
			url: src,
			cropPresets: [
				[id, el.offsetWidth+':'+el.offsetHeight]
			],
			//forceCropPreset: [id, el.offsetWidth+':'+el.offsetHeight],
			//forceCropMessage: 'Silahkan Crop Sesuai',
			onSave: function(imageID, newURL) {				
				var img = document.getElementById(imageID);
				img.src = newURL;
				$('#post'+imageID).val(newURL);
				featherEditor.close();
			}
		});
		return false;
	}
}
function readImage(input) {
	if (input.files && input.files[0]) {
        var fr = new FileReader();
        fr.onload = function (e) {
            $('#'+input.id.split("-")[1]).attr('src', e.target.result);
			imgEditor(input.id.split("-")[1], e.target.result);
        }
        fr.readAsDataURL(input.files[0]);
    }
}
var isktp = false;
function readKTP() {
	isktp = true;
	$.ajax({
		url: "<?php echo CController::createUrl('member/readKTP') ?>",
		type: 'POST',
		data: {nik: $('#<?php echo CHtml::activeId($model, 'identity_number') ?>').val()},
		success: function (data) {
			var obj = $.parseJSON(data);
			if (obj.success === true) {
				$("#provinsi").select2().select2('val', obj.provinsi);
				if (obj.tanggal_lahir.length < 2) {
					var tanggal_lahir = '0' + obj.tanggal_lahir;
				} else {
					var tanggal_lahir = obj.tanggal_lahir;
				}
				$("#<?php echo CHtml::activeId($model, 'date_of_birth') ?>").val(tanggal_lahir + "/" + obj.bulan_lahir + "/" + obj.tahun_lahir);
				if (obj.jk == "P") {
					$("#Member_gender_1").prop('checked', true);
				} else {
					$("#Member_gender_0").prop('checked', true);
				}
				$.ajax({
					url: "<?php echo CController::createUrl('site/loadkabupaten') ?>",
					type: 'POST',
					data: {id_prov: obj.provinsi},
					success: function (data) {
						$('#kabupaten').html(data);
						$('#kabupaten').select2().select2('val', obj.provinsi + "" + obj.kota);
						$.ajax({
							url: "<?php echo CController::createUrl('site/loadkecamatan') ?>",
							type: 'POST',
							data: {id_kab: obj.provinsi + "" + obj.kota},
							success: function (data) {
								$('#kecamatan').html(data);
								$('#kecamatan').select2().select2('val', obj.provinsi + "" + obj.kota + "" + obj.kecamatan);
								loadKelurahan();
							},
							error: function (jqXHR, status, err) {
								alert(err);
							}
						});
					},
					error: function (jqXHR, status, err) {
						alert(err);
					}
				});

			} else {
				//alert(obj.pesan);
			}
		},
		error: function (jqXHR, status, err) {
			alert(err);
		}
	});
}
function chkForm(form, data, hasError) {
	if (hasError == false) {
		$sButton = $(form).find("input[type=submit]");
		$($sButton).attr("value", "working...");
		$($sButton).attr("disabled", "disabled");
		$($sButton).fadeOut('normal');
		return true;
	}
}
function progressMessage() {
    var i = 0;
    Messenger({
        extraClasses: 'messenger-fixed messenger-on-right messenger-on-top',
        theme: 'future'
    }).run({
        errorMessage: 'Validating data ...',
        successMessage: 'Success ...!',
        action: function(opts) {
            if (++i < 2) {
                return opts.error({
                    status: 500,
                    readyState: 0,
                    responseText: 0
                });
            } else {
                return opts.success();
            }
        }
    });
}
$(document).ready(function () {
	loadProvinsi();
	loadEducation();
	if ("<?php echo $ismode ?>" == "edit" && "<?php echo $model->is_domisili ?>" == "Y") {
		loadMemberProvinsi();
	}
});
</script>