<div class="header-bottom">
	<div class="row">
		<div class="large-12 columns">
			<nav id="navigation" class="navigation top-bar" data-topbar>
				<div class="menu-primary-menu-container">
					<ul id="menu-primary-menu" class="menu">
						<li class="">
							<a href="<?php echo Yii::app()->getBaseUrl(true); ?>">Home</a>
						</li>
						<?php echo Settings::getMenu(); ?>
					</ul>
				</div>
				<div class="search-form-nav" style="display: none;">
					<form method="get" action="#">
						<fieldset>
							<input placeholder="Search" type="text" name="s" autocomplete="off" value=""
								   class="advanced_search"/>
							<button type="submit" class="submit-search">Search</button>
						</fieldset>
					</form>
				</div>
			</nav>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	var path = window.location.pathname;
	path = path.replace(/\/$/, "");
	path = decodeURIComponent(path);
	$("#menu-primary-menu a").each(function () {
		var href = $(this).attr('href');
		if (path.endsWith(href) === true) {
			$(this).closest('li').addClass('menu-item current_page_item');
		}
	});
});
</script>