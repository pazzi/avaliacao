<?php

/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
  Embrapa Meio Ambiente
  Autor: Cláudia Vaz Crecci
  Data:
  Sistema: Pesquisa de Satisfação do Cliente Interno

 * **** Atualizações *****
  Autor: Cláudia Vaz Crecci
  Data: 11/03/2009
  Autor: Cláudia Vaz Crecci
  Data: 26/03/2013
  Descrição: criação do método mtObtemAvaliadorBD.
 */

class pesquisa {

    var $codigo_pesquisa;
    var $data_pesquisa;
    var $matricula;
    var $tipo_cliente;
    var $ano_pesq;
    var $matricula_superv;
    var $bd;

    // function pesquisa()
    // Esta função tem por objetivo configurar os valores padrões
    // para os atributos da avaliação.
    function pesquisa() {
        $this->codigo_pesquisa = "";
        $this->data_pesquisa = "";
        $this->matricula = "";
        $this->tipo_cliente = "";
        $this->ano_pesq = "";
        $this->matricula_superv = "";
        $this->temposerv = "";
        $this->codigo_aval = "";
    }

    function mtIncluirPesquisaBD() {
        $statement = "Insert into Pesquisa_Opiniao ";
        $statement .= "values('',";
        $statement .= "'$this->data_pesquisa',";
        $statement .= "'$this->matricula',";
        $statement .= "'$this->tipo_cliente',";
        $statement .= "'$this->ano_pesq',";
        $statement .= "'$this->matricula_superv',";
        $statement .= "'$this->tempo_superv',";
        $statement .= "'$this->codigo_aval')";

        //      print "<br>mtIncluirPesquisaBD: $statement<br>";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemUltimoCodigoPesquisa2006BD() {
        $statement = "Select codigo_pesquisa ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "order by codigo_pesquisa ";
        $statement .= "desc limit 1";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //       print "<br>mtObtemUltimoCodigoPesquisaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemPesquisaSatisfacaoAnoBD() {

        $statement = "Select * ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (ano_pesq = '$this->ano_pesq')";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //      print "<br>mtObtemPesquisaSatisfacaoAnoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemQtdePesquisaSatisfacaoPorTipoClienteBD() {
        $statement = "Select count(*) ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where ((tipo_cliente = '$this->tipo_cliente') ";
        $statement .= "and (ano_pesq = '$this->ano_pesq'))";

        //        print "<br>mtObtemQtdePesquisaSatisfacaoPorTipoClienteBD: $statement<br>";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        while ($qtdClientes = mysql_fetch_row($sqlPesqSatisfacaoClientes)) {
            $qtdTotalClientes = $qtdClientes[0];
        }

        return $qtdTotalClientes;
    }

    function mtObtemPesquisaSelecionada($sel = "") {


        $anos_pesquisa = $this->mtAnosPesquisasSatisfacao();

        while ($lista = mysql_fetch_row($anos_pesquisa)) {
            $opcoes.= "<option value=\"$lista[0]\" ";
            $opcoes.= ($lista[0] == $sel) ? "selected " : "";
            $opcoes.= " >$lista[0]</option>\n";
        }

        return $opcoes;
    }

    function mtVerificaCadastroAvaliacao() {
        $statement = "select count(*) ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where matricula = '$this->matricula' ";
        $statement .= "and matricula_superv = '$this->matricula_superv' ";
        $statement .= "and tipo_cliente = '$this->tipo_cliente' ";
        $statement .= "and ano_pesq = '$this->ano_pesq'";

        //	print "<br>mtVerificaCadastroAvaliacao: $statement<br>";

        $sqlPesqCadastroAval = sql("$this->bd", $statement);

        while ($qtdNotas = mysql_fetch_row($sqlPesqCadastroAval)) {
            $qtdTotalClientes = $qtdNotas[0];
        }

        return $qtdTotalClientes;
    }

    function mtObtemDadosAvaliacaoSelecionadaBD() {

        $statement = "Select matricula_superv, matricula, tipo_cliente, codigo_aval, ano_pesq ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (codigo_pesquisa = '$this->codigo_pesquisa')";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemDadosAvaliacaoSelecionadaBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtAtualizarDataAvaliacaoBD() {

        $statement = "Update Pesquisa_Opiniao ";
        $statement .= "set data_pesquisa = '$this->data_pesquisa' ";
        $statement .= "where (codigo_pesquisa = '$this->codigo_pesquisa')";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtAtualizarDataAvaliacaoBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtAnosPesquisasSatisfacao() {
        $statement = "Select ano_pesq ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "group by ano_pesq ";
        $statement .= "order by ano_pesq desc";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //       print "<br>mtAnosPesquisasSatisfacao: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemMatriculaEmpregadoAvaliadorBD() {

        $statement = "select matricula, matricula_superv, tipo_cliente, codigo_pesquisa ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (ano_pesq = '$this->ano_pesq') ";
        $statement .= "order by matricula_superv, tipo_cliente asc";

        $sqlPesqSatisfacaoClientes = sql("$this->bd", $statement);

        //        print "<br>mtObtemMatriculaEmpregadoAvaliadorBD: $statement<br>";

        return $sqlPesqSatisfacaoClientes;
    }

    function mtObtemAvaliadorBD() {

        $statement = "Select codigo_aval ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (ano_pesq = '$this->ano_pesq') ";
        $statement .= "and (matricula = '$this->matricula') ";
        $statement .= "and (matricula_superv = '$this->matricula_superv') ";

        $sqlAvaliador = sql("$this->bd", $statement);

        //      print "<br>mtObtemAvaliadorBD: $statement<br>";

        while ($avaliador = mysql_fetch_row($sqlAvaliador)) {
            return $avaliador[0];
        }
    }

    function mtObtemPesquisaSatisfacaoAutoAvaliacaoBD() {

        /* Início: Cláudia Vaz Crecci - 08/02/2018
         * codigo_aval = 2 é o código utilizado para auto-avaliacação.
         * Em 2018, esse código foi utilizado para o Memorial (a descrição
         * da auto-avaliação do próprio empregado)
         */

        $statement = "Select codigo_pesquisa ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (ano_pesq = '$this->ano_pesq') ";
        $statement .= "and (matricula = '$this->matricula') ";
        $statement .= "and (codigo_aval = '2') ";

        $sqlPesqAutoAvaliacao = sql("$this->bd", $statement);
       
        //      print "<br>mtObtemPesquisaSatisfacaoAutoAvaliacaoBD: $statement<br>";

        while ($dados_avaliacao = mysql_fetch_row($sqlPesqAutoAvaliacao)) {
            return $dados_avaliacao[0];
        }
    }

    function mtObtemPesquisaSatisfacaoAvaliadorBD() {

        /* Início: Cláudia Vaz Crecci - 08/02/2018
         * codigo_aval = 1 é o código utilizado para o avaliador
         */

        $statement = "Select codigo_pesquisa ";
        $statement .= "from Pesquisa_Opiniao ";
        $statement .= "where (ano_pesq = '$this->ano_pesq') ";
        $statement .= "and (matricula = '$this->matricula') ";
        $statement .= "and (codigo_aval = '1') ";

        $sqlPesqAvaliador = sql("$this->bd", $statement);
       
       //       print "<br>mtObtemPesquisaSatisfacaoAvaliadorBD: $statement<br>";

        while ($dados_avaliacao = mysql_fetch_row($sqlPesqAvaliador)) {
            return $dados_avaliacao[0];
        }
    }
    
    
    
    
}

?>
