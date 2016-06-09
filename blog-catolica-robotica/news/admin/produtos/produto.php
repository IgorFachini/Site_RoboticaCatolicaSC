<?php
include("cabecalho.php");
include("../class/produto.class.php");

//buscar os meus registros
$produto = new Produto();
$lista = $produto->listar();
$conteudotabela="";

foreach($lista as $item)
{
    $codigo = $item->codigo;
    $titulo = $item->titulo;
    $quant = $item->quant;
    $preco = $item->preco;
    //adiciono ao meu html 
    $moeda = "US";
    $conteudotabela.= "<tr>
            <td>$codigo</td>
            <td>$titulo</td>
            <td>$quant</td>
            <td>$moeda$preco</td>
            <td><a href='categoria-upd.php?id=$codigo'>
                    <img src='icones/edit.png' /></a>
                <a href='categoria-del.php?id=$codigo'>
                <img src='icones/delete.png' /></a>
            </td>
        </tr>";
    
}





?>







<br/><br/>

<h2>Produto</h2>

<br/><br/> &nbsp;
<p style="width:100px;"><a href="produto-add.php">
        <img src="icones/new.png" />Novo</a></p>
<table class="tbllista" style="width: 65%">
    <thead>
        <tr>
            <th>Código</th>
            <th>Título</th>
            <th>Quant.</th>
            <th>Preço</th>
            <th>Operações</th>
        </tr>
    </thead>
    <tbody>
            <?php echo $conteudotabela;?>
       
    </tbody>
</table>
</body>
</html>