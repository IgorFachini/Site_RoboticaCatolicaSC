<?php
   @header( 'Content-Type: text/html; charset=UTF-8' );
   require_once 'news/database/mysql.php';
   $db = new Mysql;
   ?>
<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Luiz Almeida">
      <title>WickedBotz</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/clean-blog.min.css" rel="stylesheet">
      <link href="css/feju.css" rel="stylesheet">
      <link href="css/botoesfeju.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
      <style media="screen">
      .navbar-default {
      background-color: rgba(200, 201, 202, 0.32);;
      border-color: transparent;
      }
      header{
        background: #675F81 none repeat scroll 0% 0%;
      }
      </style>
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="index.php">WickedBotz</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
               <ul class="nav navbar-nav navbar-right" >
                  <li>
                     <a href="index.php">Inicio</a>
                  </li>
                  <li>
                     <a href="about.html">Sobre</a>
                  </li>
                  <li>
                     <a href="post.html">Projetos</a>
                  </li>
                  <li>
                     <a href="contact.html">Contato</a>
                  </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container -->
      </nav>
      <!-- Page Header -->
      <!-- Set your background image for this header on the line below. -->
      <header class="intro-header">
         <section class="content-section video-section">
            <div class="header-video" style="width: 1349px; height: 318px;">
               <img src="http://zerosixthree.se/labs/video-header/img/masthead.jpg" class="header-video__media" data-video-url="https://www.youtube.com/embed/QVM8hOCflO0" data-teaser="video/teaser-video" data-video-width="560" data-video-height="315">
               <video autoplay="true" loop="true" muted="" id="header-video__teaser-video" class="header-video__teaser-video">
                  <source src="video/teaser-video.webm" type="video/mp4">
                  <source src="img/manfred.mp4" type="video/mp4">
               </video>
            </div>
         </section>
      </header>
      <!-- Main Content -->
      <div class="container">
         <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
               <?php
                  //$db->url = 'noticias.php';
                  $db->paginate(4);
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
                  <div>
                     <h4 class="text-left"><?=$n->noticia_title ?></h4>
                  </div>
                     <p class="">
                        <small><?=$n->noticia_content_cut ?></small><a href="noticia.php?id=<?= $n->noticia_id ?>" class="btn btn-link">leia mais</a>
                     </p>
               </div>
               <hr class="soften"/>
               <div class="text-center">
                  <?
                     endforeach;
                     echo $db->link;
                     endif;
                     ?>
                     <a href="#" id="subir">Voltar Ao Topo ↑</a>
               </div>
            </div>
         </div>
      </div>
    </div>
      <!-- Footer -->
      <footer>
         <div class="container text-center">
            <div class="row">
               <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                  <ul class="list-inline">
                     <li>
                        <a class="twt" href="#">
                        <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                     </li>
                     <li>
                        <a class="face" href="#">
                        <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i  class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                     </li>
                     <li>
                        <a class="git" href="#">
                        <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                     </li>
                  </ul>
                  <p class="copyright text-muted" id="ano"></p>
               </div>
            </div>
         </div>

      </footer>
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="js/clean-blog.min.js"></script>
      <script src="js/feju.js"></script>
      <script src="js/freelancer.js"></script>

      <script type="text/javascript">
      <script type="text/javascript">
  $(document).ready(function() {
     $('#subir').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
    return false;
       });
   });
</script>
      </script>
   </body>
</html>
