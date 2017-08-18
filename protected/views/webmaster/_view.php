<ul class="timeline">
<?php $sql="SELECT * FROM changelog ORDER BY date DESC LIMIT 10";
$rows = Yii::app()->db->createCommand($sql)->queryAll();
foreach ($rows as $data) {
	echo '<li class="' . ($data['posisi'] == 'R' ? 'timeline-inverted' : '') . '"><div class="timeline-badge animated flipInY" style="background-color:' . $data['warna_icon'] . ';"><i class="glyphicon glyphicon-' . $data['icon_mark'] . '"></i></div><div class="timeline-panel animated flipInY"><div class="timeline-heading"><h4 class="timeline-title">' . $data['nama'] . '</h4><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> ' . $data['date'] . ' by ' . ($data['webmaster'] == 1 ? 'Yasir Arafat, A.Md' : 'Achfas Faisal Kharis') . '</small></p></div><div class="timeline-body"><p>' . $data['keterangan'] . '.</p></div></div></li>';
} ?>
</ul>