<?php
require_once '../database/mysql.php';
require_once '../class/Session.class.php';


if ( isset( $_GET['logout'] ) && !empty( $_GET['logout'] ) )
{
    $sid = new Session;
    $sid->start();
    $sid->destroy();
}

if ( isset( $_POST['user_login'] ) && isset( $_POST['user_password'] ) && !empty( $_POST['user_login'] ) && !empty( $_POST['user_password'] ) )
{
    extract( $_POST );
    $db = new Mysql;
    $user_password = md5( $_POST['user_password'] );
    $db->query( "select * from users where user_login = '$user_login' and user_password = '$user_password'" )->fetchAll();
    if ( $db->rows >= 1 )
    {
        $sid = new Session;
        $sid->start();
        $sid->init( 36000 );
        $sid->addNode( 'start', date( 'd/m/Y - h:i' ) );
        $sid->addNode( 'user_id', $db->data[0]['user_id'] );
        $sid->addNode( 'user_login', $db->data[0]['user_login'] );
        @header( 'Location: index.php' );
    }
    else
    {
        ?>

        <script>
        alert("Seu usuario ou senha estao errados, entre em contato com a administracao");

        </script>

        <?php
    }
}
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>JDI - OSKI</title>
    <link href="css/hover.css" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style media="screen">
        body
  {
      background: url('img/mesa2.jpg') no-repeat center center fixed;
      background-size: cover;
      padding: 0;
      margin: 0;
  }

  .btn-success {
    color: #fff;
    background-color: #61C5B9;
    border-color: #0F8476;
}
.btn-success:hover {
  color: #fff;
  background-color: #368C81;
  border-color: #68BDB3;
}

  .wrap
  {
      width: 100%;
      height: 100%;
      min-height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 99;
  }

  p.form-title
  {
      font-family: 'Open Sans' , sans-serif;
      font-size: 20px;
      font-weight: 600;
      text-align: center;
      color: #FFFFFF;
      margin-top: 5%;
      text-transform: uppercase;
      letter-spacing: 4px;
  }

  form
  {
      width: 250px;
      margin: 0 auto;
  }

  form.login input[type="text"], form.login input[type="password"]
  {
      width: 100%;
      margin: 0;
      padding: 5px 10px;
      background: 0;
      border: 0;
      border-bottom: 1px solid #FFFFFF;
      outline: 0;
      font-style: italic;
      font-size: 12px;
      font-weight: 400;
      letter-spacing: 1px;
      margin-bottom: 5px;
      color: #FFFFFF;
      outline: 0;
  }

  form.login input[type="submit"]
  {
      width: 100%;
      font-size: 14px;
      text-transform: uppercase;
      font-weight: 500;
      margin-top: 16px;
      outline: 0;
      cursor: pointer;
      letter-spacing: 1px;
  }

  form.login input[type="submit"]:hover
  {
      transition: background-color 0.5s ease;
  }

  form.login .remember-forgot
  {
      float: left;
      width: 100%;
      margin: 10px 0 0 0;
  }
  form.login .forgot-pass-content
  {
      min-height: 20px;
      margin-top: 10px;
      margin-bottom: 10px;
  }
  form.login label, form.login a
  {
      font-size: 12px;
      font-weight: 400;
      color: #FFFFFF;
  }

  form.login a
  {
      transition: color 0.5s ease;
  }

  form.login a:hover
  {
      color: #2ecc71;
  }

  .pr-wrap
  {
      width: 100%;
      height: 100%;
      min-height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 999;
      display: none;
  }

  .show-pass-reset
  {
      display: block !important;
  }

  .pass-reset
  {
      margin: 0 auto;
      width: 250px;
      position: relative;
      margin-top: 22%;
      z-index: 999;
      background: #FFFFFF;
      padding: 20px 15px;
  }

  .pass-reset label
  {
      font-size: 12px;
      font-weight: 400;
      margin-bottom: 15px;
  }

  .pass-reset input[type="email"]
  {
      width: 100%;
      margin: 5px 0 0 0;
      padding: 5px 10px;
      background: 0;
      border: 0;
      border-bottom: 1px solid #000000;
      outline: 0;
      font-style: italic;
      font-size: 12px;
      font-weight: 400;
      letter-spacing: 1px;
      margin-bottom: 5px;
      color: #000000;
      outline: 0;
  }

  .pass-reset input[type="submit"]
  {
      width: 100%;
      border: 0;
      font-size: 14px;
      text-transform: uppercase;
      font-weight: 500;
      margin-top: 10px;
      outline: 0;
      cursor: pointer;
      letter-spacing: 1px;
  }

  .pass-reset input[type="submit"]:hover
  {
      transition: background-color 0.5s ease;
  }
  .posted-by
  {
      position: absolute;
      bottom: 26px;
      margin: 0 auto;
      color: #FFF;
      background-color: rgba(0, 0, 0, 0.66);
      padding: 10px;
      left: 45%;
  }
.hvr-bounce-to-bottom:before {
  background-color: #61ACC5 !important;
}
input,
textarea {
    padding: 10px;
    display: block;
    width: 70%;
}

::-webkit-input-placeholder {
   color: orange !important;
}

:-moz-placeholder {
   color: orange !important;
}

::-moz-placeholder {
   color: orange !important;
}

:-ms-input-placeholder {
   color: orange !important;
}
        </style>
  </head>
  <body>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pr-wrap">
                    <div class="pass-reset">
                        <input type="email" placeholder="Email" />
                        <input type="submit" value="Submit" class="pass-reset-submit btn btn-success btn-sm" />
                    </div>
                </div>
                <div class="wrap">
                    <p class="form-title">Entrar no Sistema</p>
                    <form class="login form" action="login.php" method="post">
                      <div class="form-group">
                        <input type="text"  class="hvr-grow" placeholder="Usuário" required data-validation-required-message="O do usuário é obrigatório" autofocus name="user_login" id="user_login">
                        <input type="password" class="hvr-grow" placeholder="Senha" required data-validation-required-message="O de senha é obrigatório" name="user_password" id="user_password">
                      </div>
                    <button type="submit" value="Entrar" class="btn btn-success btn-block hvr-bounce-to-bottom hvr-bob">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
  </body>
</html>
