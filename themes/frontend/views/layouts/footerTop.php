<div class="footer-top" style="padding: 1.5rem 0">
	<div class="row">
		<div class="large-4 columns">
			<div id="text-2" class="widget widget_text">
				<h3 class="widget-title">Tentang Sahabat Demokrat</h3>
				<div class="textwidget">
					<p>Sahabat <b>Demokrat</b> adalah situs resmi keanggotaan PARTAI DEMOKRAT, yang di bawahi langsung oleh ketua Badan Pembina Organisasi Kaderisasi dan Keanggotaan PARTAI DEMOKRAT</br>(Jend. TNI AD (Purn) Pramono Edhie Wibowo).
					</p>
				</div>
			</div>
		</div>
		<div class="large-4 columns">
			<!--div class="widget widget_social clearfix" style="margin-bottom: 0.1rem !important;">
				<h3 class="widget-title">Kantor Pusat:</h3>
				<div class="textwidget">
					<p><b>DEWAN PIMPINAN PUSAT PARTAI DEMOKRAT</b></BR>
					ALAMAT : Jl. Proklamasi No.41, Jakarta Pusat 10320</br>
					TELP : +6221 - 31907999, FAX : +6221 - 31908999
					</p>
				</div>
			</div-->
			<div class="widget widget_subscription">
				<h3 class="widget-title">Berlangganan Berita</h3>
				<form method="post" class="subscription-form" enctype="multipart/form-data">
					<input type="hidden" name="subscription_form" value="subscription_form_552270c65d96c"/>
					<fieldset class="row collapse">
						<div class="small-10 columns">
							<input id="email_552270c65d96c" required type="email" name="subscriber_email"
								   value="" placeholder="Masukan Email Anda" style="padding: 0.8rem 1rem !important;"/>
						</div>
						<div class="small-2 columns">
							<button class="button submit mail-icon"></button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="large-4 columns">
			<div class="widget widget_latest_tweets">
				<h3 class="widget-title">Top Skore Referensi</h3>
				<script type="text/javascript">
					function scroll() {
						$('#reference ul li:first-child').slideUp(function () {
							$(this).appendTo($('#reference ul')).show("slow");
						});
					}
					setInterval(scroll, 5000);	
					function showPosisi(divFoto, id, isover){
						if (isover=="0"){
							document.getElementById("id_img_top_"+id).style.display = "block";
							document.getElementById("span_img_top_"+id).style.display = "none";	
						}else{
							document.getElementById("id_img_top_"+id).style.display = "none";
							document.getElementById("span_img_top_"+id).style.display = "block";
						}
					}
				</script>
				<div class="tweets-container" id="reference" style="margin-left:-30px;">
					<div id="test" style="height:115px;width: 100%;overflow: hidden;padding: 10px;">
						<ul>
						<?php echo Settings::bestReference(); ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>