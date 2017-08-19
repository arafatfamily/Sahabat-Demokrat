<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">REKAP TOTAL DATA KADER <?php echo (is_null($model) ? 'NASIONAL' : $model->nama); ?></h2>
		</header><div class="clearfix"></div></br>
		<div class="row col-xs-12">
			<div class="col-xs-12">
				<ul class="nav nav-tabs vertical col-lg-3 col-md-3 col-sm-4 col-xs-4 left-aligned primary">
					<li  class="active"><a href="#nasional" data-toggle="tab"><i class="fa fa-calculator"></i>Ringkasan Total Kader</a></li>
				<?php foreach($dataProvider->data as $data) {
					echo '<li><a href="#'.$data['id'].'" data-toggle="tab"><i class="fa fa-calculator"></i>'.$data['name'].'</a></li>';
				} ?>
				</ul>
				<div class="tab-content vertical col-lg-9 col-md-9 col-sm-8 col-xs-8 left-aligned primary">
					<div class="tab-pane fade in active" id="nasional">
						<h2 class="text-uppercase bg-primary bold">TOTAL KADER <?php echo (is_null($model) ? 'NASIONAL' : $model->nama); ?></h2>
						<div class="col-md-12">
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'template' => '{items}{pager}',
							'dataProvider' => $dataProvider,
							'columns' => array(
								array(
									'header' => '',
									'name' => 'name',
									'type' => 'raw',
									'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
									'value' => function($data) {
										return (strlen($data['id']) > 4 ? '<b class="text-uppercase">' . $data['name'] . '<b>' : '<b class="text-uppercase">' . CHtml::link($data['name'], array($this->route, "id" => $data['id'])) . '</b>');
									}
								),
								array(
									'header' => 'JUMLAH',
									'name' => 'total',
									'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								),
							)
						));
						echo CHtml::button('EXPORT DATA', array(
								'id'=>'btn-cetak', 'class'=>'btn btn-danger btn-corner btn-block', 
								'onclick'=>'window.location="' . CController::createUrl('member/exportRekap', array('id'=>end(explode('/', Yii::app()->request->url)))) . '";')); ?>
						</div><div class="clearfix"></br></div>
					</div>
				<?php foreach($dataProvider->data as $rows) {
					echo '<div class="tab-pane fade" id="'.$rows['id'].'">';
					echo '<h2 class="text-uppercase bg-primary bold">Total Kader '.$rows['name'].'</h2><div class="col-md-12">';
					$dataGrid=Member::CountMemberRegion($rows['id']);
					$this->widget('zii.widgets.grid.CGridView', array(
						'template' => '{items}{pager}',
						'dataProvider' => $dataGrid,
						'columns' => array(
							array(
								'header' => '',
								'name' => 'name',
								'type' => 'raw',
								'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								'value' => function($data) {
									return (strlen($data['id']) > 4 ? '<b class="text-uppercase">' . $data['name'] . '<b>' : '<b class="text-uppercase">' . CHtml::link($data['name'], array($this->route, "id" => $data['id'])) . '</b>');
								}
							),
							array(
								'header' => 'JUMLAH',
								'headerHtmlOptions' => array('style' => 'text-align: left;width: 90px;height: 2px;'),
								'name' => 'total',
							),
						)
					));
					echo CHtml::button('EXPORT DATA', array(
							'id'=>'btn-cetak', 'class'=>'btn btn-danger btn-corner btn-block',
							'onclick'=>'js:document.location.href="' . CController::createUrl('member/exportRekap', array('id'=>$rows['id'])) . '"'));
					//echo '<h2 class="text-uppercase bg-primary bold">Total '.$rows['name'].' : '.Member::model()->count('substr(member_sub_district_id,1,2)='.$rows['id']).' Kader</h2>';
					echo '</div></div>';
				} ?>					
				</div>
			</div>
		</div><div class="clearfix"></div></br>
	</section>
</div>