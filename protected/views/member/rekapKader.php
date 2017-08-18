<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">REKAP TOTAL DATA KADER</h2>
		</header><div class="clearfix"></div></br>
		<div class="row col-xs-12">
			<div class="col-xs-12">
				<ul class="nav nav-tabs vertical col-lg-3 col-md-3 col-sm-4 col-xs-4 left-aligned primary">
					<li  class="active"><a href="#nasional" data-toggle="tab"><i class="fa fa-calculator"></i>Total Kader Nasional</a></li>
				<?php foreach($dataProvider->getData() as $data) { //var_dump($dataProvider->getData()); exit;
					echo '<li><a href="#'.$data['id_prov'].'" data-toggle="tab"><i class="fa fa-calculator"></i>'.$data['nama'].'</a></li>';
				} ?>
				</ul>
				<div class="tab-content vertical col-lg-9 col-md-9 col-sm-8 col-xs-8 left-aligned primary">
					<div class="tab-pane fade in active" id="nasional">
						<h2 class="text-uppercase bg-primary bold">Total Kader Nasional</h2>
						<div class="col-md-12">
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'template' => '{items}{pager}',
							'dataProvider' => $dataProvider,
							'columns' => array(
								array(
									'header' => 'NAMA PROPINSI',
									'name' => 'nama',
									'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								),
								array(
									'header' => 'JUMLAH',
									'name' => 'total',
									'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
									/*'value'=> function($data) {
										//return Member::model()->count('substr(member_sub_district_id,1,2)='.$data['id_prov']);
									}*/
								),
							)
						)); ?>
						<h2 class="text-uppercase bg-primary bold">Total Nasional : <?php echo Member::model()->count(); ?> Kader</h2>
						</div><div class="clearfix"></br></div>
					</div>
				<?php foreach($dataProvider->data as $prov) {
					echo '<div class="tab-pane fade" id="'.$prov['id_prov'].'">';
					echo '<h2 class="text-uppercase bg-primary bold">Total Kader '.$prov['nama'].'</h2><div class="col-md-12">';
					$sql="select k.id_kab, k.id_prov, k.nama, count(*) as total from member m INNER JOIN kabupaten k on k.id_kab=SUBSTR(m.member_sub_district_id, 1, 4) WHERE k.id_prov='".$prov['id_prov']."' GROUP BY k.id_kab ORDER BY total DESC";
					$jumlah=Yii::app()->db->createCommand($sql);
					$data=new CSqlDataProvider($jumlah, array(
						'keyField'=>'id_kab',
						'pagination'=>false
					));
					$this->widget('zii.widgets.grid.CGridView', array(
						'template' => '{items}{pager}',
						'dataProvider' => $data,
						'columns' => array(
							array(
								'header' => 'NAMA KOTA/KABUPATEN',
								'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								'name' => 'nama',
							),
							array(
								'header' => 'JUMLAH',
								'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								'name' => 'total',
							),
						)
					));
					echo '<h2 class="text-uppercase bg-primary bold">Total '.$prov['nama'].' : '.Member::model()->count('substr(member_sub_district_id,1,2)='.$prov['id_prov']).' Kader</h2>';
					echo '</div></div>';
				} ?>					
				</div>
			</div>
		</div><div class="clearfix"></div></br>
	</section>
</div>