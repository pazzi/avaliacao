<?php

/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
  Embrapa Meio Ambiente
  Autor: Cláudia Vaz Crecci
  Data:
  Sistema: Pesquisa de Satisfação do Cliente Interno

 * **** Atualizações *****
  Autor: Cláudia Vaz Crecci
  Data: 22/04/2008
 * Descrição: Criação do método mtObtemDescricaoTiposRespostaBD()
 * Data: 20/02/2018
 *  * Atualização do método mtObtemDescricaoTiposRespostaBD para tratamento dos agrupamentos dinâmicos em 2018.
 */

class tipoResposta {

    var $cod_tipo_resposta;
    var $desc_tipo_resposta;
    var $bd;

    // function tipoRespostasPesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos da pesquisa.
    function tipoResposta() {
        $this->cod_tipo_resposta = "";
        $this->desc_tipo_resposta = "";
    }

    function mtObtemTipoRespostaBD() {

        $statement = "select cod_tipo_resposta, desc_tipo_resposta ";
        $statement .= "from Tipos_Resposta ";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //      print "mtObtemTipoRespostaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemDescricaoTipoRespostaBD() {

        $statement = "select desc_tipo_resposta  ";
        $statement .= "from Tipos_Resposta ";
        $statement .= "where cod_tipo_resposta = '$this->cod_tipo_resposta'";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        while ($descricao = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            $descPergunta = $descricao[0];
        }

        //        print "mtObtemDescricaoTipoRespostaBD: $statement<br>";

        return $descPergunta;
    }

    function mtObtemDescricaoTiposRespostaBD() {

        $statement = "select cod_nota, cod_tipo_resposta, desc_tipo_resposta ";
        $statement .= "from Tipos_Resposta ";
        $statement .= "where cod_indicador = '$this->cod_indicador' ";
        $statement .= "and cod_pesq_satisfacao = '$this->cod_pesq_satisfacao' ";
        $statement .= "and ano_referencia = '$this->ano_referencia' ";
        $statement .= "order by ordem_visualizacao";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //      print "mtObtemDescricaoTiposRespostaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

}
