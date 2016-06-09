<?php
include("cabecalho.php");
include_once "../class/Upload.class.php";

//Instancia a classe passando o arquivo (atributo name no form).
if(isset($_FILES["imagem"]))
{
    $dir_dest = "../upload";
    $upload = new Upload($_FILES['imagem'], $dir_dest);

    // verifica se foi realizado corretamente o upload
    if ($upload->processed) {

        echo "UPLOAD REALIZADO<br>";
    }
}


//para pegar o nome do arquivo do upload
//$handle->file_dst_name
//$retorno = $categoria->inserir();
$retorno=true;
if ($retorno == true) {
    $msg = "Registro cadastrado com sucesso.";
} else {
    $msg = "Erro ao cadastrar.";
}
?>
<br/>
<p class="msgok"><?php echo $msg ?></p>


</body>
</html>