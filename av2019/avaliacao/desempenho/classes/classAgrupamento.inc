<?php

/*  Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 *  Embrapa Meio Ambiente
 *  Autor: Cláudia Vaz Crecci
 *  Data: fev/2018
 *  Sistema: Avaliação de Desempenho
 * **** Atualizações *****
 * Autor: Cláudia Vaz Crecci
 * Data: 07/02/2018
 * mtObtemDescricaoIndicadorAgrupamentoBD
 * Data: 20/02/2019 
 * Criação dos métodos: mtObtemPerguntaAgrupamentoPesquisaBD e mtObtemPerguntaMemorialAgrupamentoBD.
 * 
 */

class agrupamento {

    var $cod_agrupamento;
    var $descricao;
    var $ano;
    var $bd;

    // function itemRespOutrasPesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos do agrupamento.
    function memorial() {
        $this->cod_agrupamento = "";
        $this->descricao = "";
        $this->ano = "";
        $this->bd = "";
    }

    function mtObtemAgrupamentoBD() {
        $statement = "Select * from Agrupamento ";

        $sqlAgrupamento = sql("$this->bd", $statement);

        //      print "<br>mtObtemAgrupamentoBD: $statement<br>";

        return $sqlAgrupamento;
    }

    function mtObtemDescricaoAgrupamentoBD() {
        $statement = "Select descricao ";
        $statement .= "from Agrupamento ";
        $statement .= "where cod_agrupamento = '$this->cod_agrupamento'";

        $sqlAgrupamento = sql("$this->bd", $statement);

        //	print "<br>mtObtemDescricaoAgrupamentoBD: $statement<br>";
        while ($descr = mysql_fetch_row($sqlAgrupamento)) {
            return $descr[0];
        }
    }

    function mtObtemDescricaoIndicadorAgrupamentoBD() {
        $statement = "Select a.descricao, b.desc_indicador, c.cod_pergunta, a.ano_referencia ";
        $statement .= "from Agrupamento a, Indicador b, Indicador_Agrup c ";
        $statement .= "where a.cod_agrupamento = '$this->cod_agrupamento' ";
        $statement .= "and a.cod_agrupamento = c.cod_agrupamento ";
        $statement .= "and b.cod_indicador = c.cod_indicador ";
        $statement .= "and a.ano_referencia = '$this->ano_referencia'";

        $sqlAgrupamento = sql("$this->bd", $statement);

        //      print "<br>mtObtemDescricaoIndicadorAgrupamentoBD: $statement<br>";

        return $sqlAgrupamento;
    }

    function mtDadosAgrupamentoEmpregadoElegivelBD($matricula) {
        $statement = "select a.cod_agrupamento, b.descricao, c.desc_indicador, c.cod_indicador ";
        $statement .= "from elegiveis a, Agrupamento b, Indicador c, Indicador_Agrup d ";
        $statement .= "where a.matr = '$matricula' and a.ano = '$this->ano_referencia' ";
        $statement .= "and a.cod_agrupamento = b.cod_agrupamento ";
        $statement .= "and a.cod_agrupamento = d.cod_agrupamento and c.cod_indicador = d.cod_indicador ";
        $statement .= "group by c.cod_indicador ";

        //      print "mtObtemDescricaoIndicadorAgrupamentoBD: $statement<br>";

        $sqlAgrupamento = sql("$this->bd", $statement);

        return $sqlAgrupamento;
    }

    function mtObtemPerguntaAgrupamentoPesquisaBD() {
        $statement = "Select b.cod_pergunta from ";
        $statement .= "Agrupamento a, Indicador_Agrup b ";
        $statement .= "where a.cod_agrupamento = '$this->cod_agrupamento' ";
        $statement .= "and a.cod_agrupamento = b.cod_agrupamento ";
        $statement .= "and b.cod_pergunta = 7 and b.ano_referencia = '$this->ano_referencia' ";
        $statement .= "group by b.cod_pergunta";

        //      print "mtObtemPerguntaAgrupamentoPesquisaBD: $statement<br>";

        $sqlAgrupamento = sql("$this->bd", $statement);

        return $sqlAgrupamento;
    }

    function mtObtemPerguntaMemorialAgrupamentoBD() {
        $statement = "Select cod_pergunta from ";
        $statement .= "Indicador_Agrup  ";
        $statement .= "where cod_agrupamento = '$this->cod_agrupamento' ";
        $statement .= "and ano_referencia = '$this->ano_referencia' ";

        //      print "mtObtemPerguntaMemorialAgrupamentoBD: $statement<br>";

        $sqlAgrupamento = sql("$this->bd", $statement);

        return $sqlAgrupamento;
    }

}
