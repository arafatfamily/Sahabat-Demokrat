<style type="text/css">
.detail-view th{
	text-align: left !important;
}

#dapil th {
	text-align: left !important;
	width: auto;
}
</style>
<div class="small-12 columns">
	<div class="page-title">
		<h2>INFORMASI DATA KADER</h2>
	</div>
</div>
<section id="main" class="medium-12 large-12 columns">
	<section id="main" class="medium-8 large-8 columns">
		<div class="section padding-off" style="padding-top:10px;">
			<div class="tabs-holder">
				<ul class="small-12 tabs-nav clearfix">
					<li class="small-4 active"><h3>DATA KADER</h3></li>
					<li class="small-4"><h3>DOMISILI KADER</h3></li>
					<li class="small-4"><h3>DOKUMEN KADER</h3></li>
				</ul>
				<div class="tabs-container">
					<div class="tab-content">
						<?php $this->widget('zii.widgets.CDetailView', array(
							'data' => $model,
							'attributes' => array(
								array(
									'label' => 'NAMA LENGKAP',
									'name' => 'member_name',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
								),
								array(
									'label' => 'JENIS KELAMIN',
									'name' => 'gender',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => ($model->gender == "L" ? "Laki - Laki" : "Perempuan")
								),
								array(
									'label' => 'AGAMA',
									'name' => 'religion',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'type' => 'raw',
									'value' => $model->religion,
									'htmlOptions' => array('style' => 'width:50px;text-align: center;'),
								),
								array(
									'label' => 'TEMPAT/TGL LAHIR',
									'name' => 'birth_place',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->birth_place . " / " . Globals::dateIndonesia($model->date_of_birth)
								),
								array(
									'label' => 'GOLONGAN DARAH',
									'name' => 'blood_type',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->blood_type
								),
								array(
									'label' => 'STATUS KAWIN',
									'name' => 'is_married',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_married == "Y" ? "Menikah" : ($model->is_married == "N" ? "Belum Menikah" : ($model->gender == "L" ? "Duda" : "Janda"))
								),
								'couple_name',
								'children_name',
								'occupation',
								array(
									'label' => 'NO. SELULER',
									'name' => 'cellular_phone_number',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => substr($model->cellular_phone_number,0,strlen($model->cellular_phone_number)-8)."-XXXX-".substr($model->cellular_phone_number,-4)
								),
								array(
									'label' => 'ALAMAT SUREL',
									'name' => 'email',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->email != NULL ? "<a href='mailto:" . $model->email . "'>" . $model->email . "</a>" : ""
								),
								array(
									'label' => 'FACEBOOK PROFIL',
									'name' => 'facebook',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->facebook != NULL ? "<a href='https://facebook.com/" . $model->facebook . "'>https://facebook.com/" . $model->facebook . "</a>" : ""
								),
								array(
									'label' => 'TWITTER PROFIL',
									'name' => 'twitter',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->twitter != NULL ? "<a href='https://twitter.com/" . $model->twitter . "'>https://twitter.com/" . $model->twitter . "</a>" : ""
								),
							),
						)); ?>
					</div>
					<div class="tab-content">
						<?php $this->widget('zii.widgets.CDetailView', array(
							'data' => $model,
							'attributes' => array(
								array(
									'label' => 'ALAMAT',
									'name' => 'address',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_domisili == "Y" ? $model->address . " " . $model->home_number . " RT " . $model->rt . " RW " . $model->rw : $model->member_address . " " . $model->member_home_number . " RT " . $model->member_rt . " RW " . $model->member_rw
								),
								array(
									'label' => 'DESA/KELURAHAN',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_kel") : Member::getKabProvKec($model->member_sub_district_id, "nama_kel")
								),
								array(
									'label' => 'KECAMATAN',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_kec") : Member::getKabProvKec($model->member_sub_district_id, "nama_kec")
								),
								array(
									'label' => 'KABUPATEN/KOTA',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_kab") : Member::getKabProvKec($model->member_sub_district_id, "nama_kab")
								),
								array(
									'label' => 'PROPINSI',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_prov") : Member::getKabProvKec($model->member_sub_district_id, "nama_prov")
								),
								array(
									'label' => 'KODE POS',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;'),
									'value' => $model->postal_code
								),
							),
						)); ?>
					</div>
					<div class="tab-content">
					* Untuk Melihat Dokumen, Silahkan Klik Pada Gambar/Icon Dokumen.
						<?php foreach($dokumen as $data) {
							echo '<div class="testimonial">';
							echo '<div class="author-thumb"><a target="_blank" href="'.Yii::app()->controller->createUrl("member/viewDokumen", array("id" => $data["id_dok"])).'">';
							if($data["lamp_type"] == "application/pdf") {
								echo '<img src="'.Yii::app()->controller->createUrl("backend/loadImgSite", array("param" => "pdf_icon")).'" alt="'.$data["nama_dok"].'" style="height: 8em;">';
							} else {
								echo '<img src="images/testimonials/testimonials.jpg" alt="Undfined">';
							}
							echo '</a></div>';
							echo '<h3 style="text-transform: uppercase;">'.$data["nama_dok"].' (No.'.$data["no_dok"].')</h3>';
							echo '<blockquote><p>'.$data["description"].'</p></blockquote>';
							echo '<div class="quote-meta">Dikeluarkan Oleh : '.($data["dok_oleh"] == null ? $data["oleh_non"] : $data["dok_oleh"]).'</div>';
							echo '<div class="clearfix"></div></div>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<aside id="sidebar" class="medium-4 large-4 columns">
		<div class="tmm_row row" style="text-align:left; ">
			<div class="relative ">
			<?php if($model->member_status == 'A') {
				if(strlen($model->CARD_UID) >= 9) {
					echo '<p class="success">KADER TERVERIFIKASI (KTA AKTIF)</p>';
				} else {
					echo '<p class="notice">KADER TERVERIFIKASI (KTA NON-AKTIF)</p>';
				}
			} else {
				echo '<p class="error">KADER NON-AKTIF</p>';
			} ?>
			<div class="clear"></div>
			</div>
		</div>    
		<div class="arqam-widget-counter arq-outer-frame arq-col2">		
			<div class="testimonial">
				<center>
					<a href="#">
						<img src="<?php echo Yii::app()->controller->createUrl("member/loadphoto", array("id"=>$model->id)) ?>"  class="img-responsive img-circle">
					</a>
				</center></br>
					<?php $this->widget('zii.widgets.CDetailView', array(
						'data' => $model,
						'id' => 'dapil',
						'attributes' => array(
							array(
								'label' => 'D P D',
								'name' => 'member_sub_district_id',
								'type' => 'raw',
								'headerHtmlOptions' => array('style' => 'text-align: left;'),
								'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_prov") : Member::getKabProvKec($model->member_sub_district_id, "nama_prov")
							),
							array(
								'label' => 'D P C',
								'name' => 'member_sub_district_id',
								'type' => 'raw',
								'headerHtmlOptions' => array('style' => 'text-align: left;'),
								'value' => $model->is_domisili == "Y" ? Member::getKabProvKec($model->sub_district_id, "nama_kab") : Member::getKabProvKec($model->member_sub_district_id, "nama_kab")
							),
						),
					)); ?>
			</div>
		</div>
	</aside>
</section>