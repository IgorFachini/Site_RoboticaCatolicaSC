<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"/>
<title>Agenda de Eventos</title>
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<style>
.imgT{
	width: 25px;
	border: 0;
	padding: 0;
}
img{
float: left;
 width: 15%;
 border: thin solid;
 padding: 5px;
 margin: 0px 10px 10px 0;

}

body {
font: 87.5%/1.5em 'Lato', sans-serif;
}
.calendar-container {
position: relative;
width: 450px;
}
.calendar {
  font: 87.5%/1.5em 'Lato', sans-serif;
background: #708090;
border-radius: 0 0 1em 1em;
-webkit-box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
color: #555;
display: inline-block;
padding: 2em;
}

.calendar td {
padding: .5em 1em;
text-align: center;
}

.calendar tbody td:hover {
background: #B0C4DE;
color: #fff;
}

/*
novo

*/
.tabela{
background:#fff;
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
background: #CD5C5C;
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
  background: #e66b6b;
  color: #fff;
  padding: 3em 2em;
}
.show{
  font: 87.5%/1.5em 'Lato', sans-serif;

-webkit-box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
background:#6B809B;
width:auto;
height:30px;
text-align:left;
font-size:20px;
font-weight:bold;
color:white;
padding-left:5px;
}
.linha{
  font:'Lato', sans-serif;

  -webkit-box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
  box-shadow: 0 2px 1px rgba(0, 0, 0, .2), 0 3px 1px #fff;
background:#808080;
width:auto;
height:20px;
text-align:left;
font-size:14px;
color:#f0f0f0;
padding:1px 1px 1px 10px;
}
.sem{
background: #6B809B;
color:white;
width:auto;
height:20px;
text-align:center;
font-size:12px;
font-weight:bold;
font-family:Verdana;
}
#mostrames{
width:auto;
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

<?php

