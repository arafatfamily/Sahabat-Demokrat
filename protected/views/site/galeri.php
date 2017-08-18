<?php
$baseUrl = Yii::app()->theme->baseUrl;
?>
<div class="small-12 columns">
	<div class="page-title">
		<h2>Dokumentasi</h2>
	</div>
</div>
<section id="main" class="medium-12 large-12 columns" style="padding: 15px;">
	<span id="gallery-close" class="gallery-back">&larr;</span>
    <ul id="tp-grid" class="tp-grid">
        <?php foreach ($dpDownload->getData() as $record) {
            ?>
            <li data-pile="<?php echo $record['nama']; ?>">
                <a href="<?php echo Yii::app()->controller->createUrl("galeri/loadImg", array("id" => $record['galeri_id'])); ?>"
                   data-group="<?php echo $record['album']; ?>" class="item-overlay gallery popup-link-1">
                    <img src="<?php echo Yii::app()->controller->createUrl("galeri/loadImg", array("id" => $record['galeri_id'])); ?>" alt="" />
                </a>
            </li>
        <?php } ?>
    </ul>
</section>
<script src="<?php echo $baseUrl; ?>/css+js/mediaelement-and-player.min.js"></script>
<script src="<?php echo $baseUrl; ?>/css+js/jquery.stapel.js"></script>
<script src="<?php echo $baseUrl; ?>/css+js/jquery.magnific-popup.min.js"></script>