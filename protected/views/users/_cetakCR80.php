<div class="col-lg-12">
    <section class="box">
        <header class="panel_header">
            <h2 class="title pull-left">PRINT MASSAL KTA KADER</h2>
            <div class="actions panel_actions col-md-8">
				<div class="pull-right">
				<button class="btn btn-sm btn-purple" id="cari-kader" tabindex='-1' data-toggle='modal' onclick='search()' type="button"><span class="fa fa-search-plus"></span>&nbsp;CARI KADER&nbsp;</button>
				<button class="btn btn-sm btn-danger" id="reload" onclick="window.location.reload()" type="button"><span class="fa fa-refresh"></span></button>
				<button class="btn btn-sm btn-primary" onclick="cetak('KTACR80-DEPAN')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA DEPAN&nbsp;</button>
				<button class="btn btn-sm btn-info" onclick="cetak('KTACR80-BELAKANG')" type="button"><span class="fa fa-print"></span>&nbsp;CETAK KTA BELAKANG&nbsp;</button>
				</div>
            </div>
        </header>
		<div id="KTACR80-DEPAN" class="content-body"></div>
		<div id="KTACR80-BELAKANG" class="content-body"></div>
    </section>
</div>