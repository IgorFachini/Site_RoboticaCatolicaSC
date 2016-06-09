<?php
@header( 'Content-Type: text/html; charset=UTF-8' );
require_once 'database/mysql.php';
$db = new Mysql;
?>
<!DOCTYPE html>
	<html>
	<head>
		 <title>Católica DCE</title>
		 <link href="../css/bootstrap.min.css" rel="stylesheet">
		 <link href="../css/freelancer.css" rel="stylesheet">
		 <link href="../css/templatemo_style.css" rel="stylesheet">
		 <link href="../css/full-slider.css" rel="stylesheet">
		 <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		 <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
		 <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
		 <link href="../css/hover.css" rel="stylesheet">
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
 .newsz{
 background-image:url("img/Mural_1.jpg");
 }
 .botao{
	 background-color: rgba(110, 48, 63,.99) !important;  /*CABECALHO*/
 }
 .botao:hover{
	 background-color: rgba(110, 48, 63,.7) !important; /*CABECALHO*/
 }
li a:hover {
	background-color: rgba(110, 48, 63,.7) !important; /*CABECALHO*/
}
 </style>

		 <script>
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
		</script>
	</head>
	<body id="page-top" class="index">
	    <nav class="navbar navbar-default navbar-fixed-top">
	        <div class="container" id="sobrepor">
	            <div class="navbar-header page-scroll">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand hvr-buzz-out" href="#page-top"><img src="../img/logo2.png" alt="" style="width:100px; margin-top:-17px" /></a>
	            </div>
	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right" >
	                    <li class="hidden">
	                        <a href="#page-top" ></a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="../#portfolio">Nossa Equipe</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="../#about">Sobre</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="../#contact">Contato</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="noticias.php">Noticias</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="../institucional.html">Institucional</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a class="hvr-glow" href="../agenda.php">Agenda</a>
	                    </li>
	                </ul>
	            </div>
	        </div>
	    </nav>


		<div id="news" class="span12" style="margin-top:140px">
			<?php
			$db = new Mysql;
			$nid_noticia = $_GET['id'];
			$db->query("select * from noticia where noticia_id = $nid_noticia")->fetchAll();
			if ($db->rows >= 1):
				$n = (object) $db->data[0];
				$n->noticia_content_cut = $db->cut($n->noticia_content, 300, '...');
				if ($n->noticia_foto == "" || strlen($n->noticia_foto) <= 1):
					$n->noticia_foto = "images/nopic.png";
				else :
					$n->noticia_foto = "fotos/$n->noticia_foto";
				endif;
			endif;
			?>
			<div class="media">
				<a  class="pull-left">
					<img src="<?= $n->noticia_foto ?>" class="media-object img-polaroid" />
				</a>
				<div class="media-body">
					<h4 class="media-heading" align="center"><?=$n->noticia_title ?></h4>
					<p><?=$n->noticia_content ?></p>
					<!-- Botoes de compartilhamento para redes sociais -->
					<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_twitter"></a>
			<a class="a2a_button_google_plus"></a>
			</div>
			<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
			<!-- AddToAny END -->
				</div>
			</div>
			<ul class="pager">
			  <li class="previous botao"><a style="margin-left: 117px" class="hvr-wobble-skew" href="javascript:history.back()">&larr; Voltar</a></li>
			  <?
				 $next_id = $n->noticia_id;
				 $db->query("select * from noticia where noticia_id > $next_id order by noticia_id asc")->fetchAll();
				 if($db->rows >= 1):
				 $next_id = $db->data[0]['noticia_id'];
			  ?>

			  <li class="next botao"><a class="hvr-wobble-skew" href="noticia.php?id=<?=$next_id?>">Proxima &rarr;</a></li>
			  <?endif;?>
			</ul>
		</div>
	</section>
	<footer class="text-center"> <div class="footer-above">
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
	fa-dribbble"></i></a> </li>--> </ul> </div> <div class="footer-col col-md-4">
	<h3>Telefones</h3> <p id="telefone">(47) 3275 - 8303 </p> </div> </div> </div> </div> <div class="footer-below">
	<div class="container"> <div class="row"><hr class="soften"> <div class="col-lg-12" heigth="800px"> Todos os direitos reservados
	&copy;2015 <a href="http://www.ueuetech.com" target="_blank"><img src="../img/logo.jpg" alt="" width="50px" /> </a> </div> </div> </div> </div>
 </footer>

	<div class="scroll-top page-scroll visible-xs visible-sm">
			<a class="btn btn-primary" href="#page-top">
					<i class="fa fa-chevron-up"></i>
			</a>
	</div>

	<script type="text/javascript">
	jQuery(function($){
		 $("#phone").mask("(099) 9999-9999");
	});
	</script>
	<script src="../js/jquery.js"></script>
	<script src="../jquery.maskedinput.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.min.js"></script>
	<!-- Plugin JavaScript -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script src="../js/classie.js"></script>
	<script src="../js/cbpAnimatedHeader.js"></script>
	<!-- Contact Form JavaScript -->
	<script src="../js/jqBootstrapValidation.js"></script>
	<script src="../js/contact_me.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="../js/freelancer.js"></script>
	<!-- template sobrescrito -->
	<script src="../js/templatemo_script.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="../js/unslider.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!-- Pagina Campo de Team -->
	<script src="../js/jquery.singlePageNav.min.js"></script>
	<!--<script src="js/templatemo_script.js"></script>-->
    </body>
</html>
