<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Tambah Foto Galeri</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<?php $this->renderPartial('_formGaleri', array('model'=>$model)); ?>				
			</div>
		</div>
	</section>
</div>
<div class="col-xs-12">
	<section class="box ">
		<header class="panel_header">
			<h2 class="title pull-left">Album Manager</h2>
		</header>
		<div class="content-body">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="list-group">
		                                            <a href="#" class="list-group-item">
		                                                <h4 class="list-group-item-heading">List group item heading</h4>
		                                                <p class="list-group-item-text">Dapibus ac facilisis in. Dapibus ac facilisis in</p>
		                                            </a>
		                                            <a href="#" class="list-group-item">
		                                                <h4 class="list-group-item-heading">List group item heading</h4>
		                                                <p class="list-group-item-text">Dapibus ac facilisis in. Dapibus ac facilisis in</p>
		                                            </a>
		                                            <a href="#" class="list-group-item">
		                                                <h4 class="list-group-item-heading">List group item heading</h4>
		                                                <p class="list-group-item-text">Dapibus ac facilisis in. Dapibus ac facilisis in</p>
		                                            </a>
		                                        </div>
		                          </div>
				<div class="col-md-6 col-sm-6 col-xs-6">
				<!--?php $this->renderPartial('_formAlbum', array('model'=>$album)); ?-->
				</div>				
			</div>
		</div>
	</section>
</div>