<template>
	<footer class="footer" :class="{ 'footer-home': home }">
		<div class="footer-wrap">
			<div class="container">
				<div class="row rw-footer">
					<div class="col-md-4 footer-left">
						<img class="icon-footer" src="/images/logo-2.png" alt />
						<p class="footer-content">
							YDSF adalah Lembaga Pendayagunaan Dana, Penghimpunan
							Dana adalah Konsekuensinya
						</p>
					</div>
					<div class="col-md-2 footer-center footer-center-1">
						<h5 class="title-footer">Tentang Kami</h5>
						<ul class="list-footer">
							<li>
								<a href="#">Profil</a>
							</li>
							<li>
								<a href="#">Visi & Misi</a>
							</li>
							<li>
								<a href="#">Sekilas Peduli bersama</a>
							</li>
							<li>
								<a href="#">Kebijakan Privasi</a>
							</li>
						</ul>
					</div>
					<div class="col-md-2 footer-center footer-center-2">
						<h5 class="title-footer">Program</h5>
						<ul class="list-footer">
							<li>
								<a href="#">Program</a>
							</li>
							<li>
								<a href="#">Mitra Kami</a>
							</li>
							<li>
								<a href="#">Success Stories</a>
							</li>
							<li>
								<a href="#">Ebook</a>
							</li>
						</ul>
					</div>
					<div class="col-md-4 footer-right">
						<h5 class="title-footer">Kontak Kami</h5>
						<p class="footer-content">
							Yayasan Dana Sosial Al-Falah Surabaya Jl. Kertajaya
							8C/17
						</p>
						<ul class="wrapper-icon-footer">
							<li>
								<a href="#">
									<i class="fa fa-whatsapp"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-twitter"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-facebook-f"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-instagram"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<p class="copy-right">
					Copyright ©2020 Yayasan Dana Sosial Al-Falah. All Rights
					Reserved
				</p>
			</div>
		</div>
	</footer>
</template>

<script>
export default {
	name: 'Footer',
	props: ['home'],
}
</script>

<style src="../../css/footer.css"></style>
<style scoped src="../../css/mobile.css">
