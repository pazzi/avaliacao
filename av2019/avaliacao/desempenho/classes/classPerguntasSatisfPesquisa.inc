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

class perguntasSatisfPesquisa {

    var $codigo_pesquisa;
    var $cod_pergunta;
    var $cod_pesq_satisfacao;
    var $cod_tipo_resposta;
    var $bd;

    // function itemRespSatisfPesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos da pesquisa.
    function perguntasSatisfPesquisa() {
        $this->cod_pesq_satisfacao = "";
        $this->cod_tipo_resposta = "";
        $this->desc_pergunta_satisf = "";
    }

    function mtObtemPesquisaSatisfacaoBD() {

        $statement = "select cod_pesq_satisfacao, desc_pergunta_satisf ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas ";
        $statement .= "where (cod_tipo_resposta = '$this->cod_tipo_resposta') ";
        $statement .= "order by cod_pesq_satisfacao, desc_pergunta_satisf";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

       //       print "mtObtemPesquisaSatisfacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemCodigoPesquisaSatisfacaoBD() {

        $statement = "select cod_pesq_satisfacao, desc_pergunta_satisf ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas ";
        $statement .= "where (cod_tipo_resposta = '$this->cod_tipo_resposta') ";
        $statement .= "limit 1";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemCodigoPesquisaSatisfacaoBD: $statement<br>";

        while ($codigoPesqSatisf = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            return $codigoPesqSatisf[0];
        }
    }

    function mtObtemPerguntasPesquisaSatisfacaoBD() {

        $statement = "select cod_pesq_satisfacao, cod_tipo_resposta, desc_pergunta_satisf ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas ";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "mtObtemPesquisaSatisfacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    // Inserido em 19/02/2019
    function mtObtemPerguntasPesqSatisfacaoIndicadorExcetoMemorialBD($cod_agrup, $ano_ref) {

        $statement = "select a.cod_pesq_satisfacao, a.cod_tipo_resposta, a.desc_pergunta_satisf ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas a, Indicador_Agrup b ";
        $statement .= "where b.cod_agrupamento = '$cod_agrup' ";
        $statement .= "and b.ano_referencia = '$ano_ref' ";
        $statement .= "and a.cod_tipo_resposta = b.cod_pergunta ";
        $statement .= "and b.cod_pergunta <> '5' and b.cod_pergunta <> '6'"; // Memorial

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //      print "mtObtemPerguntasPesqSatisfacaoIndicadorExcetoMemorialBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemQtdePerguntasPesquisaSatisfacaoBD() {

        $statement = "select count(*) ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemQtdePerguntasPesquisaSatisfacaoBD: $statement<br>";

        while ($codigoPesqSatisf = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            return $codigoPesqSatisf[0];
        }
    }

    function mtDescricaoPerguntaPesquisaSatisfacaoBD() {

        $statement = "select desc_pergunta_satisf ";
        $statement .= "from Pesquisa_Satisfacao_Perguntas where cod_pesq_satisfacao = '$this->cod_pesq_satisfacao'";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtDescricaoPerguntaPesquisaSatisfacaoBD: $statement<br>";

        while ($descPesqSatisf = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            return $descPesqSatisf[0];
        }
    }

}

?>
