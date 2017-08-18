<style type="text/css">
.pagebreak { page-break-before: always; }
body{
	margin: 0;
}
@media print{
	@page {
		size:letter
	}
	@page rotated { size : portrait }
	margin: 0;
}
th {
	text-align: left !important;
}
</style>
<center>
    <img src="<?php echo Yii::app()->controller->createUrl("member/loadPhoto", array("id" => $model->id)) ?>" width="200px">

    <h3>INFORMASI ANGGOTA</h3>
    <hr style="border-bottom: 1px solid green;">    
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => 'No KTA',
                'name' => 'membership_id',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
            // 'value' => $model->membership_id
            ),
            array(
                'label' => 'DPD',
                'name' => 'member_sub_district_id',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'value' => Member::getKabProvKec($model->member_sub_district_id, "nama_prov"),
            ),
            array(
                'label' => 'DPC',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'name' => 'member_sub_district_id',
                'type' => 'raw',
                'value' => Member::getKabProvKec($model->member_sub_district_id, "nama_kab"),
            ),
            array(
                'label' => 'Nama',
                'name' => 'member_name',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
            //'value' => $model->first_name . " " . $model->last_name
            ),
            array(
                'label' => 'Jenis Kelamin',
                'name' => 'gender',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'type' => 'raw',
                'value' => $model->gender == "L" ? "Laki - Laki" : "Perempuan",
                'htmlOptions' => array('style' => 'width:50px;text-align: center;'),
            ), array(
                'label' => 'Phone',
                'name' => 'cellular_phone_number',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'value' => $model->cellular_phone_number . "<br/>" . $model->home_phone_number
            ),
            array(
                'label' => 'Tempat/Tanggal Lahir',
                'name' => 'birth_place',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'value' => $model->birth_place . " / " . Globals::dateIndonesia($model->date_of_birth)
            ),
            array(
                'label' => 'Status Kawin',
                'name' => 'is_married',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'value' => $model->is_married == "Y" ? "Kawin" : "Tidak Kawin"
            ),
            'blood_type',
            'occupation',
            'couple_name',
            'children_name',
            array(
                'label' => 'Alamat',
                'name' => 'address',
                'type' => 'raw',
                'headerHtmlOptions' => array('style' => 'text-align: left;'),
                'value' => $model->address . " " . $model->home_number . " RT " . $model->rt .
                " RW " . $model->rw . ""
            //   " <br/> Kab." . Member::getID("nama", "kabupaten", "id_kab=$model->member_city_id") . " " . $model->postal_code
            ),
            'email',
            'facebook',
            'twitter',
        ),
    ));
    ?>
</center>