<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/icheck.min.js" type="text/javascript"></script>
		<div class="content-body">
			<div class="row">
			<?php
			$form = $this->beginWidget('CActiveForm', array(
				'id' => 'users-form',
				'method' => 'POST',
				'enableAjaxValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
					'validateOnChange' => true
				),
				'htmlOptions' => array(
					'enctype' => 'multipart/form-data',
				)
			));
			?><?php echo $form->errorSummary($model); ?>
				<div class="col-xs-5">
					<div class="input-group primary col-xs-12">
						<span class="input-group-addon">
							<i class="fa fa-barcode"></i>
						</span>
						<?php
						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'model' => $model->member_id,
							'value' => $model->member_id,
							'name' => 'Users[member_id]',
							'sourceUrl' => $this->createUrl('member/reference'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => '4',
								'select' => 'js:function(event, ui) {$(this).val(ui.item.value); return false;}' //alert(ui.item.value);}'
							),
							'htmlOptions' => array(
								'class' => 'form-control', 'placeholder' => 'Masukan No. KTA Calon Admin'
							),
						));
						?>
					</div></br>
					<div class="col-xs-9">
							<label for="photo">
								<img class="img-circle img-responsive" style="margin: 0 17% 0 17%;cursor: pointer;" alt="Image Kader" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default-profile.JPG" data-holder-rendered="true">
							</label><?php echo CHtml::hiddenField('photo'); ?> 
							<!--input id="photo" name="photo" type="file" style="display: none;"/-->
					</div><div class="clearfix"></div></br>
					<div class="input-group transparent col-xs-12">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php echo $form->textField($model,'member_id',array('class'=>'form-control','placeholder'=>'Informasi Calon Admin','disabled'=>'disabled')); ?>
					</div>
				</div>
				<div class="col-xs-7">
					<div class="input-group primary col-xs-12">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>						
						<?php echo $form->textField($model,'username',($model->isNewRecord) ? array('size' => 40, 'maxlength' => 40, 'class' => 'form-control', 'placeholder' => 'Masukan Username') : array('class' => 'form-control', 'span' => 5, 'maxlength' => 255, 'readOnly' => 'readOnly')); ?>
					</div></br>
					<div class="input-group primary col-xs-12">
						<span class="input-group-addon"><i class="fa fa-certificate"></i></span>
						<?php echo $form->passwordField($model,'password',($model->isNewRecord) ? array('class'=>'form-control','placeholder'=>'Masukan Password') : array('class'=>'form-control','placeholder'=>'Untuk Mengganti Password Lakukan Ubah Password', 'readOnly' => 'readOnly')); ?>
					</div></br>
					<div class="input-group primary col-xs-12">
						<span class="input-group-addon"><i class="fa fa-certificate"></i></span>
						<?php echo $form->passwordField($model,'repeat_password',($model->isNewRecord) ? array('class'=>'form-control','placeholder'=>'Masukan Ulang Password') : array('class'=>'form-control','style'=>'display: none')); ?>
					</div></br>
					<div class="input-group primary col-xs-12" <?php echo ($model->isNewRecord) ? 'style="display: none"' : '' ?>>
						<!--?php echo $form->labelEx($model, 'status'); ?-->
						<span class="input-group-addon"><b>STATUS</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $form->radioButtonList($model, 'status', 
							array("A" => 'Aktif',"N" => 'Non Aktif',"B" => 'Block Akses'), 
								array('labelOptions' => array('class' => 'icheck-label form-label'),
									'separator' => ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ',)); ?>
					</div></br>
					<div class="input-group primary col-xs-12">
						<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
						<?php
						if (yii::app()->user->isSuperadmin()) {
							$criteria = new CDbCriteria();
							$list = new CActiveDataProvider('UsersRole', array('criteria' => $criteria,
								'sort' => array(
									'defaultOrder' => 'id asc',
							)));
						} else {
							$criteria = new CDbCriteria();
							$criteria->select = 't.*';
							if (yii::app()->user->getuser("role_id") == 3) {
								$criteria->condition = "t.id NOT IN ('1','2','6')";
							} else if (yii::app()->user->getuser("role_id") == 4) {
								$criteria->condition = "t.id NOT IN ('1','2','3','6')";
							} else if (yii::app()->user->getuser("role_id") == 5) {
								$criteria->condition = "t.id NOT IN ('1','2','3','4','6')";
							} else {
								$criteria->condition = "t.id NOT IN ('1')";
							}
							$list = new CActiveDataProvider('UsersRole', array('criteria' => $criteria,
								'sort' => array(
									'defaultOrder' => 'id asc',
							)));
						}
						echo $form->dropDownList($model, 'role_id', CHtml::listData($list->getData(), 'id', 'role'), array('onchange' => '{setRole()}', 'class' => 'form-control', 'selected' => 'selected'));
						?>
					</div></br>
					<div id="panel-propinsi" class="input-group primary col-xs-12" style="display: none;">
						<span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
						<?php echo Select2::activeDropDownList($model, 'id_prov', array('' => ''),
							array('prompt' => '--PILIH DPD--','onchange' => '{loadKabupaten()}','class' => 'form-control', 'selected' => 'selected',(Yii::app()->user->getuser("role_id") == 3 ? "required => true" : "")));
						?>
					</div></br>
					<div id="panel-kabupaten" class="input-group primary col-xs-12" style="display: none;">
						<span class="input-group-addon">
							<i class="fa fa-list-alt"></i>
						</span>
						<?php echo Select2::activeDropDownList($model, 'id_kab', array('' => ''), 
							array('prompt' => '--PILIH DPC--','onchange' => '{loadKecamatan()}','class' => 'form-control', 'selected' => 'selected',(Yii::app()->user->getuser("role_id") == 4 ? "required => true" : "")));
						?>
					</div></br>
					<div id="panel-kecamatan" class="input-group primary col-xs-12" style="display: none;">
						<span class="input-group-addon">
							<i class="fa fa-list-alt"></i>
						</span>
						<?php echo Select2::activeDropDownList($model, 'id_kec', array('' => ''), 
							array('prompt' => '--PILIH DPAC--','class' => 'form-control', 'selected' => 'selected',(Yii::app()->user->getuser("role_id") == 5 ? "required => true" : "")));
						?>
					</div>
				</div><div class="clearfix"></br></div>
				<div id="panel-templates" class="col-xs-6" style="display: none;"><div class="clearfix"></br></div>
				<?php $this->renderPartial('_formKta', array('model'=>$model)); ?>
				</div>
				<div id="panel-privileges" class="col-xs-6" style="display: none;"><div class="clearfix"></br></div>
					<?php
					if (Yii::app()->user->isSuperadmin()) {
						$cParent ="SELECT DISTINCT A.menu_id,A.parent,A.name as menu,A.link as url,A.icon_class as icons FROM menu A WHERE A.location='B' GROUP BY parent ORDER BY A.order,A.sort";
					} else {
						$cParent ="SELECT DISTINCT A.menu_id,A.parent,A.name as menu,A.link as url,A.icon_class as icons FROM menu A INNER JOIN users_granted ug ON ug.menu_id=A.menu_id WHERE A.location='B' AND ug.users_id='" . Yii::app()->user->getuser('users_id') . "' GROUP BY parent ORDER BY A.order,A.sort";
					}
					$parent = Yii::app()->db->createCommand($cParent)->queryAll();
					foreach($parent as $p) {
						if (count($p) > 0) {
							echo "<div class='panel-group primary' id='accordion-".$p['menu_id']."' role='tablist' aria-multiselectable='true' style='margin-bottom: 5px;'><div class='panel panel-default'><div class='panel-heading' role='tab' id='headingOne'><h4 class='panel-title'><a class='collapsed' data-toggle='collapse' data-parent='#accordion-".$p['menu_id']."' href='#collapseOne-".$p['menu_id']."' aria-expanded='false' aria-controls='collapseOne-".$p['menu_id']."' style='padding-top: 5px;padding-bottom: 5px;'><i class='fa fa-check'></i><b>".$p['parent']."</b></a></h4></div><div id='collapseOne-".$p['menu_id']."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'><div class='panel-body'>";
							if (Yii::app()->user->isSuperadmin()) {
								$cPriv = "SELECT ua.akses_id,ua.menu_id,mn.parent,UPPER(ua.akses_name) as akses_name,ug.users_id FROM users_akses ua LEFT JOIN menu mn ON mn.menu_id=ua.menu_id LEFT OUTER JOIN users_granted ug ON ua.akses_id=ug.akses_id GROUP BY ua.akses_id";
							} else {
								$cPriv ="SELECT ua.akses_id,ua.menu_id,mn.parent,UPPER(ua.akses_name) as akses_name,ug.users_id FROM users_akses ua LEFT JOIN menu mn ON mn.menu_id=ua.menu_id LEFT OUTER JOIN users_granted ug ON ua.akses_id=ug.akses_id WHERE users_id='" . Yii::app()->user->getuser('users_id') . "' GROUP BY ua.akses_id";
							}							
							$menu = Yii::app()->db->createCommand($cPriv)->queryAll();
							echo "<ul class='list-unstyled' data-type='horizontal'>";
							foreach($menu as $m) {
								if ($m['parent'] == $p['parent']) {
									echo "<li class='col-xs-6'><input tabindex='5' type='checkbox' id='square-checkbox-".$m['akses_id']."' name='privileges[".$m['akses_id']."]' value='".$m['akses_id']."' class='skin-square-blue'" . ($model->isNewRecord ? '' : (Globals::getAkses($model->users_id,$m['akses_id']) == 1 ? ' checked' : '')) . "><label class='icheck-label form-label' for='square-checkbox-".$m['akses_id']."'>&nbsp;&nbsp;".$m['akses_name']."</label></li>";
								}
							}
							echo "</ul></div></div></div></div>";
						} else {
							echo "Data Hak Akses Tidak Tersedia !";
						}
					}
					?>
				</div><div class="clearfix"></br></div>
				<div class="col-xs-8 pull-right">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah Admin' : 'Update Admin', array('class' => 'btn btn-success pull-right btn-block')); ?>
				</div>
			<?php $this->endWidget(); ?>
			</div>
		</div>
	</section>
</div>
<?php
$ismode = "tambah";
if (!$model->isNewRecord) {
    $ismode = "edit";
}

function checkAccess() {
    if ($ismode == "edit")
        return array('disabled' => true);
    else
        return array();
}
?>
<script type="text/javascript">
    function loadProvinsi() {
        $.ajax({
            url: "<?php echo CController::createUrl('site/loadprovinsi') ?>",
            type: 'POST',
            data: {},
            success: function (data) {
                $('#' + '<?php echo CHtml::activeId($model, 'id_prov') ?>').select2().select2('val', '');
                $('#<?php echo CHtml::activeId($model, 'id_prov') ?>').html(data);
                if ("<?php echo $ismode ?>" == "edit") {
                    $('#' + '<?php echo CHtml::activeId($model, 'id_prov') ?>').select2().select2('val', '<?php echo $model->id_prov ?>').attr('disabled',<?php echo Yii::app()->user->isSuperadmin() ? true : false ?>);
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
            data: {id_prov: $('#<?php echo CHtml::activeId($model, 'id_prov') ?>').val()},
            success: function (data) {
                $('#<?php echo CHtml::activeId($model, 'id_kab') ?>').html(data);
                $('#' + '<?php echo CHtml::activeId($model, 'id_kab') ?>').select2().select2('val', '');
                if ("<?php echo $ismode ?>" == "edit") {
                    $('#' + '<?php echo CHtml::activeId($model, 'id_kab') ?>').select2().select2('val', '<?php echo $model->id_kab ?>').attr('disabled','disabled');
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
            data: {id_kab: $('#<?php echo CHtml::activeId($model, 'id_kab') ?>').val()},
            success: function (data) {
                $('#<?php echo CHtml::activeId($model, 'id_kec') ?>').html(data);
                $('#' + '<?php echo CHtml::activeId($model, 'id_kec') ?>').select2().select2('val', '');
                if ("<?php echo $ismode ?>" == "edit") {
                    $('#' + '<?php echo CHtml::activeId($model, 'id_kec') ?>').val("<?php echo $model->id_kec ?>").attr('disabled','disabled');
                }
            },
            error: function (jqXHR, status, err) {
                alert(err);
            }
        });
    }
    function setRole() {
        var data = $('#' + '<?php echo CHtml::activeId($model, 'role_id') ?>').val();
        if (data == "3") {
            $('#panel-propinsi').show();
        } else if (data == "4") {
            $('#panel-propinsi').show();
            $('#panel-kabupaten').show();
        } else if (data == "5") {
            $('#panel-propinsi').show();
            $('#panel-kabupaten').show();
            $('#panel-kecamatan').show();
        } if (data == "1") {
            $('#panel-templates').hide();
            $('#panel-privileges').hide();
        } else {
            $('#panel-templates').show();
            $('#panel-privileges').show();
        }
    }
    $(document).ready(function () {
        loadProvinsi();
		setRole();
    });
</script>