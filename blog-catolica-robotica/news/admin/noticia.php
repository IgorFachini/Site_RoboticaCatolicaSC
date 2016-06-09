<?php
   @header( "Content-Type: text/html; charset=UTF-8", true );
   require_once '../database/mysql.php';
   require_once '../class/Session.class.php';
   $db = new Mysql;
   $sid = new Session;
   $sid->start();
   if ( !$sid->check() )
   {
       @header( 'Location: login.php' );
   }

   if ( isset( $_GET['create'] ) )
   {
       if ( isset( $_POST['noticia_title'] ) )
       {
           $noticia_title = trim( $_POST['noticia_title'] );
           $noticia_content = trim( $_POST['noticia_content'] );
           $noticia_data = date('d/m/Y');
           $db->query( "insert into noticia (noticia_title,noticia_content,noticia_data) values ('$noticia_title','$noticia_content','$noticia_data');" );
           $noticia_id = mysql_insert_id();
           @header( "Location: noticia.php?edit=$noticia_id" );
       }
   }
   if ( isset( $_GET['upload'] ) )
   {
       $noticia_id = $_POST['noticia_id'];
       require_once '../class/Upload.class.php';
       $dir_dest = '../fotos';
       $files = array( );
       $file = $_FILES['noticia_foto'];
       $handle = new Upload( $file );
       if ( $handle->uploaded )
       {
           $handle->file_overwrite = true;
           $handle->image_convert = 'jpg';
           //Configuracoes de redimensionamento paisagem
           $pxMax = 300; //largura maxima permitida
           $pyMax = 200; // altura maxima permitida
           //Configuracoes de redimensionamento retrato
           $rxMax = 200; //largura maxima permitida
           $ryMax = 350; // altura maxima permitida
           if ( $handle->image_src_x > $handle->image_src_y ){
   			if ( $handle->image_src_x > $pxMax || $handle->image_src_y > $pyMax )
   			{
   			   $handle->image_x = $pxMax ;
   			   $handle->image_y = $pyMax;
   			   $handle->image_resize = true;
   			   $handle->image_ratio = true;
   			}
   		}
           if ( $handle->image_src_y > $handle->image_src_x ){
   			if ( $handle->image_src_x > $rxMax || $handle->image_src_y > $ryMax )
   			{
   			   $handle->image_x = $rxMax ;
   			   $handle->image_y = $ryMax;
   			   $handle->image_resize = true;
   			   $handle->image_ratio = true;
   			}
   		}
           $handle->file_new_name_body = md5( uniqid( $file['name'] ) );
           $handle->Process( $dir_dest );
           if ( $handle->processed )
           {
               $db->query( "insert into noticia (noticia_foto) values ('$handle->file_dst_name');" );
           }
       }
       else
       {
           echo $handle->error;
           echo "<br><a href=\"noticia.php\">voltar</a>";
           exit;
       }
   }

   if ( isset( $_GET['ok'] ) )
   {
       echo "<script>window.onload = function(){notify('<h1>Procedimento Realizado!</h1>')}</script>";
   }

   if ( isset( $_GET['update'] ) )
   {
       $noticia_id = $_POST['noticia_id'];
       $noticia_title = $_POST['noticia_title'];
       $noticia_content = $_POST['noticia_content'];
       $db->query( "update noticia set noticia_title = '$noticia_title', noticia_content ='$noticia_content' where noticia_id = $noticia_id;" );
       if ( isset( $_FILES['noticia_foto'] ) && !empty( $_FILES['noticia_foto']['name'] ) )
       {
           require_once '../class/Upload.class.php';
           $dir_dest = '../fotos';
   		$noticia_atual =  "";
   		if(isset($_POST['noticia_atual'])){
   			$noticia_atual = $dir_dest . "/" . $_POST['noticia_atual'];
   		}
           $files = array( );
           $file = $_FILES['noticia_foto'];
           $handle = new Upload( $file );
           if ( $handle->uploaded )
           {
               if ( file_exists( $noticia_atual ) )
               {
                   @unlink( $noticia_atual );
               }
   			$handle->file_overwrite = true;
   			$handle->image_convert = 'jpg';
   			//Configuracoes de redimensionamento paisagem
   			$pxMax = 300; //largura maxima permitida
   			$pyMax = 200; // altura maxima permitida
   			//Configuracoes de redimensionamento retrato
   			$rxMax = 200; //largura maxima permitida
   			$ryMax = 300; // altura maxima permitida
   			//echo "$handle->image_src_x > $handle->image_src_y";exit;
   			if ( $handle->image_src_x > $handle->image_src_y ){
   				if ( $handle->image_src_x > $pxMax || $handle->image_src_y > $pyMax )
   				{
   				   $handle->image_x = $pxMax ;
   				   $handle->image_y = $pyMax;
   				   $handle->image_resize = true;
   				   $handle->image_ratio = true;
   				}
   			}
   			if ( $handle->image_src_y > $handle->image_src_x ){
   				if ( $handle->image_src_x > $rxMax || $handle->image_src_y > $ryMax )
   				{
   				   $handle->image_x = $rxMax ;
   				   $handle->image_y = $ryMax;
   				   $handle->image_resize = true;
   				   $handle->image_ratio = true;
   				}
   			}
               $handle->file_new_name_body = md5( uniqid( $file['name'] ) );
               $handle->Process( $dir_dest );
               if ( $handle->processed )
               {
                   $file_dst_name = $handle->file_dst_name;
                   $db->query( "update noticia set noticia_foto = '$handle->file_dst_name' where noticia_id = $noticia_id;" );
               }
           }
           else
           {
               echo $handle->error;
               echo "<br><a href=\"noticia.php\">voltar</a>";
               exit;
           }
       }
       //@header( "Location: noticia.php?edit=$noticia_id&ok" );
   }

   if ( isset( $_GET['delete'] ) && !empty( $_GET['delete'] ) )
   {
       $noticia_id = $_GET['delete'];
       $db->query( "select * from noticia where noticia_id = $noticia_id;" )->fetchAll();
       if ( $db->rows >= 1 )
       {
           $f = ( object ) $db->data[0];
           $file = "../../fotos/$f->noticia_foto";
           if ( file_exists( $file ) )
           {
               @unlink( $file );
           }
       }
       $db->query( "delete from noticia where noticia_id = $noticia_id" );
       @header( "Location: noticia.php" );
   }

   function editor( $val = '' )
   {
     $body = "";
     $body .= "<link rel=\"stylesheet\" href=\"redactor/api/css/redactor.css\" />\n";
     $body .= "\t<script src=\"redactor/api/jquery-1.7.min.js\"></script>\n";
     $body .= "\t<script src=\"js/jquery-ui-1.9.2.js\"></script>\n";
     $body .= "\t<script src=\"redactor/api/redactor.js\"></script>\n";
     $body .= "\t<textarea id=\"noticia_content\" class=\"form-control\" name=\"noticia_content\" style=\"height: 130px; width:500px !important\">$val</textarea>\n";
     @header( 'Content-Type: text/html; charset=utf-8' );
     return trim( $body );
   }
   ?>
