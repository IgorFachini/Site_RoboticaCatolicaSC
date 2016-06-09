<?php
	include("cabecalho.php");
        include_once '../class/Categoria.class.php';
        include_once '../class/Marca.class.php';
        //buscar as categorias
        $objCategoria = new Categoria();
        $selectcategoria="";
        $categorias = $objCategoria->listar();
        foreach ($categorias as $item) {
            $selectcategoria.= "<option 
                value='".$item->codigo."'>".$item->nome.
                    "</option>";
        }
        
        
        
        
        
        
?>


		<br/>
                <h2>Cadastro de Produto</h2>
		<br/>
		<form action="produto-add-ok.php" method="POST" enctype="multipart/form-data">
		<table>
			<tr>
				<td align="right" width="25%"><label>Título:</label></td><td width="75%"><input type="text" name="titulo" required></td>
			</tr>
			<tr>
				<td align="right" width="25%"><label>Descrição:</label></td><td width="75%"><textarea  name="descricao" required></textarea></td>
			</tr>
                        <tr>
				<td align="right" width="25%"><label>Quantidade:</label></td><td width="75%"><input type="number" name="quant" required></td>
			</tr>
                        <tr>
				<td align="right" width="25%"><label>Preço:</label></td><td width="75%"><input type="text" name="preco" required></td>
			</tr>
                        <tr>
				<td align="right" width="25%"><label>Categoria:</label></td><td width="75%">
                                    <select name="codcategoria" required>
                                        <option value="">Selecione</option>
                                        <?php echo $selectcategoria; ?>
                                    </select>
                                    
                                </td>
			</tr>
                        <tr>
				<td align="right" width="25%"><label>Marca:</label></td><td width="75%">
                                    <select name="marca" required>
                                        <option value="">Selecione</option>
                                        <option value="3">Marca I</option>
                                        <option value="3">Marca I</option>
                                        <option value="3">Marca I</option>
                                    </select>
                                    
                                </td>
			</tr>
                        <tr>
				<td align="right" width="25%"><label>Imagem:</label></td><td width="75%">
                                   <input type="file" name="imagem" />
                                    
                                </td>
			</tr>
			<tr>
				<td align="right" width="25%"><input type="reset" value="Limpar"</td><td width="75%"><input type="submit" name="cadastrar" value="Cadastrar"></td>
			</tr>
		</table>
		</form>
		
	</body>
</html>