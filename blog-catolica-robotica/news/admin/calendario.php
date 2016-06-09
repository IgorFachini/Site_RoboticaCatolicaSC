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

        $pxMax = 300;
        $pyMax = 200;

        $rxMax = 200;
        $ryMax = 350;
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
			$pxMax = 300;
			$pyMax = 200;
			//Configuracoes de redimensionamento retrato
			$rxMax = 200;
			$ryMax = 300;

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
    $body .= "\t<textarea id=\"noticia_content\" class=\"form-control\" name=\"conteudo\" style=\"height: 130px; width:500px !important\">$val</textarea>\n";
    //<textarea name="conteudo" rows="8" class="campo"></textarea>

    @header( 'Content-Type: text/html; charset=UTF-8' );
    return trim( $body );
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Agenda</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="css/zica.css" media="screen" title="no title" charset="utf-8">
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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
                                                <li ><a href="noticia.php" title="Noticias">
                                                  <i class="glyphicon glyphicon-file"></i> Noticia

                                                 </a>
                                                </li>
                                                <li class="active"><a href="calendario.php" title="Agenda">
                                                  <i class="glyphicon glyphicon-book"></i> Agenda

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

                        <div id="home">
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
                                    $noticia_foto = $db->data[0]['noticia_foto'];
                                    $noticia_id = $db->data[0]['noticia_id'];
                                    if ( $noticia_content == '0' )
                                    {
                                        $noticia_content = "";
                                    }
                                    $editor = editor( $noticia_content );
                                    ?>
                                        </ul>
                                        <?php
                                    }
                                    echo "</div>";
                                }
                                else
                                {
                                    $editor = editor( '' );
                                    ?>

<div class="container">
  <div class="form-box box-album"  style="padding-top:4.1em;">
     <div class="form-top">
        <div class="form-top-left">
           <h3>Cadastrar Evento</h3>
           <p></p>
        </div>
        <div class="form-top-right">
           <i class="fa fa-pencil"></i>
        </div>
     </div>
  <form name="form1" action="admin.php" method="POST" class="form-bottom">
  <?php
  if(isset($erro)){
      print '<div style="width:80%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center;">'.$erro.'</div>';
  }
  ?>
  <div class="form-group">
    <input type="text" name="evento" value="" class="form-control" id="Evento" placeholder="Evento"required="required"/>
  </div>
  <div class="form-group">
    <input name="autor" type="text" class="form-control" id="autor" placeholder="Autor"required="required"/>
  </div>
<div class="form-group ">
  <select name="dia" class="form-horizontal input-sm">
    <option value="" selected disabled>Por favor, Selecione o dia</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
      <option>13</option>
      <option>14</option>
      <option>15</option>
      <option>16</option>
      <option>17</option>
      <option>18</option>
      <option>19</option>
      <option>20</option>
      <option>21</option>
      <option>22</option>
      <option>23</option>
      <option>24</option>
      <option>25</option>
      <option>26</option>
      <option>27</option>
      <option>28</option>
      <option>29</option>
      <option>30</option>
      <option>31</option>
  </select>
  <select name="mes" class="form-horizontal input-sm">
    <option value="" selected disabled>Por favor, Selecione o mês</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
      <option>6</option>
      <option>7</option>
      <option>8</option>
      <option>9</option>
      <option>10</option>
      <option>11</option>
      <option>12</option>
  </select>
  <select name="ano" class="form-horizontal input-sm">
    <option value="" selected disabled>Por favor, Selecione o ano</option>
          <option>2015</option>
          <option>2016</option>
          <option>2017</option>
          <option>2018</option>
          <option>2019</option>
          <option>2020</option>
          <option>2021</option>
          <option>2023</option>
          <option>2024</option>
          <option>2025</option>
          <option>2026</option>
          <option>2027</option>
          <option>2028</option>
          <option>2029</option>
          <option>2030</option>
    </select>
</div>

      <div class="form-group">
        <input name="hora" type="time" class="form-control" id="hora" placeholder="Horario (HH:MM)" required="required">
      </div>
<div class="form-group">
  <input name="local" type="text" class="form-control" id="local" placeholder="Local" required="required">

</div>
   <div class="form-group">
        <?= $editor ?>
    </div>
    <script>
        window.onload = function()
        {
            $('#noticia_content').redactor();
        }
    </script>
    <div class="form-group">
      <input class="btn btn-lg btn-primary btn-block" type="submit" value="Cadastrar Evento" /><input type="hidden" name="done" value="" />
    </div>
  </form>
</div>
</div>

<!-- que -->

  	<div class="container">

    <?php
    print '<div class="panel panel-default">';
    print'<div class="panel-heading">Painel Agenda</div>
 <div class="panel-body">
    <p>Ultimos Eventos </p>';
    include "sql.php";
    $max = 11;
    $pagina = $_GET['pagina'];
    if(!$pagina){
    	$inicio = 0;
    	$pagina = 1;
    }else{
    $inicio = ($pagina - 1) * $max;
    }
    $sqln = mysql_query("SELECT * FROM agenda ORDER BY id DESC");
    $num = mysql_num_rows($sqln);
    if($num == 0){
    print "Até o momento não temos nenhum evento agendado";
    }else{
    $total_paginas = ceil($num/$max);
    print  "Temos ".$num."  eventos cadastrados no site.<br>";
    print "Listando a página ".$pagina." de ".$total_paginas."!";
    $sqln = mysql_query("SELECT * FROM agenda ORDER BY id DESC LIMIT ".$inicio.",".$max."");
    $num = mysql_num_rows($sqln);
    }


 print'</div>';
    print '<table class="table table-striped table-hover table-responsive" id="tbl_list_serv"cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Ações</th>
        </tr>
    </thead>';
    for($i = 0; $i < $num; $i++){
    $evento = @mysql_result($sqln, $i, "evento");
    $id = @mysql_result($sqln, $i, "id");
    $n = $i + 1;
    $d = $i % 2;
    if($d == 0){$cor = "cinza";}else{$cor = "claro"; }
    print '<tr>';
    print '<td>'.$n.'</td>';
    print '<td>'.$evento.'</td>';
    print '<td><a href="atualagenda.php?id='.$id.'"><i class="glyphicon glyphicon-pencil">&nbsp;</i></a>';
    print '<a href="deletagenda.php?id='.$id.'"><i class="glyphicon glyphicon-remove"></i></a></td>';
    print '</tr>';
    }
   print '</table>';
   print '</div>';

   print '<div>';
  if($pagina != 1){
  print '<a href="listagenda.php?'. $_SERVER['QUERY_STRING']. "&pagina=".($pagina - 1).'"><< anterior</a>';
  }else{
      print '<span style="color: #ccc;"><< anterior </span>';
  }
  if ($total_paginas > 1){
      for ($i=1; $i <= $total_paginas; $i++){
         if ($pagina == $i){
            echo "<span class='al'> [".$pagina."] </span>";
         }else{
            echo "<a href=\"listagenda.php?" . $_SERVER['QUERY_STRING']."&pagina=".$i."\">&nbsp;".$i."&nbsp;</a> ";
  		  }
      }
  }
  if($pagina < $total_paginas){
  print '<a href="listagenda.php?'. $_SERVER['QUERY_STRING']. "&pagina=".($pagina + 1).'">próxima >></a>';
  }else{
      print '<span style="color: #ccc;"> próxima >></span>';
  }
  print '</div>';
    ?>
									<?echo $db->link ;?>
                                <?php
                            }
                            ?>
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
          </div>

    </body>
</html>
