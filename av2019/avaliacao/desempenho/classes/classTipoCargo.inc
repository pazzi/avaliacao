<?php
/*Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 Embrapa Meio Ambiente
 Autor: Cláudia Vaz Crecci
 Data: 09/03/2009
 Sistema: Avaliação de Competências

 ***** Atualizações *****
 Autor:
 Data:
 */

class tipoCargo {

	var $codigo_cargo;
	var $descricao;
	var $bd;

	// function tipoCargo()
	// Esta função tem por objetivo configurar os valores padrões
	// para os atributos do cargo.
	function cargo() {
		$this->codigo_cargo = "";
		$this->descricao = "";
	}

	function mtObtemDescricaoTipoCargoBD()
	{
		$statement = "Select descricao ";
		$statement .= "from Tipos_Cargo ";
		$statement .= "where codigo_cargo = '$this->codigo_cargo'";

		$sqlTipoCargo = sql("$this->bd",$statement);

		while($lista = mysql_fetch_row($sqlTipoCargo))
		{
			$descr = $lista[0];
		}

		//	print "<br>mtObtemDescricaoTipoCargoBD: $statement<br>";

		return $descr;
	}

	function mtObtemCargoSelecionado($sel="")
	{

		$cargos_descr = $this->mtObtemCargos();

		$opcoes = "<option></option>";

		while($lista = mysql_fetch_row($cargos_descr))
		{
			$opcoes.= "<option value=\"$lista[0]\" ";
			$opcoes.= ($lista[0]==$sel) ? "selected " : "";
			$opcoes.= " >$lista[1]</option>\n";
		}

		return $opcoes;
	}


	function mtObtemCargos()
	{
		$statement = "Select codigo_cargo, descricao ";
		$statement .= "from Tipos_Cargo ";
		$statement .= "order by descricao";

		$sqlPesqSatisfacaoClientes = sql("$this->bd",$statement);

		//	print "<br>mtObtemCargos: $statement<br>";

		return $sqlPesqSatisfacaoClientes;
	}


}

?>
