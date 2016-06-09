<?php
   @header( 'Content-Type: text/html; charset=UTF-8' );
   require_once 'news/database/mysql.php';
   $db = new Mysql;
   ?>
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
     .container { overflow-x: hidden; }
   </style>
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
                  <small><?=$n->noticia_content_cut ?></small><a href="noticiaframe.php?id=<?= $n->noticia_id ?>" class="btn btn-link">leia mais</a>
               </p>
         </div>
         <hr class="soften"/>
         <div class="text-center">
            <?
               endforeach;
               echo $db->link;
               endif;
               ?>
         </div>
      </div>
   </div>
</div>

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
