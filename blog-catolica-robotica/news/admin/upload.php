<?php

require_once '../database/mysql.php';
require_once '../class/Session.class.php';
require_once '../class/Upload.class.php';
$db = new Mysql;
$sid = new Session;
$sid->start();

$file_dst_name = "";
$album_id = $_GET['album_id'];

$dir_dest = '../fotos';

$files = array( );
$files = $_FILES['Filedata'];

foreach ( $files as $file )
{
    $handle = new Upload( $file );
    if ( $handle->uploaded )
    {
        $handle->file_overwrite = true;
        $handle->image_convert = 'jpg';
        //Configuracoes de redimensionamento retrato
        $lMax = 2000; //largura maxima permitida
        $aMax = 1600; // altura maxima permitida
        //Configuracoes de redimensionamento paisagem
        $plMax = 1800; //largura maxima permitida
        $paMax = 1400; // altura maxima permitida


        if ( $handle->image_src_x > $handle->image_y )
        {
            if ( $handle->image_src_x > $lMax || $handle->image_y > $aMax )
            {
                $handle->image_resize = true;
                $handle->image_ratio = true;
                $handle->image_x = ($lMax / 2);
                $handle->image_y = ($aMax / 2);
            }
        }
        else
        {
            if ( $handle->image_src_x > $plMax || $handle->image_y > $paMax )
            {
                $handle->image_resize = true;
                $handle->image_ratio = true;
                $handle->image_x = ($plMax / 2);
                $handle->image_y = ($paMax / 2);
            }
        }

        $handle->file_new_name_body = md5( uniqid( $file['name'] ) );
        $handle->Process( $dir_dest );
        if ( $handle->processed )
        {
            $file_dst_name = $handle->file_dst_name;
            $foto_data = date( 'Y-m-d 00:00:00' );
            $db->query( "insert into fotos (foto_album,foto_url,foto_data,foto_pos) values ($album_id,'$file_dst_name','$foto_data','999');" );
            //$file_dst_name .= "?v=" . time();
            $last_id = mysql_insert_id();
            echo json_encode( array( 'url' => "$file_dst_name", 'id' => $last_id, 'time' => time() ) );
        }
        else
        {
            echo json_encode( array( 'url' => "error", 'id' => '', 'time' => time() ) );
        }
    }
    else
    {
        echo json_encode( array( 'url' => "error", 'id' => '', 'time' => time() ) );
    }
}
?>