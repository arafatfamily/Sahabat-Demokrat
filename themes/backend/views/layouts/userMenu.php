<ul id="menu" class='wraplist'>	
	<li> 
		<a href="<?php echo Yii::app()->getBaseUrl(true); ?>">
			<i class="fa fa-dashboard"></i>
			<span class="title">Dashboard</span>
		</a>
	</li>
	<?php echo Settings::getMenu(); ?>
	<li class=""> 
		<a href="<?php echo Yii::app()->createUrl('users/logout'); ?>">
			<i class="fa fa-sign-out fa-md"></i>
			<span class="title">Keluar</span>
		</a>
	</li>
</ul>
<script type="text/javascript">
$(document).ready(function () {
	var path = window.location.pathname;
	path = path.replace(/\/$/, "");
	path = decodeURIComponent(path);
	$("#menu a").each(function () {
		var href = $(this).attr('href');
		if (path.endsWith(href) === true) {
			if ($(this).closest('ul').hasClass('sub-menu')) {
				$(this).parents('li').addClass('open');
				$(this).closest('a').addClass('active');
			} else {
				$(this).closest('li').addClass('open');
			}            
		}
	});
});
</script>