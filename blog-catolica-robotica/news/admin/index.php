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
else{
@header( 'Location: noticia.php' );
}
?>
