<?php
/*Embrapa - Empresa Brasileira de Pesquisa Agropecu�ria
Embrapa Meio Ambiente
Autor: Cl�udia Vaz Crecci
Data: 09/03/2009
Sistema: Avalia��o de Compet�ncias

***** Atualiza��es *****
Autor:
Data:
*/

class tipoAvaliador {

    var $codigo_aval;
    var $descricao;
    var $bd;

    // function tipoAvaliador()
    // Esta fun��o tem por objetivo configurar os valores padr�es
    // para os atributos do tipo de avaliador.
    function tipoAvaliador() {
        $this->codigo_aval = "";
        $this->descricao = "";
	}

    function mtObtemDescricaoTipoAvaliadorBD()
    {
        $statement = "Select descricao ";
        $statement .= "from Tipos_Avaliador ";
        $statement .= "where codigo_aval = '$this->codigo_aval'";

       $sqlTipoAval = sql("$this->bd",$statement);

       while($lista = mysql_fetch_row($sqlTipoAval))
       {
            $descr = $lista[0];
       }

//       print "<br>mtObtemDescricaoTipoAvaliadorBD: $statement<br>";

       return $descr;
	}
}

?>
