<?php
@header( 'Content-Type: text/html; charset=utf-8' );
require_once 'database/mysql.php';
$db = new Mysql;
?>
<!DOCTYPE html>
	<html>
	<head>
		 <title>Noticias DCE</title>
		 <link href="css/home.css2" rel="stylesheet">
		<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"type="text/javascript"></script>
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		<script>
			 !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	 </script>
		 <link href="css/bootstrap.min.css" rel="stylesheet">
	 	<link href="css/freelancer.css" rel="stylesheet">
	 	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	 	<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	 	<link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

	 <style media="screen">


	 .navbar-default .navbar-toggle {
	 border-color: #ccc;
	 }
	 .navbar-default {
	 background-color: rgba(110, 48, 63,.99); /*CABECALHO*/
	 border-color: transparent;
	 }
	 footer .footer-above {
	 padding-top: 50px;
	 background-color: rgb(163, 71, 82);
	 }

	 footer .footer-below {
	 padding: 25px 0;
	 background-color: rgb(110, 48, 63);
	 }
	 .btn-success {
	 color: #ffffff;
	 background-color: rgb(163, 71, 82);
	 border-color: rgb(163, 71, 82);
	 }
	 .btn-success:hover {
	 color: #ffffff;
	 background-color: rgba(163, 71, 82,.9);
	 border-color: rgba(163, 71, 82,.9);
	 }
	 section.success {
	 	color: #FFF;
	 	background: #A34752 none repeat scroll 0% 0%;
	 }
	 hr.soften {
	 height: 1px;
	 background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
	 background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
	 background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
	 background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
	 border: 0;
	 }
/*Ola */
hr.style-rs {
    border: 1;
    border-bottom: 1px dashed #ccc;
    background-color: rgba(163, 71, 82,.9);


}
	 header, .btn-success{
	 background: rgb(163, 71, 82);
	 }
	 a{
	 color:rgb(163, 71, 82);
	 }
	 a:hover {
	 color: rgba(163, 71, 82,.9);
	 }
	 a, a:hover, a:focus, a:active, a.active {
	 outline: 0;
	 color: rgba(163, 71, 82,.9);
	 }
	 label {
	 color: rgba(163, 71, 82,.9);
	 }
	 label:hover{
	 color: rgba(163, 71, 82,.9);
	 }
	 footer .footer-below {
	 	background-color: rgb(163, 71, 82);
	 }
/* Muita calma aqui*/
.pagination {
		text-align: center;
		margin: 20px
}
.pagination a, .pagination strong {
		display: inline-block;
		margin-right: 3px;
		padding: 4px 12px;
		text-decoration: none;
	 line-height: 1.5em;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
}
.pagination a:hover {
		color: #fff;
}
.pagination a:active {
 background: rgba(190, 190, 190, 0.75);
}
.pagination strong {
		color: #fff;
		background-color: #BEBEBE;
}


	.pagination ul li a{
border:3px solid rgba(110, 48, 63,.99);
}
ul li {
display: inline;
text-align: center;
}

