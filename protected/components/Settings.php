<?php
class Settings extends CApplicationComponent {
	public static function getMenu() {
		if(Yii::app()->user->isAdmin()) {
			if (yii::app()->user->isSuperadmin() || Yii::app()->user->getuser('menu') == 'true') {
				$sql = "SELECT DISTINCT A.parent,A.name as menu,A.link as url,A.icon_class as icons FROM menu A WHERE A.location='B' ORDER BY A.order,A.sort";
			} else {
				$sql = "SELECT DISTINCT A.parent,A.name as menu,A.link as url,A.icon_class as icons FROM menu A INNER JOIN users_granted UG ON UG.menu_id=A.menu_id WHERE UG.users_id='" . Yii::app()->user->getuser('users_id') . "' AND A.location='B' ORDER BY A.order,A.sort";
			}
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			$parent = "";
			foreach ($rows as $row) {
				if ($row['parent'] == $parent) {
					continue;
				}
				if (yii::app()->user->isSuperadmin() || Yii::app()->user->getuser('menu') == 'true') {
					$sql = "SELECT A.parent,A.name as menu,A.link as url,A.icon_class as icons FROM menu A where A.name is not null and A.parent ='" . $row['parent'] . "'  AND A.location='B' order by A.order,A.sort";
				} else {
					$sql = "SELECT A.parent,A.name as menu,A.link as url,A.icon_class icons FROM menu A INNER JOIN users_granted UG ON UG.menu_id=A.menu_id WHERE A.name IS NOT NULL AND A.parent ='" . $row['parent'] . "' AND UG.users_id='" . Yii::app()->user->getuser('users_id') . "' AND A.location='B' GROUP BY A.name ORDER BY A.order,A.sort";
				}
				$rows = Yii::app()->db->createCommand($sql)->queryAll();
				echo '<li class="">';
				if (count($rows) > 0) {

					echo '<a href="javascript:;">';
					echo '<i class="' . $row['icons'] . '"></i><span class="title">' . $row['parent'] . '</span>';
					echo '<span class="arrow "></span>';
					echo '</a>';

					echo ' <ul class="sub-menu" >';
					foreach ($rows as $row) {
						echo '<li>';
						echo '<a href="' . Yii::app()->createUrl($row['url']) . '"><i class="' . $row['icons'] . '"></i>' . $row['menu'] . '</a>';
						echo '</li>';
					}
					echo '</ul>';
				} else {
					echo '<a href="' . Yii::app()->createUrl($row['url']) . '">';
					echo '<i class="' . $row['icons'] . '"></i><span class="title">' . $row['parent'] . '</span>';
					echo '</a>';
				}
				echo '</li>';

				$parent = $row['parent'];
			}
		} else {
			$menu = "SELECT DISTINCT A.parent,A.name as menu,A.link as url FROM menu A WHERE A.location='F' ORDER BY A.order,A.sort";
			$rMenu = Yii::app()->db->createCommand($menu)->queryAll();
			$parent = "";
			foreach ($rMenu as $row) {
				if ($row['parent'] == $parent) {
					continue;
				}
				$submenu = "SELECT A.parent,A.name as menu,A.link as url FROM menu A where A.name is not null and A.parent ='" . $row['parent'] . "'  AND A.location='F' order by A.order,A.sort";
				$rSubmenu = Yii::app()->db->createCommand($submenu)->queryAll();
				echo '<li class="">';
				if (count($rSubmenu) < 1) {
					echo '<a href="' . Yii::app()->createUrl($row['url']) . '">' . $row['parent'] . '</a>';
				} else {
					echo '<a href="#">' . $row['parent'] . '</a><div class="mega-menu"><ul class="sub-menu"><li><span data-column="one_fourth"></span><ul class="sub-menu">';
					foreach ($rSubmenu as $row) {
						echo '<li><a href="' . Yii::app()->createUrl($row['url']) . '">' . $row['menu'] . '</a></li>';
					}
					echo '</ul></li>';
					$berita = "SELECT news_id, judul FROM site_news WHERE sticky='Y' AND status='P' ORDER BY tgl_post DESC LIMIT 3";
					$rBerita = Yii::app()->db->createCommand($berita)->queryAll();
					echo '<li><span data-column="three_fourth"></span><ul class="sub-menu"><li class="clearfix menu-item"><div class="row post-list three-cols">';
					foreach ($rBerita as $feature) {
						echo '<article class="medium-4 large-4 columns"><div class="post elementFade border post-alternate-4"><a href="' . Yii::app()->createUrl('site/berita', array('id'=>$feature['news_id'])) . '" class="image-post item-overlay"><img src="' . Yii::app()->createUrl('berita/imgsite', array('id'=>$feature['news_id'])) . '" alt="" style="height: 166px"/></a><div class="entry-header"><h4 class="entry-title"><a href="' . Yii::app()->createUrl('site/berita', array('id'=>$feature['news_id'])) . '">' . $feature['judul'] . '</a></h4></div></div></article>';
					}
					echo '</div></li></ul></li>';
					echo '</ul></div>';
				}
				echo '</li>';
				$parent = $row['parent'];
			}
		}
	}
	public static function bestReference() {
		$peringkat=0;
		$topRef = "SELECT t.reference, COUNT(t.reference) AS total FROM member t WHERE NOT EXISTS (SELECT * FROM users WHERE users.member_id=t.reference) and t.reference <> '' GROUP BY t.reference ORDER BY total DESC limit 12";
		$tRef = Yii::app()->db->createCommand($topRef)->queryAll();
		foreach ($tRef AS $refer) {
			$total = $refer['total'];
			$memData = "SELECT m.id, UCASE(m.member_name) AS nama, UCASE(kb.nama) AS dpc, UCASE(pv.nama) AS dpd FROM member m "
					 . "INNER JOIN kabupaten kb ON kb.id_kab=SUBSTR(m.member_sub_district_id,1,4) "
					 . "INNER JOIN provinsi pv ON pv.id_prov=kb.id_prov "
					 . "WHERE m.membership_id='".$refer['reference']."'";
			$tData = Yii::app()->db->createCommand($memData)->queryAll();
			foreach ($tData AS $member) {
				$peringkat++;
				if (Yii::app()->user->isAdmin()) {
					echo '<div class="col-md-3 col-sm-6 col-xs-12">';
					echo '<div class="profile-info row">';
					echo '<div class="profile-image col-md-4 col-sm-4 col-xs-4">';
					echo '<a href="#"><img src="'.Yii::app()->controller->createUrl("member/loadphoto", array("id"=>$member["id"])).'" class="img-responsive img-circle"></a>';
					echo '</div>';
					echo '<div class="profile-details col-md-8 col-sm-8 col-xs-8" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">';
					echo '<h3><a href="#">'.$member["nama"].'</a><span class="profile-status online"></span></h3>';
					echo '<p class="profile-title">DPD. '.$member["dpd"].'</p>';
					echo '</div>';
					echo '</div>';
					echo '</div>';					
				} else {
					echo '<li style="margin-bottom:70px;width: 100%;">';
					echo '<div onmouseout="showPosisi(this,'.$member["id"].',0);" onmouseover="showPosisi(this,'.$member["id"].',1);" style="float:left;margin-right: 2px;">';
					echo '<div id="span_img_top_'.$member["id"].'" align="center" valign="center" style="border: 2px solid #808080;cursor: pointer; display:none; width:90px; height:108px;">';
					echo '<span style="cursor: pointer;color:red;font-size:52px;margin-top:-50px;">';
					echo '<b>'.$peringkat.'</b>';
					echo '</span>';
					echo '</div>';
					echo '<img id="id_img_top_'.$member["id"].'" src="'.Yii::app()->controller->createUrl("member/loadphoto", array("id"=>$member["id"])).'" alt="'.$member["id"].'"  width="90">';
					echo '</div>';
					echo '<div style="width: 100%;margin-top: -7px;">';
					echo '<p style="margin-bottom:0px;">&nbsp;&nbsp;'.$member["nama"].'<br/>';
					echo '&nbsp;&nbsp;'.$member["dpd"].'<br/>&nbsp;&nbsp;'.$member["dpc"].'<br/>';
					echo '&nbsp;&nbsp;Total Referensi : '.$total.' Kader</p>';
					echo '</div>';
					echo '</li>';
				}
			}
		}
		if (Yii::app()->user->isAdmin()) {
			echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a>';
			echo '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';
		}
	}
}
?>