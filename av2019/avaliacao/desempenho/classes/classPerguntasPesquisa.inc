<?php

/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
  Embrapa Meio Ambiente
  Autor: Cláudia Vaz Crecci
  Data:
  Sistema: Pesquisa de Satisfação do Cliente Interno

 * **** Atualizações *****
  Autor: Cláudia Vaz Crecci
  Data: 11/03/2009
 */

class perguntasPesquisa {

    var $cod_pergunta;
    var $desc_pergunta;
    var $bd;

    // function itemRespSatisfPesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos da pesquisa.
    function perguntasPesquisa() {
        $this->cod_pergunta = "";
        $this->desc_pergunta = "";
    }

    function mtObtemPerguntasPesquisaBD() {

        $statement = "select * ";
        $statement .= "from Pesquisa_Perguntas";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //      print "<br>mtObtemPerguntasPesquisaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemDescricaoPerguntaPesquisaBD() {

        $statement = "select desc_pergunta ";
        $statement .= "from Pesquisa_Perguntas ";
        $statement .= "where cod_pergunta = '$this->cod_pergunta' ";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        while ($descricao = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            $descPergunta = $descricao[0];
        }

        //        print "<br>mtObtemDescricaoPerguntaPesquisaBD: $statement<br>";

        return $descPergunta;
    }

}

?>
