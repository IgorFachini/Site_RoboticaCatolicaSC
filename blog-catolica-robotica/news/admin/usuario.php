<?php
   require_once '../database/mysql.php';
   require_once '../class/Session.class.php';
   $db = new Mysql;
   $sid = new Session;
   $sid->start();
   if ( !$sid->check() )
   {
       @header( 'Location: login.php' );
   }
   if ( isset( $_GET['action'] ) && $_GET['action'] == 'incluir' )
   {
       if ( isset( $_POST['user_login'] ) && !empty( $_POST['user_login'] ) && isset( $_POST['user_password'] ) && !empty( $_POST['user_password'] ) )
       {
           $user_password = md5( trim( $_POST['user_password'] ) );
           $user_login = trim( $_POST['user_login'] );
           $user_email = trim( $_POST['user_email'] );
           $db->query( "insert into users (user_login,user_password,user_email) values ('$user_login','$user_password','$user_email');" );
           @header( 'Location: usuario.php?success' );
       }
       else
       {
           @header( 'Location: usuario.php?error&action=novo' );
       }
   }

   if ( isset( $_GET['action'] ) && $_GET['action'] == 'atualiza' )
   {
       if ( isset( $_POST['user_login'] ) && !empty( $_POST['user_login'] ) )
       {
           $user_id = $_GET['id'];
           $user_login = trim( $_POST['user_login'] );
           $user_email = trim( $_POST['user_email'] );

           $cond = " set user_login = '$user_login', user_email = '$user_email' ";
           if ( isset( $_POST['user_password'] ) && $_POST['user_password'] != "" )
           {
               $user_password = md5( trim( $_POST['user_password'] ) );
               $cond .= ", user_password = '$user_password' ";
           }
           $db->query( "update users  $cond where user_id = $user_id" );
           @header( 'Location: usuario.php?success' );
       }
   }

   if ( isset( $_GET['action'] ) && $_GET['action'] == 'remove' )
   {
       if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) )
       {
           $user_id = $_GET['id'];
           $db->query( "delete from users where user_id = $user_id" );
           @header( 'Location: usuario.php?success' );
       }
   }

   if ( isset( $_GET['success'] ) )
   {
       echo "<script>window.onload = function(){notify('<h1>Dados Atualizados</h1>')}</script>";
   }
   if ( isset( $_GET['error'] ) )
   {
       echo "<script>window.onload = function(){notify('<h1>Informe todos os dados!</h1>')}</script>";
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>::Painel Administrativo::</title>
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
      <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" media="all" />
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <!-- Generic libs -->
      <script type="text/javascript" src="tpl/js/jquery-1.4.2.min.js"></script>
      <script type="text/javascript" src="tpl/js/html5.js"></script>
      <script type="text/javascript" src="tpl/js/old-browsers.js"></script>
      <!-- Template core functions -->
      <script type="text/javascript" src="tpl/js/common.js"></script>
      <script type="text/javascript" src="tpl/js/jquery.tip.js"></script>
      <script type="text/javascript" src="tpl/js/standard.js"></script>
      <link rel="stylesheet" href="css/zica.css" media="screen" title="no title" charset="utf-8">
      <!--[if lte IE 8]><script type="text/javascript" src="tpl/js/standard.ie.js"></script><![endif]-->
   </head>
   <body>
      <div id="wrap" class="container">
         <div class="grid_12">
            <p>&nbsp;</p>
            <div class="block-border">
               <div class="block-content">
                  <div class="container">
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
                                 <li><a href="calendario.php" title="Agenda">
                                    <i class="glyphicon glyphicon-book"></i> Agenda
                                    </a>
                                 </li>
                                 <li class="active"><a href="usuario.php" title="Usuarios">
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
                  </div>
                  <?php
                     if ( !isset( $_GET['action'] ) && !isset( $_GET['edit'] ) )
                     {
                         ?>
                  <div class="form-group" style="padding-top:25px;">
                     <a href="usuario.php?action=novo" class="btn btn-lg btn-primary btn-block"  title="Inclui colaborador do site">
                     Adicionar novo Usuário
                     </a>
                  </div>
                  <?php
                     }
                     else
                     {
                         ?>
                  <a href="usuario.php" class="with-tip"  title="Todos os Usuarios">
                  Voltar
                  </a>
                  <?php
                     }
                     ?>
                  <p>&nbsp;</p>
                  <?php
                     if ( isset( $_GET['action'] ) && $_GET['action'] == 'novo' )
                     {
                         ?>
                  <p>&nbsp;</p>
                  <!--Cadastro de Usuario -->
                  <div class="form-box">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Cadastrar Usuário</h3>
                           <p></p>
                        </div>
                        <div class="form-top-right">
                           <i class="fa fa-pencil"></i>
                        </div>
                     </div>
                     <form method="post" class="form-bottom" onsubmit="return valida()"
                        action="usuario.php?action=incluir">
                        <div class="form-group">
                           <input type="text" name="user_login" id="user_login" required="required" placeholder="Usuario" class="form-control">
                           </span>
                        </div>
                        <div class="form-group">
                           <input type="password" name="user_password" required="required" id="user_password" placeholder="Senha" class="form-control">
                        </div>
                        <div class="form-group">
                           <input type="email" name="user_email" id="user_email" class="form-control" placeholder="e-mail">
                        </div>
                        <div class="form-group">
                           <button class="btn btn-lg btn-primary btn-block">Cadastrar</button>
                        </div>
                     </form>
                  </div>
                  <?
                     }
                     elseif ( isset( $_GET['edit'] ) && !empty( $_GET['edit'] ) )
                     {
                         $user_id = $_GET['edit'];
                         $db->query( "select * from users where user_id = $user_id" )->fetchAll();
                         $u = ( object ) $db->data[0];
                         ?>
                  <!-- Atualizar -->
                  <div class=" form-box">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Atualizar Senha</h3>
                           <p></p>
                        </div>
                        <div class="form-top-right">
                           <i class="fa fa-pencil"></i>
                        </div>
                     </div>
                        <form method="post" class="form-bottom" onsubmit="return valida()"
                           action="usuario.php?action=atualiza&id=<?= $u->user_id ?>">
                           <div class="form-group">
                              <input type="text" disabled name="user_login" id="user_login" class="form-control" value="<?= $u->user_login ?>">
                           </div>
                           <div class="form-group">
                              <input type="password" name="user_password" required="required" id="user_password" class="form-control" autocomplete="off"
                                 placeholder="Alterar senha">
                           </div>
                           <div class="form-group">
                              <input type="text" class="form-control" name="user_email" id="user_email" size="50" value="<?= $u->user_email ?>">
                           </div>
                           <div class="form-group">
                              <button class="btn btn-lg btn-primary btn-block">Atualizar</button>
                           </div>
                        </form>
                  </div>
                  <?
                     }
                     else
                     {
                         $db->query( "select * from users order by user_login asc" )->fetchAll();
                         ?>
                  <div class="panel panel-default">
                     <div class="panel-heading">Painel Usuário</div>
                     <div class="panel-body">
                        <p>Usuários adicionados </p>
                     </div>
                     <table class="table table-striped table-hover table-responsive" id="tbl_list_serv" style="width: 100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Login</th>
                              <th>E-mail</th>
                              <th>Menu</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if ( $db->rows >= 1 )
                              {
                                  foreach ( $db->data as $user )
                                  {
                                      $u = ( object ) $user;
                                      echo "<tr>";
                                      echo "<td>$u->user_id</td>";
                                      echo "<td>$u->user_login</td>";
                                      echo "<td>$u->user_email</td>";
                                      echo "  <td> ";
                                      echo "<a class=\"with-tip edit\" title=\"editar usuario\" id=\"$u->user_id\" href=\"usuario.php?edit=$u->user_id\">";
                                      echo "<i class=\"glyphicon glyphicon-pencil\">&nbsp; </i>";
                                      echo "</a>";
                                      echo "<a class=\"with-tip delete\" title=\"remover usuario\"  id=\"$u->user_id\" href=\"usuario.php?action=remove&id=$u->user_id\">";
                                      echo "<i class=\"glyphicon glyphicon-remove \"></i>";
                                      echo "</a>";
                                      echo "</td>";
                                      echo "</tr>";
                                  }
                              }
                              }
                              ?>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
