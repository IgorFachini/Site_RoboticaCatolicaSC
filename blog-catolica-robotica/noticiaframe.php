<?php
   @header( 'Content-Type: text/html; charset=UTF-8' );
   require_once 'news/database/mysql.php';
   $db = new Mysql;
?>

<?php
$db = new Mysql;
$nid_noticia = $_GET['id'];
$db->query("select * from noticia where noticia_id = $nid_noticia")->fetchAll();
if ($db->rows >= 1):
  $n = (object) $db->data[0];
  $n->noticia_content_cut = $db->cut($n->noticia_content, 300, '...');
  if ($n->noticia_foto == "" || strlen($n->noticia_foto) <= 1):
    $n->noticia_foto = "news/images/nopic.png";
  else :
    $n->noticia_foto = "fotos/$n->noticia_foto";
  endif;
endif;
?>
<title><?=$n->noticia_title?> </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/clean-blog.min.css" rel="stylesheet">
<link href="css/feju.css" rel="stylesheet">
<link href="css/botoesfeju.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<div class="container">
  <div class="row">

   <div class="media">
     <a class="pull-left">
       <img src="<?= $n->noticia_foto ?>" class="media-object img-polaroid" />
     </a>
     <div class="media-body">
       <h4 align="pull-left"><?=$n->noticia_title ?></h4>
       <p><?=$n->noticia_content ?></p>
       <!-- Botoes de compartilhamento para redes sociais -->
       <!-- AddToAny BEGIN -->
   <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
  <a class="a2a_button_twitter"></a>
   <a class="a2a_button_facebook"></a>
   <a class="a2a_button_google_plus"></a>
   <a class="a2a_button_linkedin"></a>
   </div>
   <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
   <!-- AddToAny END -->
     </div>
   </div>
   <ul class="pager">
     <li class="previous"><a href="javascript:history.back()">&larr; Voltar</a></li>
     <?
      $next_id = $n->noticia_id;
      $db->query("select * from noticia where noticia_id > $next_id order by noticia_id asc")->fetchAll();
      if($db->rows >= 1):
      $next_id = $db->data[0]['noticia_id'];
     ?>

     <li class="next"><a href="noticiaframe.php?id=<?=$next_id?>">Próxima &rarr;</a></li>
     <?endif;?>
   </ul>
 </div>
</div>

<hr class="soften">
<script type="text/javascript">
function responsiveIframes () {

// Handle iframes
if( $('iframe').length ) {

  // 4:3 Video Aspect Ratio = 0.75
  // 16:9 Video Aspect Ratio = 0.5625
  var aspectRatio = 0.5625;

  $('iframe').each(function(item) {

    // Get frame source attribute
    var frameSource = $(this).attr('src');

    // Set iframe width to 100%
    $(this).attr('width', '100%');

    // Hide overflowed content
    $(this).attr('style', 'overflow: hidden;');

    // Handle embedded video if the source includes a video domain
    if( -1 !== frameSource.indexOf('wistia') ||
        -1 !== frameSource.indexOf('vimeo') ||
        -1 !== frameSource.indexOf('youtube') ) {

      // Set fixed height using appropriate aspect ratio
      $(this).attr('height', $(this).innerWidth() * aspectRatio );
    }
  });
}
}
</script>
