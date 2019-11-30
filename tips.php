<!doctype html>
<html lang="pt">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="./css/bootstrap.min.css" crossorigin="anonymous">
		<title>CloudFlareAPI</title>
		<style>
			footer {
				padding-top: 70px;
			}
		</style>
	</head>
	<body background="./assets/bg1.jpg">
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FBAE40;">
			<a class="navbar-brand" href="./tips.php">
				<img src="./assets/brand/logo1.svg" width="30" height="30" class="d-inline-block align-top" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link" href="./">Home</a>
					<a class="nav-item nav-link" href="./dns_records.php">Dns Records</a>
					<?php if ( ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tip']) && !empty($_GET['tip'])) && ( strtolower($_GET['tip']) == "zoneid" || strtolower($_GET['tip']) == "authkey" )) : ?>
					<a class="nav-item nav-link active" href="./tips.php?tip=<?php echo $_GET['tip'];?>">Tips<span class="sr-only">(current)</span></a>
					<?php else: ?>
					<a class="nav-item nav-link active" href="./tips.php">Tips<span class="sr-only">(current)</span></a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
		<?php
		if(($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tip'])) && (strtolower($_GET['tip']) == "authkey" || strtolower($_GET['tip']) == "zoneid")):
			if(strtolower($_GET['tip']) == "zoneid"):
		?>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="text-center"><h1>[Tutorial] Como achar seu ZoneID CloudFlare</h1></div><br>
							<p><h4>1ª Cada Dominio Possui seu ZoneID</h4></p>
							<img src="./assets/img/dominios.png" alt="dominio.png">
							<p><h4>2ª Escolha um de seus dominios!</h4></p>
							<p><h4>E logo na pagina a seguir vai ter seu ZoneID<h4></p>
							<img src="./assets/img/overview.png" alt="overview.png">
							<div class="text-center pt-2"><a href="./tips.php"><button type="button" class="btn btn-outline-info btn-lg">Click aqui para mais dicas</button></a></div>
						</div>
					</div>
				</div>
		<?php
			elseif(strtolower($_GET['tip']) == "authkey"):
		?>
				<div class="counter-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="text-center"><h1>[Tutorial] Como achar seu Auth Key CloudFlare</h1></div><br>
							<p><h5>Diferente do ZoneID, o Auth Key fica associado a sua conta! Idependente de qualquer dominio!</h5></p>
							<p><h6>Para achar o seu AuthKey, Siga as instruções abaixo!</h6></p>
							<p><h6>1ª navegue até a <a href="https://dash.cloudflare.com/">dash</a> do cloudflare, certifique-se de estar logado, e no canto superior a esquerda da pagina, click na foto do seu perfil, e em seguida em <span style="font-weight: bold; color: red;">My Profile</span></h6></p>
							<img src="./assets/img/clickprofile.png" alt="clickprofile.png">
							<p><h6>2ª Em seguida Click em <span style="font-weight: bold; color: red;">API Tokens</span></h6></p>
							<img src="./assets/img/clickapitokens.png" alt="clickapitokens.png">
							<p><h6>3ª Em seguida procura por Global API Key, e lick em <span style="font-weight: bold; color: red;">View</span> mais a esquerda do site!</h6></p>
							<img src="./assets/img/clickview.png" alt="clickview.png">
							<div class="text-center pt-2"><a href="./tips.php"><button type="button" class="btn btn-outline-info btn-lg">Click aqui para mais dicas</button></a></div>
						</div>
					</div>
				</div>
		<?php
			endif;
		else:
			echo "<script>setTimeout(()=>{document.querySelector('footer>div').classList.add('fixed-bottom');},500);</script>";
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol>
						<li><a href="./tips.php?tip=ZoneID">Tutorial Obter ZoneID</a></li>
						<li><a href="./tips.php?tip=AuthKey">Tutorial Obter AuthKey</a></li>
					</ol>
				</div>
			</div>
		</div>
		<?php
		endif;
		?>
		<footer>
			<div class="navbar" style="background-color: #FBAE40;">
				<p style="text-align: center;">2019 © Copyright – Todos os Direitos Reservados</p>
			</div>
		</footer>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="./js/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
		<script src="./js/popper.min.js" crossorigin="anonymous"></script>
		<script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
	</body>
</html>