<!DOCTYPE html>
<html lang="pt-BR">
   <head>
      <title>..:Painel Administrativo:..</title>
      <link rel="stylesheet" href="css/zica.css" media="screen" title="no title" charset="utf-8">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <!-- Generic libs -->
      <script type="text/javascript" src="tpl/js/jquery-1.4.2.min.js"></script>
      <script type="text/javascript" src="tpl/js/html5.js"></script>
      <script type="text/javascript" src="tpl/js/old-browsers.js"></script>
      <!-- Template core functions -->
      <script type="text/javascript" src="tpl/js/common.js"></script>
      <script type="text/javascript" src="tpl/js/jquery.tip.js"></script>
      <script type="text/javascript" src="tpl/js/standard.js"></script>
      <!--[if lte IE 8]><script type="text/javascript" src="tpl/js/standard.ie.js"></script><![endif]-->
      <script src="js/jquery.scrollto.js" type="text/javascript"></script>
      <script type="text/javascript" src="js/noticia.js"></script>
      <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" media="all" />
      <style>
         .box-album{
         margin-top: 4em;
         }
         .pagination li{
         display:inline-block;
         float:left;
         padding:4px 6px;
         }
      </style>
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
               <a class="navbar-brand hvr-buzz-out" href="#page-top">
               <img src="../images/logo.png" alt="" style="width:100px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav navbar-right">
                  <li class="active"><a href="noticia.php" title="Noticias">
                     <i class="glyphicon glyphicon-file"></i> Noticia
                     </a>
                  </li>
                  <li><a href="calendario.php" title="Agenda">
                     <i class="glyphicon glyphicon-calendar"></i> Agenda
                     </a>
                  </li>
                  <li><a href="usuario.php" title="Usuarios">
                     <i class="glyphicon glyphicon-usd"></i> Produto
                     </a>
                  </li>
                  <li><a href="usuario.php" title="Usuarios">
                     <i class="glyphicon glyphicon-user"></i> Usuario
                     </a>
                  </li>
                  <li><a href="login.php?logout=true" title="Sair">
                     <i class="glyphicon glyphicon-remove"></i> Sair
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div id="home" class="container bg-found">
      <?php
         if ( isset( $_GET['edit'] ) )
         {
             $noticia_id = $_GET['edit'];
             ?>
      <?php
         $db->query( "select * from noticia where noticia_id = $noticia_id" )->fetchAll();
         if ( $db->rows >= 1 )
         {
             $noticia_title = $db->data[0]['noticia_title'];
             $noticia_content = $db->data[0]['noticia_content'];
             $noticia_foto = $db->data[0]['noticia_foto'];
             $noticia_id = $db->data[0]['noticia_id'];
             if ( $noticia_content == '0' )
             {
                 $noticia_content = "";
             }
             $editor = editor( $noticia_content );
             ?>
      <div class=" form-group">
         <div class="">
            <form action="noticia.php?update=true" method="post" role="form" enctype="multipart/form-data">
               <ul class="">
                  <div class="form-group">
                     <input placeholder="Titulo da noticia" class="form-control" required="true" type="text" name="noticia_title" value="<?= $noticia_title ?>" id="noticia_title" />
                  </div>
                  <div>
                     <h3>Conteudo da Noticia</h3>
                     <?= $editor ?>
                  </div>
                  <script>
                     window.onload = function()
                     {
                         $('#noticia_content').redactor();
                     }
                  </script>
                  <div class="form-group">
                     <label for="noticia_foto">Alterar Midia da Noticia</label>
                     <input type="file" name="noticia_foto" id="noticia_foto"
                        class="form-control" />
                  </div>
                  <? if ( $noticia_foto != "" )
                     { ?>
                  <p>
                     <label for="fo">Imagem Atual</label>
                     <img src="../fotos/<?= $noticia_foto ?>" />
                  </p>
                  <input type="hidden" name="noticia_atual" id="noticia_atual"  value="<?= $noticia_foto ?>"/>
                  <? } ?>
                  <input type="hidden" name="noticia_id" id="noticia_id"  value="<?= $noticia_id ?>"/>
                  <p>
                     <button class="btn btn-success btn-block">Atualizar Noticia</button>
                  </p>
               </ul>
            </form>
         </div>
         <?php
            }
            echo "</div>";
            }
            else
            {
            $editor = editor( '' );
            ?>
            <div class="form-box box-album">
               <div class="form-top">
                  <div class="form-top-left">
                     <h3>Cadastrar Noticia</h3>
                     <p></p>
                  </div>
                  <div class="form-top-right">
                     <i class="fa fa-pencil"></i>
                  </div>
               </div>
               <form name="f" action="noticia.php?create=true" method="post" class="form-bottom"
                  onsubmit="return validaUp()" enctype="multipart/form-data">
                  <fieldset class="">
                     <div class="form-group">
                        <input class="form-control" placeholder="Titulo da noticia" type="text" name="noticia_title" id="noticia_title" />
                     </div>
                  </fieldset>
                  <div>
                     <?= $editor ?>
                  </div>
                  <script>
                     window.onload = function()
                     {
                         $('#noticia_content').redactor();
                     }
                  </script>
                  <br />
                  <p>
                     <button class="btn btn-lg btn-primary btn-block">Cadastrar Noticia</button>
                  </p>
               </form>
            </div>
         <div class="panel panel-default">
            <div class="panel-heading">Painel de Noticias</div>
            <div class="panel-body">
               <p>Noticias adicionadas </p>
            </div>
            <table class="table table-striped table-hover table-responsive" id="tbl_list_serv">
               <thead class="thead-inverse">
                  <tr>
                     <th>Cógigo</th>
                     <th>Noticia</th>
                     <th>Data</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $db->paginate(8);
                     $db->query( "select * from  noticia order by noticia_id desc" )->fetchAll();
                     if ( $db->rows >= 1 )
                     {
                         $albuns = $db->data;
                         foreach ( $albuns as $album )
                         {
                             $alb = ( object ) $album;
                             if ( $alb->noticia_foto == "" || strlen( $alb->noticia_foto ) <= 1 )
                             {
                                 $foto = "../images/nopic.png";
                             }
                             else
                             {
                                 $foto = "../fotos/$alb->noticia_foto";
                             }

                             echo "<tr id=\"item_$alb->noticia_id\">";
                             echo "<td> $alb->noticia_id </td>";
                             //echo "<td> <img src=\"$foto\" style=\"width:40px; height:30px;\" />  </td>";
                             echo "<td> $alb->noticia_title  </td>";
                             echo "<td> $alb->noticia_data </td>";
                             ?>
                  <td>
                     <a class="with-tip edit" title="editar noticia" href="noticia.php?edit=<?= $alb->noticia_id ?>">
                     <i class="glyphicon glyphicon-pencil"></i>
                     </a>
                     &nbsp;
                     <a class="with-tip edit" title="editar noticia" href="noticia.php?delete=<?= $alb->noticia_id ?>" onclick="return confirm('Confirmar exclusão de registro?');">
                     <i class="glyphicon glyphicon-remove"></i>
                     </a>
                  </td>
                  <?php
                     echo "</tr>";
                     }
                     }
                     ?>
            </table>
            <div class="panel-body">
               <?echo $db->link ;?>
            </div>
         </div>
      </div>
      <?php
         }
         ?>
      <?php
         if ( isset( $_GET['ok'] ) )
         {
             echo "<script>notify('<h1>Procedimento Realizado!</h1>')</script>";
         }
         ?>
   </body>
</html>