ul li a:hover {
background: rgba(110, 48, 63,.99);
color:#fff;
}

	 </style>
		 <script>
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
		</script>
	</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container" id="sobrepor">
					<div class="navbar-header page-scroll">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#page-top"><img src="img/logo2.png" alt="" style="width:100px; margin-top:-17px" /></a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right" >
								<li class="hidden">
										<a href="/index.html#page-top" ></a>
								</li>
								<li class="page-scroll">
										<a href="/index.html#portfolio">Nossa Equipe</a>
								</li>
								<li class="page-scroll">
										<a href="/index.html#about">Sobre</a>
								</li>
								<li class="page-scroll">
										<a href="/index.html#contact">Contato</a>
								</li>
								<li class="page-scroll active">
										<a href="/noticias.php">Noticia</a>
								</li>
								<li class="page-scroll">
										<a href="/institucional.html">Institucional</a>
								</li>
								<li class="page-scroll">
										<a href="/agenda.php">Agenda</a>
								</li>
						</ul>
					</div>
			</div>
	</nav>


	<header class="container" style="background: white; color:black"><br><br><br><br><br><br><br>
		<div id="news" class="span12" >
			<?php
				//$db->url = 'noticias.php';
				$db->paginate(3);
				$db->query("select * from  noticia order by noticia_id desc")->fetchAll();
				if ($db->rows >= 1):
					$news = $db->data;
					foreach ($news as $new):
						$n = (object) $new;
						$n->noticia_content_cut = $db->cut($n->noticia_content, 300, '...');
						if ($n->noticia_foto == "" || strlen($n->noticia_foto) <= 1):
							$n->noticia_foto = "news/images/nopic.png";
						else :
							$n->noticia_foto = "thumb.php?img=fotos/$n->noticia_foto";
						endif;
						?>
						<div class="media">
							<a  class="pull-left" href="noticia.php?id=<?= $n->noticia_id ?>">
								<img src="<?= $n->noticia_foto ?>" class="media-object img-polaroid" />
							</a>
							<div class="media-body">
								<h4 class="media-heading"><?=$n->noticia_title ?></h4>
							</div>
							<div class="">
								<p><small><?=$n->noticia_content_cut ?> <em><a href="noticia.php?id=<?= $n->noticia_id ?>" class="btn btn-link" style="color: white">leia mais</a></em></small>
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<div class="addthis_sharing_toolbox"></div>
						</div>
						</div>
						<hr class="style-rs"/>
						<?
					endforeach;
					echo $db->link;
				endif;
			?>
		</div>
	</header>

	<!-- Header -->
	<footer class="text-center"> <div class="footer-above" style="border-color:#CCC">
		<div class="container"> <div class="row">
			<div class="footer-col col-md-4">
	<h3>endereço</h3>
	 <p>R. dos Imigrantes, 500 - Rau <br/>Jaraguá do Sul - SC, 89254-430</p>
	</div>
	 <div class="footer-col col-md-4">
			<h3>Minhas Redes Sociais</h3>
			<ul class="list-inline">
				<li>
					<a href="https://www.facebook.com/catolicascdce" class="btn-social btn-outline" target="_blank">
						<i class="fa fa-fw fa-facebook"></i>
					</a>
				</li> <li> <a href="https://plus.google.com/u/0/109369468842351320095" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw
 fa-google-plus"></i></a> </li> <li> <a href="https://twitter.com/dcecatolica" target="_blank" class="btn-social
 btn-outline"><i class="fa fa-fw fa-twitter"></i></a> </li> <li> <a href="https://www.youtube.com/channel/UCPU6ZiZx1U1vxeWPtH-sPAQ"
 class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-youtube"></i></a>
</li> <!--<li> <a href="#" class="btn-social btn-outline"><i class="fa fa-fw
 fa-dribbble"></i></a> </li>--> </ul></div> <div class="footer-col col-md-4">
	<h3>Telefones</h3> <p id="telefone">(47) 3275 - 8303 </p>  </div> </div> </div> </div> <div class="footer-below">
	<div class="container"> <div class="row"><hr class="soften"> <div class="col-lg-12" heigth="800px"> Todos os direitos reservados
	&copy;2015 <img src="img/logo.jpg" alt="" width="50px" /> </div> </div> </div> </div>
 </footer>

	<div class="scroll-top page-scroll visible-xs visible-sm" style="align-left:20px">
			<a class="btn btn-primary" href="#page-top">
					<i class="fa fa-chevron-up"></i>
			</a>
	</div>
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55ca9230567d076f" async="async"></script>

	<script src="js/jquery.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Plugin JavaScript -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script src="js/classie.js"></script>
	<script src="js/cbpAnimatedHeader.js"></script>
	<!-- Contact Form JavaScript -->
	<script src="js/freelancer.js"></script>
	<!-- template sobrescrito -->
	<script src="js/templatemo_script.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/unslider.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- Pagina Campo de Team -->
	<script src="js/jquery.singlePageNav.min.js"></script>
	<!--<script src="js/templatemo_script.js"></script>-->
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

    </body>
</html>
