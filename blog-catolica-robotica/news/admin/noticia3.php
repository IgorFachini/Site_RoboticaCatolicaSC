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
    $body .= "\t<textarea id=\"noticia_content\" class=\"redac\" name=\"noticia_content\" style=\"height: 130px; width:500px !important\">$val</textarea>\n";
    @header( 'Content-Type: text/html; charset=utf-8' );
    return trim( $body );
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>..:Painel Administrativo:..</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link href="tpl/css/all.css" rel="stylesheet" type="text/css">
        <link href="tpl/css/960_12.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="redactor/api/css/redactor.css" />
        <link href="tpl/css/simple-lists.css" rel="stylesheet" type="text/css">
        <link href="tpl/css/reset.css" rel="stylesheet" type="text/css">
        <link href="tpl/css/common.css" rel="stylesheet" type="text/css">
        <link href="tpl/css/standard.css" rel="stylesheet" type="text/css">
        <link href="tpl/css/form.css" rel="stylesheet" type="text/css" />
        <link href="tpl/css/simple-lists.css" rel="stylesheet" type="text/css" />
        <link href="tpl/css/block-lists.css" rel="stylesheet" type="text/css" />
        <link href="tpl/css/table.css" rel="stylesheet" type="text/css" />
        <link href="../css/admin.css" rel="stylesheet" type="text/css" />
        <style media="screen">
        </style>
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
    </head>
    <body>
        <div id="wrap" class="container_12">
            <div class="grid_12">
                <p>&nbsp;</p>
                <div class="block-border">
                        <div class="block-controls" style="margin-top:2px;margin-left: 2px; width: 890px">
                            <ul class="controls-tabs js-tabs with-children-tip">
                                <li class="current"><a href="noticia.php" title="Noticias">
                                        <img src="tpl/images/icons/news.png" width="24" height="24"></a>
                                </li>
                                <li><a href="calendario.php" title="Agenda">
                                        <img src="tpl/images/icons/calendario.png" width="24" height="24"></a>
                                </li>
                                <li><a href="usuario.php" title="Usuarios">
                                        <img src="tpl/images/icons/users.png" width="24" height="24"></a>
                                </li>
                                <li><a href="login.php?logout=true" title="Sair">
                                        <img src="tpl/images/icons/logout-gray.png" width="24" height="24"></a>
                                </li>
                            </ul>
                        </div>
                        <div id="home" style="min-height: 675px !important; overflow-y:auto !important;">
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
                                    <div class="box-album">
                                        <ul class="box-album-head" style="width: 101%; margin:0; margin-bottom: 20px; padding: 0 !important">
                                            <div class="box-album">
                                                <form action="noticia.php?update=true" method="post" class="form" enctype="multipart/form-data">
                                                    <ul class="box-album-head" style="width: 101%; margin:0; margin-bottom: 20px; padding: 0 !important">
                                                        <fieldset class="grey-bg inline-label">
                                                            <legend>Detalhes da Noticia</legend>
                                                            <p>
                                                                <label for="noticia_title">Titulo da Noticia</label>
                                                                <input required="true" type="text" name="noticia_title" value="<?= $noticia_title ?>" id="noticia_title" />
                                                            </p>
                                                        </fieldset>
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
                                                        <p>
                                                            <label for="noticia_foto">Alterar Midia da Noticia</label>
                                                            <input type="file" name="noticia_foto" id="noticia_foto"
                                                                   style="width: 400px;" />
                                                        </p>
                                                        <? if ( $noticia_foto != "" )
                                                        { ?>
                                                            <p>
                                                                <label for="fo">Imagem Atual</label>
                                                                <img src="../fotos/<?= $noticia_foto ?>" style="width: 200px; height: 120px" />
                                                            </p>
                                                            <input type="hidden" name="noticia_atual" id="noticia_atual"  value="<?= $noticia_foto ?>"/>
                                                        <? } ?>
                                                        <input type="hidden" name="noticia_id" id="noticia_id"  value="<?= $noticia_id ?>"/>
                                                        <p style="text-align: center; margin-top:20px;">
                                                            <button class="grey" style="margin-left: 30px;">Atualizar Noticia</button>
                                                        </p>

                                                    </ul>
                                                </form>
                                            </div>
                                        </ul>
                                        <?php
                                    }
                                    echo "</div>";
                                }
                                else
                                {
                                    $editor = editor( '' );
                                    ?>
                                    <div class="box-album">
                                        <form name="f" action="noticia.php?create=true" method="post" class="form"
                                              onsubmit="return validaUp()" enctype="multipart/form-data">
                                            <ul class="box-album-head" style="width: 101%; margin:0; margin-bottom: 20px; padding: 0 !important">

                                                <fieldset class="">
                                                    <p>
                                                        <input placeholder="Titulo da noticia" type="text" name="noticia_title" id="noticia_title" />
                                                    </p>
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
                                                <p style="text-align: right">
                                                    <button class="btn btn-lg btn-primary btn-block"  style="margin-left: 30px;">Cadastrar Noticia</button>
                                                </p>

                                            </ul>
                                        </form>
                                    </div>

                                    <table class="table w-all" id="tbl_list_serv" style="width: 100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th width="10">ID</th>
                                                <th>Noticia</th>
                                                <th width="50">Data</th>
                                                <th width="50">Menu</th>
                                            </tr>
                                        </thead>
                                        <tbody class="sortableBanner">
                                            <?php
											$db->paginate(3);
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
                                                        <img src="tpl/images/pencil.png" width="16" height="16">
                                                    </a>
                                                    &nbsp;
                                                    <a class="with-tip deleteNoticia" title="remover noticia"  id="<?= $alb->noticia_id ?>" href="javascript:void(0)">
                                                        <img src="tpl/images/cross-circle.png" width="16" height="16">
                                                    </a>
                                                </td>

                                                <?php
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </table>
									<style>
										.pagination li{
											display:inline-block;
											float:left;
											padding:4px 6px;
										}
									</style>
									<?echo $db->link ;?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <p id="footer">&nbsp;</p>
            <?php
            if ( isset( $_GET['ok'] ) )
            {
                echo "<script>notify('<h1>Procedimento Realizado!</h1>')</script>";
            }
            ?>
    </body>
</html>