include "sql.php";
@mysql_select_db($db);
if(empty($_GET['data'])){
    $dia = date('d');
    $month =ltrim(date('m'),"0");
    $ano = date('Y');
}else{
    $data = explode('/',$_GET['data']);//nova data
    $dia = $data[0];
    $month = $data[1];
    $ano = $data[2];
}
if($month==1){
    $mes_ant = 12;
    $ano_ant = $ano - 1;
}else{
    $mes_ant = $month - 1;
    $ano_ant = $ano;
}
if($month==12){
    $mes_prox = 1;
    $ano_prox = $ano + 1;
}else{
    $mes_prox = $month + 1;
    $ano_prox = $ano;
}
$hoje = date('j');
switch($month.$n){
    case 1: $mes = "JANEIRO";
            $n = 31;
    break;
    case 2: $mes = "FEVEREIRO";
            $bi = $ano % 4;
            if($bi == 0){
                $n = 29;
            }else{
                $n = 28;
            }
    break;
    case 3: $mes = "MARÇO";
            $n = 31;
    break;
    case 4: $mes = "ABRIL";
            $n = 30;
    break;
    case 5: $mes = "MAIO";
            $n = 31;
    break;
    case 6: $mes = "JUNHO";
            $n = 30;
    break;
    case 7: $mes = "JULHO";
            $n = 31;
    break;
    case 8: $mes = "AGOSTO";
            $n = 31;
    break;
    case 9: $mes = "SETEMBRO";
            $n = 30;
    break;
    case 10: $mes = "OUTUBRO";
            $n = 31;
    break;
    case 11: $mes = "NOVEMBRO";
            $n = 30;
    break;
    case 12: $mes = "DEZEMBRO";
            $n = 31;
    break;
}
$pdianu = mktime(0,0,0,$month,1,$ano);
$dialet = date('D', $pdianu);
switch($dialet){
    case "Sun": $branco = 0; break;
    case "Mon": $branco = 1; break;
    case "Tue": $branco = 2; break;
    case "Wed": $branco = 3; break;
    case "Thu": $branco = 4; break;
    case "Fri": $branco = 5; break;
    case "Sat": $branco = 6; break;
}
    print '<table class="tabela calendar" cellspacing="0" cellpadding="0">';
    print '<tr>';
    print '<td class="mes"><a href="?data='.$dia.'/'.$mes_ant.'/'.$ano_ant.'" title="Mes anterior">  &laquo; </a></td>';/*m�s anterior*/
    print '<td class="mes" colspan="5">'.$mes.'  -  '.$ano.'</td>';/*mes atual e ano*/
    print '<td class="mes"><a href="?data='.$dia.'/'.$mes_prox.'/'.$ano_prox.'" title="Proximo mes">  &raquo; </a></td>';/*Proximo m�s*/
    print '</tr><tr>';
    print '<td class="sem">D</td>';//printar os dias da semana
    print '<td class="sem">S</td>';
    print '<td class="sem">T</td>';
    print '<td class="sem">Q</td>';
    print '<td class="sem">Q</td>';
    print '<td class="sem">S</td>';
    print '<td class="sem">S</td>';
    print '</tr><tr>';
    $dt = 1;
    if($branco > 0){
        for($x = 0; $x < $branco; $x++){
             print '<td>&nbsp;</td>';
            $dt++;
        }
    }
    for($i = 1; $i <= $n; $i++ ){
            $dtevento = $i."-".$month."-".$ano;
        $sqlag = mysql_query("SELECT * FROM agenda WHERE dtevento = '$dtevento'") or die(mysql_error());
                $num = mysql_num_rows($sqlag);
                $idev = @mysql_result($sqlag, 0, "dtevento");
                $eve = @mysql_result($sqlag, 0, "evento");
                if($num > 0){
           print '<td class="evt">';
           print '<a href="?d='.$idev.'&data='.$dia.'/'.$month.'/'.$ano.'" title="'.$eve.'">'.$i.'</a>';
           print '</td>';
           $dt++;
                   $qt++;
        }elseif($i == $hoje){
            print '<td class="hj">';
            print $i;
            print '</td>';
            $dt++;
        }elseif($dt == 1){
            print '<td class="dom">';
            print $i;
            print '</td>';
            $dt++;
        }else{
            print '<td class="td">';
            print $i;
            print '</td>';
            $dt++;
                }
        if($dt > 7){
        print '</tr><tr>';
        $dt = 1;
        }
    }
    print '</tr>';
    print '</table>';
        if($qt > 0){
          print '<p>Temos  evento(s) em '. strtolower($mes). '</p>';

        }
if(isset($_GET['d'])){
    $idev = $_GET['d'];
    $sqlev = mysql_query("SELECT * FROM agenda WHERE dtevento = '$idev' ORDER BY hora ASC") or die(mysql_error());
    $numev = mysql_num_rows($sqlev);
    for($j = 0; $j < $numev; $j++){/*caso no mesmo dia tenha mais eventos continua imprimindo */
    $eve = @mysql_result($sqlev, $j, "evento");/*pegando os valores do banco referente ao evento*/
    $dev = @mysql_result($sqlev, $j, "dtevento");
    $dsev = @mysql_result($sqlev, $j, "conteudo");
    $auev = @mysql_result($sqlev, $j, "autor");
    $lev = @mysql_result($sqlev, $j, "local");
    $psev = @mysql_result($sqlev, $j, "data");
    $nowev = date('d/m/Y - H:i', strtotime($psev));/*Converte padrao brazil*/
    $hev = @mysql_result($sqlev, $j, "hora");
print '<table width="50%" cellspacing="0" cellpadding="0" class="lugar">';
print '<tr><td class="show">'.$dev.' - '.$eve.'</td></tr>';
print '<tr><td class="linha"><b>Hora: </b>'.$hev.'hs</td></tr>';
print '<tr><td class="linha"><b>Local: </b>'.$lev.'</td></tr>';
print '<tr><td class="linha"><b>Descrição: </b>'.nl2br($dsev).'</td></tr>';
print '<tr><td class="linha"><b>Postado: </b><small>'.$nowev.'</small></td></tr>';
print'
<tr><td class="linha">
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="addthis_native_toolbox"></div>
</td></tr>';
print '</table>';
print '<br>';
    }
}

?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55ca9230567d076f" async="async"></script>
</script>
</body>
</html>
