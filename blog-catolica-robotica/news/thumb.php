<?php

require_once 'class/Canvas.class.php';
$marca = "images/marca_p.png";
if ( isset( $_GET['img'] ) ):
    $pic = $_GET['img'];
    $w = 130; //largura
    $h = 100; //altura
	if ( isset( $_GET['w'] ) ): 
		$w = $_GET['w'];
	endif;
	if ( isset( $_GET['h'] ) ):
		$h = $_GET['h'];
	endif;
    $t = new Canvas;
    $t->carrega( $pic );
    $t->redimensiona( $w, $h );
    //$t->marca( $marca, 'baixo','direita' );
    $t->grava();
endif;
?>