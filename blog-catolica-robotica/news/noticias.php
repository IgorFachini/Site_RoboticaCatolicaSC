<?php
@header( 'Content-Type: text/html; charset=iso-8859-1' );
require_once 'database/mysql.php';
$db = new Mysql;
?>
<!DOCTYPE html>
	<html>
	<head>
		 <title>News</title>
		 <link href="css/home.css" rel="stylesheet">
		 <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
		 <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
		 <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share"type="text/javascript"></script>
		 <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		 <script>
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
		</script>
	</head>
<body>
	<div id="news" class="span12">
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
						$n->noticia_foto = "images/nopic.png";
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
							<p><small><?=$n->noticia_content_cut ?> <em><a href="noticia.php?id=<?= $n->noticia_id ?>" class="btn btn-link">leia mais</a></em></small>
					</div>
					</div>
					<hr />
					<?
				endforeach;
				echo $db->link;
			endif;
		?>
	</div>

    </body>
</html>
