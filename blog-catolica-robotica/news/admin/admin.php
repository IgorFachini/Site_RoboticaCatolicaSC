<?php
include "sql.php";
$sql = mysql_query("DELETE FROM agenda WHERE id = '$id'");
if($sql){
    header("location:calendario.php");
}else{
    print "Não foi possivel deletar!";
}
?>
<?php
include "sql.php";
if(isset($_POST['done'])){
    $evento = $_POST['evento'];
    $dtevento = $_POST['dia']."-".$_POST['mes']."-".$_POST['ano'];
    $autor = $_POST['autor'];
	  $hora = $_POST['hora'];
	  $local = $_POST['local'];
    $conteudo = $_POST['conteudo'];
    if(empty($evento) || empty($dtevento) || empty($conteudo) || empty($local)){
        $erro = "Opa, voce deve preencher todos os campos";
    }else{
       $sql = mysql_query("INSERT INTO `agenda`(`evento`, `dtevento`, `autor`, `hora`, `local`, `conteudo`) VALUES ('$evento', '$dtevento', '$autor', '$hora', '$local', '$conteudo')") or die(mysql_error());
            if($sql){
                $erro = "Dados cadastrados com sucesso!";
              } else{
                  $erro = "Nao foi possivel cadastrar os dados";
              }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agenda de Eventos</title>
<style type="text/css">
.campo{
width:400px;
}
.tabela{
background:#fff;
width:200px;
padding:0px;
border:1px solid #f0f0f0;
float:left;
margin-right:20px;
}
.td{
background:#f8f8f8;
width:20px;
height:20px;
text-align:center;
}
.hj{
background: #FFFFCC;
width:20px;
height:20px;
text-align:center;
}
.dom{
background: #FFCC99;
width:20px;
height:20px;
text-align:center;
}
.evt{
background: #CCFF99;
width:20px;
height:20px;
text-align:center;
}
.mes{
background:#fff;
width:auto;
height:20px;
text-align:center;
}
.show{
background:#202020;
width:300px;
height:30px;
text-align:left;
font-size:12px;
font-weight:bold;
color:#CCFF00;
padding-left:5px;
}
.linha{
background:#404040;
width:300px;
height:20px;
text-align:left;
font-size:11px;
color:#f0f0f0;
padding:1px 1px 1px 10px;
}
.sem{
background: #ECE6D9;
width:auto;
height:20px;
text-align:center;
font-size:12px;
font-weight:bold;
font-family:Verdana;
}
#mostrames{
width:300px;
padding:5px;
}
body,td,th {
    font-family: Verdana;
    font-size: 11px;
    color: #000000;
}
a:link {
    color: #000000;
    text-decoration: none;
}
a:visited {
    text-decoration: none;
    color: #000000;
}
a:hover {
    text-decoration: underline;
    color: #FF9900;
}
a:active {
    text-decoration: none;
}
</style>
</head>
<body>
<form name="form1" action="admin.php" method="POST" style="padding-top:40px;">
<?php
if(isset($erro)){
    print '<div style="width:80%; background:#ff6600; color:#fff; padding: 5px 0px 5px 0px; text-align:center; margin: 0 auto;">'.$erro.'</div>';
}
?>
<table border="0" width="80%"  bgcolor="#f0f0f0" style="border:1px solid #ccc; margin:0 auto; position:relative;">
<thead>
<tr>
<th colspan="2">.:: Inserir Evento no Calendário ::.</th>
</tr>
</thead>
<tbody>
<tr>
<td width="20%">Evento:</td>
<td width="auto"><input type="text" name="evento" value="" class="campo" id="evento" /></td>
</tr>
<tr>
<td>Autor:</td>
<td><input name="autor" type="text" class="campo" id="autor" /></td>
</tr>
<tr>
<td>Data Evento:</td>
<td><select name="dia">
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
<select name="mes" >
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
<select name="ano" >
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
  </select></td>
</tr>
<tr>
  <td>Hora:</td>
  <td><input name="hora" type="text" class="campo" id="hora">
    (hh:mm)</td>
</tr>
<tr>
<td>Local:</td>
<td><input name="local" type="text" class="campo" id="local"></td>
</tr>
<tr>
<td valign="top">Descricão:</td>
<td><textarea name="conteudo" rows="8" class="campo" >
</textarea></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Cadastrar Evento" /><input type="hidden" name="done" value="" /></td>
</tr>
</tbody>
</table>
</form>
	<div style="margin:10px auto; width:70%; padding:5px 0px 5px 0px;">
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
print "Listando a página ".$pagina." de ".$total_paginas."!";
$sqln = mysql_query("SELECT * FROM agenda ORDER BY id DESC LIMIT ".$inicio.",".$max."");
$num = mysql_num_rows($sqln);
}
?>
	 </div>
<fieldset style="width:76%; margin:0 auto;">
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
  print '<td align="center"><a href="deletagenda.php?id='.$id.'">Excluir</a></td>';
  print '</tr>';
  }
 print '</table>';
 print '<div style="text-align:center; margin-top: 30px;">';
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
</fieldset>
</body>
</html>
