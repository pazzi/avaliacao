<?php

/* Embrapa - Empresa Brasileira de Pesquisa Agropecu�ria
  Embrapa Meio Ambiente
  Autor: Cl�udia Vaz Crecci
  Data:
  Sistema: Avalia��o de Desempenho

 * **** Atualiza��es *****
  Autor: Cl�udia Vaz Crecci
  Data: 06/02/2018
 */

class memorial {

    var $codigo_pesquisa;
    var $cod_pergunta;
    var $cod_tipo_resposta;
    var $desc_memorial;
    var $bd;

    // function itemRespOutrasPesquisa()
    // Esta fun��o tem por objetivo configurar os valores padr�es
    // para os atributos do memorial.
    function memorial() {
        $this->codigo_pesquisa = "";
        $this->cod_pergunta = "";
        $this->cod_tipo_resposta = "";
        $this->desc_memorial = "";
    }

    function mtIncluirMemorialBD() {
        $statement = "Insert into Memorial ";
        $statement .= "values('$this->codigo_pesquisa',";
        $statement .= "'$this->cod_pergunta',";
        $statement .= "'$this->cod_tipo_resposta',";
        $statement .= "'$this->desc_memorial')";

        //      print "<br>mtIncluirMemorialBD: $statement<br>";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemMemorialBD() {
        $statement = "Select * from Memorial ";
        $statement .= "where codigo_pesquisa = '$this->codigo_pesquisa'";

        $sqlNumMemorial = sql("$this->bd", $statement);

        $num_rows = mysql_num_rows($sqlNumMemorial);

        //      print "<br>mtObtemMemorialBD: $statement $num_rows<br>";

        return $num_rows;
    }

    function mtAtualizarMemorialBD() {
        $statement = "Update Memorial ";
        $statement .= "set desc_memorial = '$this->desc_memorial' ";
        $statement .= "where codigo_pesquisa = '$this->codigo_pesquisa'";

        $sqlAlterarTexto = sql("$this->bd", $statement);

        //      print "mtAtualizarMemorialBD: $statement<br>";

        return $sqlAlterarTexto;
    }

    function mtObtemDescricaoMemorialBD() {
        $statement = "select desc_memorial ";
        $statement .= "from Memorial ";
        $statement .= "where codigo_pesquisa = '$this->codigo_pesquisa'";

        $sqlDescMem = sql("$this->bd", $statement);

        //        print "<br>mtObtemDescricaoMemorialBD: $statement<br>";

        while ($desc = mysql_fetch_row($sqlDescMem)) {

            return $desc[0];
        }
    }

    function mtObtemDescricaoMemorialAutoAvaliacaoBD($matricula, $ano_ref) {

        /* In�cio: Cl�udia Vaz Crecci - 09/02/2018
         * codigo_aval = 2 � o c�digo utilizado para auto-avaliaca��o.
         * Em 2018, esse c�digo foi utilizado para o Memorial (a descri��o
         * da auto-avalia��o do pr�prio empregado)
         */

        $statement = "Select a.desc_memorial ";
        $statement .= "from Memorial a, $this->bd.Pesquisa_Opiniao b ";
        $statement .= "where (b.matricula = $matricula) and (b.ano_pesq = $ano_ref) ";
        $statement .= "and (b.codigo_aval = '2') ";
        $statement .= "and a.codigo_pesquisa = b.codigo_pesquisa ";

        $sqlPesqAutoAvaliacao = sql("$this->bd", $statement);

        //      print "<br>mtObtemDescricaoMemorialAutoAvaliacaoBD: $statement<br>";

        while ($dados_avaliacao = mysql_fetch_row($sqlPesqAutoAvaliacao)) {
            return $dados_avaliacao[0];
        }
    }

}

?>
