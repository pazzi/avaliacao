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

class itemRespSatisfPesquisa {

    var $codigo_pesquisa;
    var $cod_pergunta;
    var $cod_pesq_satisfacao;
    var $cod_tipo_resposta;
    var $cod_setor;
    var $matricula;
    var $matricula_superv;
    var $bd;

    // function itemRespSatisfPesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos da pesquisa.
    function itemRespSatisfPesquisa() {
        $this->codigo_pesquisa = "";
        $this->cod_pergunta = "";
        $this->cod_pesq_satisfacao = "";
        $this->cod_tipo_resposta = "";
        $this->cod_setor = "";
    }

    function mtIncluirRespostasPesquisaSatisfacaoBD() {
        $statement = "Insert into Pesq_Satisfacao_Resp_Item ";
        $statement .= "values('$this->codigo_pesquisa',";
        $statement .= "'$this->cod_pergunta',";
        $statement .= "'$this->cod_pesq_satisfacao',";
        $statement .= "'$this->cod_tipo_resposta')";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

//        print "<br>mtIncluirRespostasPesquisaSatisfacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtAtualizarRespostasPesquisaSatisfacaoBD() {
        $statement = "Update Pesq_Satisfacao_Resp_Item ";
        $statement .= "set cod_tipo_resposta = '$this->cod_tipo_resposta' ";
        $statement .= "where ((codigo_pesquisa = '$this->codigo_pesquisa') ";
        $statement .= "and (cod_pergunta = '$this->cod_pergunta') ";
        $statement .= "and (cod_pesq_satisfacao = '$this->cod_pesq_satisfacao'))";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        // print "<br>mtAtualizarRespostasPesquisaSatisfacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemRespostasPesquisaSatisfacaoBD() {
        $statement = "select * ";
        $statement .= "from Pesq_Satisfacao_Resp_Item ";
        $statement .= "where ((codigo_pesquisa = '$this->codigo_pesquisa') ";
        $statement .= "and (cod_pergunta = '$this->cod_pergunta') ";
        $statement .= "and (cod_pesq_satisfacao = '$this->cod_pesq_satisfacao'))";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemRespostasPesquisaSatisfacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemVotosTipoRespostaItemPesqSatisfPorMatriculaBD() {
        $statement = "Select a.cod_tipo_resposta, ";
        $statement .= "b.desc_tipo_resposta, count(a.cod_tipo_resposta) ";
        $statement .= "from Pesq_Satisfacao_Resp_Item a, ";
        $statement .= "Tipos_Resposta b, Pesquisa_Opiniao c ";
        $statement .= "where ((a.codigo_pesquisa = c.codigo_pesquisa) ";
        $statement .= "and (c.ano_pesq = '$this->ano_pesq') ";
        $statement .= "and (c.tipo_cliente = '$this->tipo_cliente') ";
        $statement .= "and (c.matricula = '$this->matricula') ";
        $statement .= "and (c.matricula_superv = '$this->matricula_superv') ";
        $statement .= "and (a.cod_pergunta = '$this->cod_pergunta') ";
        $statement .= "and (a.cod_pesq_satisfacao = '$this->cod_pesq_satisfacao') ";
        $statement .= "and (a.cod_tipo_resposta = b.cod_tipo_resposta)) ";
        $statement .= "group by a.cod_tipo_resposta";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        // print "<br>mtObtemVotosTipoRespostaItemPesqSatisfPorMatriculaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemMediaAvaliacaoPorMatriculaBD() {
        $statement = "Select AVG (cod_tipo_resposta) ";
        $statement .= "from Pesq_Satisfacao_Resp_Item ";
        $statement .= "where (codigo_pesquisa = '$this->codigo_pesquisa') ";
        $statement .= "and (cod_pergunta = '$this->cod_pergunta') ";
        $statement .= "and (cod_tipo_resposta <> '5') ";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //print "<br>mtObtemMediaAvaliacaoPorMatriculaBD: $statement<br>";

        while ($media = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            return $media[0];
        }
    }

    function mtObtemCodigoPesquisaRespItemSatisfacaoBD() {
        $statement = "Select codigo_pesquisa ";
        $statement .= "from Pesq_Satisfacao_Resp_Item ";
        $statement .= "where codigo_pesquisa = '$this->codigo_pesquisa'";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemCodigoPesquisaRespItemSatisfacaoBD: $statement<br>";

        while ($codigo = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            return $codigo[0];
        }
    }

}

?>
