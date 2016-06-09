<?phprequire_once '../database/mysql.php';require_once '../class/Session.class.php';$db = new Mysql;$sid = new Session;$sid->start();if ( !$sid->check() ){    @header( 'Location: login.php' );}?><!DOCTYPE html><html lang="pt-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agenda de Eventos</title>
<style type="text/css">
.cinza{
background:#f0f0f0;
height:20px;
}
.claro{
background:#f9f9f9;
height:20px;
}
.fonte{
color:#FFFFFF;
font-weight:bold;
height:25px;
}
</style>
</head>
<body>
	<div style="margin:10px auto; width:90%; padding:5px 0px 5px 0px;">
<?php
include "sql.php";
$max = 10;
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
print "Lisando a página ".$pagina." de ".$total_paginas."!";
$sqln = mysql_query("SELECT * FROM agenda ORDER BY id DESC LIMIT ".$inicio.",".$max."");
$num = mysql_num_rows($sqln);
}
?>
	 </div>
<fieldset style="width:90%; margin:0 auto;">
<legend>Eventos Agendados</legend>
  <?php
  print '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" align="center" bgcolor="#202020" class="fonte">Nr</td>
    <td align="center" bgcolor="#202020" class="fonte">Titulo</td>
    <td colspan="2" align="center" bgcolor="#202020" class="fonte" width="15%">Ações</td>
  </tr>';
  for($i = 0; $i < $num; $i++){
  $evento = @mysql_result($sqln, $i, "evento");
  $id = @mysql_result($sqln, $i, "id");
  $n = $i + 1;
  $d = $i % 2;
  if($d == 0){$cor = "cinza";}else{$cor = "claro"; }
  print '<tr class='.$cor.'>';
  print '<td align="center">'.$n.'</td>';
  print '<td>'.$evento.'</td>';
  print '<td align="center"><a href="atualagenda.php?id='.$id.'">Altualizar</a></td>';
  print '<td align="center"><a href="deletagenda.php?id='.$id.'">Excluir</a></td>';  print '</tr>';
  }
  print '</table>';
 print '<div style="text-align:center; margin-top: 30px;">';
if($pagina != 1){
print '<a href="listagenda.php?'. $_SERVER['QUERY_STRING']. "&pagina=".($pagina - 1).'"><< anterior</a>';}else{
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
</fieldset>
</body>
</html>
