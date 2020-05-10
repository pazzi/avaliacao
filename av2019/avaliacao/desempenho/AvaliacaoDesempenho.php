<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 * Embrapa Meio Ambiente
 * Autor: Cláudia Vaz Crecci
 * Data: 05/02/2018
 * Sistema: Formulário de Avaliação de Desempenho Individual - Ano Base 2017
 * ------------------------Atualizações---------------------
 * Autor: Cláudia Vaz Crecci
 * Data: 05 a 08/03/2018
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Formulário de Avaliação de Desempenho Individual</title>

        <link rel="stylesheet" href="unidade.css" type="text/css">

    </head>

    <body>

        <?
        include ("config.inc");
        include ("funcoes_diversas.inc");
        include ("./classes/classPesquisa.inc");
        include ("./classes/classItemRespSatisfPesquisa.inc");
        include ("./classes/classPerguntasPesquisa.inc");
        include ("./classes/classPerguntasSatisfPesquisa.inc");
        include ("./classes/classTipoCargo.inc");
        include ("./classes/classTipoAvaliador.inc");
        include ("./classes/classTipoResposta.inc");
        include ("./classes/classMemorial.inc");
        include ("./classes/classAgrupamento.inc");

        include ("security.php");

        $parm_val = xssafe($_GET["parm"]);

        if (isset($_GET["parm"])) {
            $parm_val = xssafe($_GET["parm"]);
        } elseif (isset($_POST["parm"])) {
            $parm_val = xssafe($_POST["parm"]);
        }


        if (!is_numeric($parm_val)) {
            echo("<center><span class=\"tituloaviso\">1 - Acesso negado</span></center>");
            exit();
        }


        /* Início: Cláudia Vaz Crecci - 14/02/2018
         * - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
         * - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
         * - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO. 
         * ----------------------
         * Tabela: Pesquisa_Satisfacao_Perguntas.cod_pesq_satisfacao
         * ----------------------
         * cod_pesq_satisfacao = 14:
         * Questao 1. MEMORIAL: Avalie de maneira objetiva suas principais contibuições no período, indicando a importância/impacto/alcance no contexto da missão da Embrapa Meio Ambiente.
         * A expectativa é que voce realize uma autocritica sobre sua participação em processos de produção, melhoria e/ou inovação no setor de atuação.
         * ----------------------
         * cod_pesq_satisfacao = 13:
         * Questao 2. RELATO DO EMPREGADO: Faça uma autocritica sobre sua atuação no setor, relatando seu compromisso na obtenção dos resultados, sua dedicação para superar dificuldades e seu esforço
         * para apresentar soluções não identificadas anteriormente na realização do trabalho.
         * 
         * - Relacionamento com Pesquisa_Perguntas.cod_pergunta ($codigoPergunta):
         * cod_pergunta	| desc_pergunta
         * 5	| Contribuição Técnica - Memorial
         * 6	| Engajamento com o trabalho - Relato do Empregado
         *     
         */

        // Esses arrays foram utilizados em ano base 2017 - Cláudia Vaz Crecci - 22/02/2019
        // Os arrays dos agrupamentos são necessários para a exibição das perguntas conforme cada agrupamento
        // Agrupamento 15 - Pesquisa
        /* $aAgrupPesquisa = array(15);
          $aPergsAgrupPesquisa = array(7, 8); // Exibe Memorial - Contribuição Técnica
          // Agrupamentos 1, 7, 17, 19, 20 - Analistas e Pesquisador CTT
          $aAgrupAnalista = array(1, 7, 17, 19, 20);
          $aPergsAgrupAnalista = array(1, 2, 3); // Exibe Memorial - Contribuição Técnica e Relato do Empregado
          // Agrupamentos 11 e 12 - Analistas e Pesquisador CTT
          $aAgrupGerOperAnalSGLab = array(11, 12);
          $aPergsAgrupGerOperAnalSGLab = array(1, 2, 3); // Exibe Memorial - Contribuição Técnica e Relato do Empregado
          // Agrupamentos 3, 4, 5, 6, 8, 9, 13, 14, 18 - Assistentes e Técnicos
          $aAgrupAssistTecnico = array(3, 4, 5, 6, 8, 9, 13, 14, 18);
          $aPergsAgrupAssistTecnico = array(1, 2, 3); //Exibe Memorial - Engajamento com o trabalho
          // Agrupamento 2 - Assistentes e Técnicos do CAA/CGE
          $aAgrupAssisTecCAACGE = array(2);
          $aPergsAgrupAssisTecCAACGE = array(1, 2, 3);  // Exibe Memorial - Engajamento com o trabalho
          // Agrupamentos 10, 16, 21, 22 - Supervisores e Gerencial CGE
          $aAgrupSupervisorGerenc = array(10, 16, 21, 22);
          $aPergAgrupSupervisorGerenc = array(); // Exibe Memorial - Contribuição Técnica e Relato do Empregado
         */

        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');

        if (($data_atual >= '2020-03-04') && ($data_atual <= '2020-04-08'))
        {
            $erroTipoCliente = '0';
        } else {
            // Recebe o valor 3 para encerrar a pesquisa
            $erroTipoCliente = '3';

            // Atenção: Colocar a data do encerramento, no formato dd/mm/yyyy
            $data_encerramento = '08/04/2020.';

            echo("<p align=\"center\" class = \"tituloaviso\">");
            echo("<br>O prazo para a Avaliação de Desempenho Individual foi encerrado em $data_encerramento<br>");
            echo("<br>");
            echo("Agradecemos sua atenção.<br>");
            echo("</p>");
            exit();
        }

        //$erroTipoCliente = '0';
        
        $pesq = new pesquisa();
        $itemRespSatisfPesq = new itemRespSatisfPesquisa();
        $perguntasPesq = new perguntasPesquisa();
        $perguntasSatisfPesq = new perguntasSatisfPesquisa();
        $tipoCargo = new tipoCargo();
        $tipoAvaliador = new tipoAvaliador();
        $tipoResposta = new tipoResposta();
        $memorial = new memorial();
        $agrupamento = new agrupamento();

        $pesq->bd = $BD3;
        //print $pesq->bd . "::: " . $parm_val;
        $itemRespSatisfPesq->bd = $pesq->bd;
        $perguntasPesq->bd = $pesq->bd;
        $perguntasSatisfPesq->bd = $pesq->bd;
        $tipoCargo->bd = $pesq->bd;
        $tipoAvaliador->bd = $pesq->bd;
        $tipoResposta->bd = $pesq->bd;
        $memorial->bd = $pesq->bd;
        $agrupamento->bd = $pesq->bd;

        $erro = "";

// Início: switch para 2ª, n vez que a tela é exibida
        switch ($oPesq) {
            case 'IC': // Inclui Pesquisa Opinião Cliente
            case 'C':
                // Início: opção = "IC"
                if (($oPesq == "IC") or ( $oPesq == "C")) {
                    // Fazer update com a data da pesquisa
                    $pesq->data_pesquisa = date("Y-m-d");
                    $pesq->codigo_pesquisa = $parm_val;
                    $pesq->mtAtualizarDataAvaliacaoBD();

                    $erro = 0;

                    // Se pesquisa incluída com sucesso, inclui as perguntas
                    if ($erro == '0') {

                        $perguntasBD = $perguntasPesq->mtObtemPerguntasPesquisaBD();

                        while ($perg = mysql_fetch_row($perguntasBD)) {
                            $codigoPergunta = $perg[0];
                            $perguntasSatisfPesq->cod_tipo_resposta = $codigoPergunta;
                            $pesquisaSatisfacaoBD = $perguntasSatisfPesq->mtObtemPesquisaSatisfacaoBD();

                            while ($pesquisaSatisfacao = mysql_fetch_row($pesquisaSatisfacaoBD)) {
                                // Código da pesquisa de satisfação
                                $itemperg1 = $pesquisaSatisfacao[0];

                                // print "item: " .$itemperg1 . "<br><br>";

                                $var = ${"pesqSatisfTec" . $itemperg1};

                                while (list($opcao, $valor) = each($var)) {
                                    if ($var) {
                                        $itemRespSatisfPesq->codigo_pesquisa = $parm_val;
                                        $itemRespSatisfPesq->cod_pergunta = $codigoPergunta;
                                        $itemRespSatisfPesq->cod_pesq_satisfacao = $itemperg1;
                                        $itemRespSatisfPesq->cod_tipo_resposta = $valor;

                                        $respostasAvaliacao = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();
                                        $num_respostasAvaliacao = mysql_num_rows($respostasAvaliacao);

                                        // Verifica se o item já foi avaliado
                                        if ($num_respostasAvaliacao > 0) {
                                            $itemRespSatisfPesq->mtAtualizarRespostasPesquisaSatisfacaoBD();
                                        } else {
                                            // Inclui avaliação (nota) do item
                                            $itemRespSatisfPesq->mtIncluirRespostasPesquisaSatisfacaoBD();
                                        }
                                    }
                                }
                            }
                        }

                        /* Início implementação: Cláudia Vaz Crecci - 15/02/2018
                          /* ----------------------
                         * Demais alterações em 07/03/2017 - Cláudia Vaz Crecci
                         * - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
                         * - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
                         * - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO. 
                         * ----------------------
                         * Tabela: Pesquisa_Satisfacao_Perguntas.cod_pesq_satisfacao
                         * ----------------------
                         * cod_pesq_satisfacao = 14:
                         * Questao 1. MEMORIAL: Avalie de maneira objetiva suas principais contibuições no período, indicando a importância/impacto/alcance no contexto da missão da Embrapa Meio Ambiente.
                         * A expectativa é que voce realize uma autocritica sobre sua participação em processos de produção, melhoria e/ou inovação no setor de atuação.
                         * ----------------------
                         * cod_pesq_satisfacao = 13:
                         * Questao 2. RELATO DO EMPREGADO: Faça uma autocritica sobre sua atuação no setor, relatando seu compromisso na obtenção dos resultados, sua dedicação para superar dificuldades e seu esforço
                         * para apresentar soluções não identificadas anteriormente na realização do trabalho.
                         * 
                         * - Relacionamento com Pesquisa_Perguntas.cod_pergunta ($codigoPergunta):
                         * cod_pergunta	| desc_pergunta
                         * 5	| Contribuição Técnica - Memorial
                         * 6	| Engajamento com o trabalho - Relato do Empregado
                         */

                        // Início alteração: 19/02/2019 - Cláudia Vaz Crecci
                        $agrupamento->cod_agrupamento = $codAgrup;
                        $agrupamento->ano_referencia = $ANO_REF;
                        $qry_perguntas_agrup = $agrupamento->mtObtemPerguntaMemorialAgrupamentoBD();
                        $i = 0;
                        while ($agrup = mysql_fetch_row($qry_perguntas_agrup)) {

                            $aCodPerg[$i] = $agrup[0];
                            $i++;
                        }
                        // print_r($aCodPerg);
                        // Fim alteração: 22/02/2019 - Cláudia Vaz Crecci

                        $imprimi_mem = 0;
                        // - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
                        //if (in_array($codAgrup, $aAgrupPesquisa)) { Utilizado em ano base 2017
                        if ((in_array(7, $aCodPerg))) {
                            $codigoPergunta = 5;
                            $itemMemorial = 14;
                        } else if ((in_array(5, $aCodPerg)) and ( in_array(6, $aCodPerg))) {
                            // - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
                            //else if (in_array($codAgrup, $aAgrupAssisTecCAACGE) or in_array($codAgrup, $aAgrupAssistTecnico)) { // Utilizado em ano base 2017
                            $codigoPergunta = 5;
                            $itemMemorial = 14;
                            $codigoPerguntaEngaj = 6;
                            $itemEngaj = 13;
                            $imprimi_mem = 1;
                        } else { // - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO. 
                            $codigoPergunta = 6;
                            $itemMemorial = 13;
                        }

                        if ($imprimi_mem == 0) {

                            $var = ${"memPerg" . $itemMemorial};
                            while (list($opcao, $valor) = each($var)) {
                                if ($var) {
                                    $itemRespSatisfPesq->codigo_pesquisa = $parm;
                                    $itemRespSatisfPesq->cod_pergunta = $codigoPergunta;
                                    $itemRespSatisfPesq->cod_pesq_satisfacao = $itemMemorial;
                                    $itemRespSatisfPesq->cod_tipo_resposta = $valor;

                                    $respostasAvaliacao = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();
                                    $num_respostasAvaliacao = mysql_num_rows($respostasAvaliacao);

                                    // Verifica se o item já foi avaliado
                                    if ($num_respostasAvaliacao > 0) {
                                        $itemRespSatisfPesq->mtAtualizarRespostasPesquisaSatisfacaoBD();
                                    } else {
                                        // Inclui avaliação (nota) do item
                                        $itemRespSatisfPesq->mtIncluirRespostasPesquisaSatisfacaoBD();
                                    }
                                }
                            }
                        } else

                        if ($imprimi_mem == 1) {

                            // Inclui item Contribuição técnica - Memorial    
                            $var = ${"memPerg" . $itemMemorial};
                            while (list($opcao, $valor) = each($var)) {
                                if ($var) {
                                    $itemRespSatisfPesq->codigo_pesquisa = $parm;
                                    $itemRespSatisfPesq->cod_pergunta = $codigoPergunta;
                                    $itemRespSatisfPesq->cod_pesq_satisfacao = $itemMemorial;
                                    $itemRespSatisfPesq->cod_tipo_resposta = $valor;

                                    $respostasAvaliacao = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();
                                    $num_respostasAvaliacao = mysql_num_rows($respostasAvaliacao);

                                    // Verifica se o item já foi avaliado
                                    if ($num_respostasAvaliacao > 0) {
                                        $itemRespSatisfPesq->mtAtualizarRespostasPesquisaSatisfacaoBD();
                                    } else {
                                        // Inclui avaliação (nota) do item
                                        $itemRespSatisfPesq->mtIncluirRespostasPesquisaSatisfacaoBD();
                                    }
                                }
                            }
                            // Inclui item Engajamento com o trabalho - Relado do Empregado
                            $var = ${"pergEngaj" . $itemEngaj};
                            while (list($opcao, $valor) = each($var)) {
                                if ($var) {
                                    $itemRespSatisfPesq->codigo_pesquisa = $parm;
                                    $itemRespSatisfPesq->cod_pergunta = $codigoPerguntaEngaj;
                                    $itemRespSatisfPesq->cod_pesq_satisfacao = $itemEngaj;
                                    $itemRespSatisfPesq->cod_tipo_resposta = $valor;

                                    $respostasAvaliacao = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();
                                    $num_respostasAvaliacao = mysql_num_rows($respostasAvaliacao);

                                    // Verifica se o item já foi avaliado
                                    if ($num_respostasAvaliacao > 0) {
                                        $itemRespSatisfPesq->mtAtualizarRespostasPesquisaSatisfacaoBD();
                                    } else {
                                        // Inclui avaliação (nota) do item
                                        $itemRespSatisfPesq->mtIncluirRespostasPesquisaSatisfacaoBD();
                                    }
                                }
                            }
                        }

                        $oPesq = "I";
                    } else {
                        //$mensagem = "Erro na inclusão da avaliação.
                        $mensagem = "Por favor, entre em contato com o \"Comitê de Progressão Salarial por Mérito\" para fazer a avaliação. Obrigado";
                    }

                    $mensagem = "Avaliação concluída com sucesso.";
                    $oPesq = "I";
                    break;
                }
            //}// Fim: opção = IC
        } // Fim: switch para 2ª, n vez que a tela é exibida
// Início: switch para 1ª vez que a tela é exibida

        switch ($oPesq) {
            case 'I': // Inclui dados da pesquisa
                ?>

                <form method=post
                      action="<?= "AvaliacaoDesempenho.php?oPesq=$oPesq" . "C" ?>&<?= "parm=$parm" ?>">

                    <?
                    if ($erroTipoCliente == '3') {
                        //Mensagem para avaliação de competências encerrada
                        echo("<p align=\"center\" class = \"tituloaviso\">");
                        echo("<br>O prazo para a Avaliação do Desempenho Individual foi encerrado em $data_encerramento.<br>");
                        echo("<br>");
                        echo("Agradecemos sua atenção.<br>");
                        echo("</p>");
                    } else {

                        $oPesq = "I";

                        $pesq->codigo_pesquisa = $parm_val;
                        $avaliacao_selecionada = $pesq->mtObtemDadosAvaliacaoSelecionadaBD();

                        $avaliacaoBD = mysql_num_rows($avaliacao_selecionada);

                        // Início: Quando a avaliação não for localizada no Banco de Dados
                        if ($avaliacaoBD == 0) {
                            echo("<p align=\"center\" class = \"tituloaviso\">");
                            echo("<br>Avaliação não localizada.<br>");
                            echo("</p>");
                            exit();
                        }
                        // Fim: Quando a avaliação não for localizada no Banco de Dados

                        while ($dados_avaliacao = mysql_fetch_row($avaliacao_selecionada)) {

                            $ano_pesquisa = $dados_avaliacao[4];

                            $emp_login = xssafe($_COOKIE['cookie_user_aval']);

                            $empregadosBD = sql($BD1, "select matr from empregados where email = '$emp_login'");

                            while ($dados_emp = mysql_fetch_row($empregadosBD)) {
                                /* Se a matrícula do empregado que está fazendo a avaliação for diferente
                                 * da matrícula do avaliador recuperado do Banco de dados, ou, o ano da avaliação recuperado
                                 * do Banco de Dados for diferente do ano da avaliação (que é igual ao ano de referência, ou seja, o ano anterior),
                                 * o acesso ao sistema é indevido
                                 */
                                if (($dados_emp[0] <> $dados_avaliacao[0]) or ( $ano_pesquisa <> $ANO_REF)) {
                                    echo("<p align=\"center\" class = \"tituloaviso\">");
                                    echo("<br>Acesso indevido.<br>");
                                    echo("</p>");
                                    exit();
                                }
                            }


                            $nome_avaliador = mtObtemDescricaoContatoAtendimento($dados_avaliacao[0]);
                            $nome_empr = mtObtemDescricaoContatoAtendimento($dados_avaliacao[1]);

                            // Inicio - 09/02/2018 
                            // Armazena a matricula do avaliado para obter o Memorial no mtObtemDescricaoMemorialAutoAvaliacaoBD()
                            $matricula = $dados_avaliacao[1];
                            ?>
                            <input type="hidden" name='matricula' id='matricula' value=<?php print "$matricula"; ?> />
                            <?php
                            $tipoAvaliador->codigo_aval = $dados_avaliacao[3];
                            $descricao_aval = $tipoAvaliador->mtObtemDescricaoTipoAvaliadorBD();
                        }

                        $agrupamento->ano_referencia = $ANO_REF;
                        $empregadoElegivel = $agrupamento->mtDadosAgrupamentoEmpregadoElegivelBD($matricula);

                        while ($agrup_indicador = mysql_fetch_row($empregadoElegivel)) {
                            $cod_agrup = $agrup_indicador[0];
                            $descr_agrup = $agrup_indicador[1];
                            $indicador = $agrup_indicador[2];
                            $cod_indicador = $agrup_indicador[4];
                            //print ":::: :$cod_agrup, $cod_indicador<br>";
                        }

                        //print ":::: :$cod_agrup, $cod_indicador<br>";
                        // Agrupamento Pesquisa - 19/02/2019
                        $agrupamento->cod_agrupamento = $cod_agrup;
                        $qry_cod_perg_pesquisa = $agrupamento->mtObtemPerguntaAgrupamentoPesquisaBD();
                        $cod_perg_pesquisa = mysql_num_rows($qry_cod_perg_pesquisa);

                        //print ">" . $cod_perg_pesquisa;
                        // Verifica se houve avaliação na tabela de respostas/notas
                       $itemRespSatisfPesq->codigo_pesquisa = $parm_val;
                       $codigo_pesq_resp_item = $itemRespSatisfPesq->mtObtemCodigoPesquisaRespItemSatisfacaoBD();

                        $codigoPesquisa = $parm_val;
                        $tipoAval = $tipoAvaliador->codigo_aval;
                        ?>

                        <p class="subtitulo_tarja">
                            Formulário Avaliação do Desempenho Individual - Ano Base <? echo("$ANO_REF"); ?>
                        </p>
                        <p align=center>
                            <font size=+2><a class="link" href="../aval_mostra.php3?parm=1"><< Voltar para a lista</a> </font>
                        </p>

                        <p class="tituloaviso" align="center">
                            <? print($mensagem); ?>
                        </p>


                        <div class="dadosagrupamento">

                            <?php
                            print "<b>$descr_agrup</b>" . "<br>";
                            print "<b>Avaliador: </b>" . $nome_avaliador . "<br>";
                            if ($tipoAval <> 2) {
                                print "<b>Empregado: </b>" . $nome_empr . "<br>";
                            }
                            print "<b>Tipo de Avaliação: </b>" . $descricao_aval;
                            ?>

                        </div>
                        <?
                        /* echo("<table>");
                          echo("<tr><td colspan=\"16\"><b>$descr_agrup</b><br><b>Avaliador: </b>$nome_avaliador</td></tr>");

                          // Não exibe o nome do empregado quando é auto-avaliação
                          if ($tipoAvaliador->codigo_aval <> 2) {
                          echo("<tr><td colspan=\"16\"><b>Empregado: </b>$nome_empr</td></tr>");
                          }
                          echo("<tr><td colspan=\"16\"><b>Tipo de Avaliação: </b>$descricao_aval</td></tr>");
                          echo("</table>"); */
                        ?>
                        <input type = "hidden" id= 'codigoPesquisa' name = 'codigoPesquisa' value = "<?php print $codigoPesquisa; ?>"  />
                        <input type = "hidden" id= 'tipoAval' name = 'tipoAval' value = "<?php print $tipoAval; ?>"  />
                        <input type = "hidden" id= 'codAgrup' name = 'codAgrup' value = "<?php print $cod_agrup; ?>"  />
                        <?
                        //$perguntasSatisfPesq->mtObtemPerguntasPesquisaSatisfacaoIndicadorBD($cod_agrup,$ANO_REF);
                        $pesquisaPerguntasSatisfacaoBD = $perguntasSatisfPesq->mtObtemPerguntasPesqSatisfacaoIndicadorExcetoMemorialBD($cod_agrup, $ANO_REF); //$perguntasSatisfPesq->mtObtemPerguntasPesquisaSatisfacaoBD(); 

                        $numPerguntasPesquisa = mysql_num_rows($pesquisaPerguntasSatisfacaoBD);

                        //print ">>>" . $numPerguntasPesquisa;

                        $num = 0;
                        while ($pesquisaPergSatisfacao = mysql_fetch_row($pesquisaPerguntasSatisfacaoBD)) {

                            $codigoPergunta = $pesquisaPergSatisfacao[0];
                            $perguntasPesq->cod_pergunta = $codigoPergunta;

                            //print "pergunta:" . $pesquisaPergSatisfacao[0] . "<br>";

                            $descricaoPergunta = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();

                            if ($num < $numPerguntasPesquisa) {

                                $cod_agrup = $agrupamento->cod_agrupamento;

                                //print ":::::::::::: $cod_agrup - $codigoPergunta";


                                /* Início: Cláudia Vaz Crecci - Alteração: 14/02/2018
                                 * Formulário dinâmico para cada agrupamento
                                 */
                                /* if ((in_array($cod_agrup, $aAgrupPesquisa) and in_array($codigoPergunta, $aPergsAgrupPesquisa))
                                  or ( in_array($cod_agrup, $aAgrupAnalista) and in_array($codigoPergunta, $aPergsAgrupAnalista))
                                  or ( in_array($cod_agrup, $aAgrupGerOperAnalSGLab) and in_array($codigoPergunta, $aPergsAgrupGerOperAnalSGLab))
                                  or ( in_array($cod_agrup, $aAgrupAssistTecnico) and in_array($codigoPergunta, $aPergsAgrupAssistTecnico))
                                  or ( in_array($cod_agrup, $aAgrupAssisTecCAACGE) and in_array($codigoPergunta, $aPergsAgrupAssisTecCAACGE))
                                  or ( in_array($cod_agrup, $aAgrupSupervisorGerenc) and in_array($codigoPergunta, $aPergAgrupSupervisorGerenc))) { */

                                /* if ($cod_perg_pesquisa == 0) { */

                                // Início - Exibe notas
                                /*
                                  1	Não apresenta
                                  2	Apresenta parcialmente
                                  3	Apresenta plenamente
                                  4  Destaca-se // Usado até 2011
                                  5	Não sei avaliar // Valor "Neutro"
                                 */
                                /* if ($tipoAvaliador->codigo_aval == 3)
                                  {
                                  echo("<td align=\"center\">Não sei avaliar</td>"); // Não sei avaliar - é usado quando um parceiro/cliente está avaliando
                                  } else {
                                  echo("<td align=\"center\">Não se aplica</td>"); // Não se aplica - é usado quando um supervisor está avaliando
                                  } */
                                ?>
                                <!--td align="center">Não apresenta</td>
                                <td align="center">Apresenta parcialmente</td>
                                <td align="center">Apresenta plenamente</td!-->
                                <? /* php if ($ano_pesquisa > 2011) {?>
                                  <td align="center">Supera</td>
                                  <?php } else {
                                  ?>
                                  <td align="center">Destaca-se</td>
                                  <?php
                                  } */ ?>

                                <?php
                                $tipoResposta->ano_referencia = $ANO_REF;
                                // print "pergunta: $codigoPergunta - " . $pesquisaPergSatisfacao[0] . "<br>";
                                if ($codigoPergunta <= 3) {
                                    $tipoResposta->cod_indicador = 1;
                                    $tipoResposta->cod_pesq_satisfacao = 1; // vale para as perguntas 2 e 3 também: competências comportamentais
                                    $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                                } else if ($codigoPergunta == 15) { // Agrupamento da Pesquisa - Indicadores de Produção
                                    $tipoResposta->cod_indicador = 2;
                                    $tipoResposta->cod_pesq_satisfacao = 15;
                                    $codigoPergunta = 7;
                                    $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                                } else if ($codigoPergunta == 16) { // Agrupamento da Pesquisa - Indicadores de Engajamento
                                    $tipoResposta->cod_indicador = 3;
                                    $tipoResposta->cod_pesq_satisfacao = 16;
                                    $codigoPergunta = 8;
                                    $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                                }

                                //  print "Perg: $codigoPergunta; Agrupamento: $cod_agrup, $codAgrup";
                                ?>

                                <table width="100%" border="0"> 
                                    <tr class="subtitulo_tarja_escura">

                                        <td width="50%"><? print $descricaoPergunta; ?></td>

                                        <?php
                                        while ($dadosTipoResp = mysql_fetch_row($sqlTipoResposta)) {
                                            ?>
                                            <td align="center"><?php print $dadosTipoResp[2]; ?></td>
                                            <?php
                                        }
                                        // Fim - Exibe notas
                                        ?>
                                    </tr>
                                    <?
                                    print "<br><br>";
                                    $perguntasSatisfPesq->cod_tipo_resposta = $codigoPergunta;
                                    $pesquisaSatisfacaoBD = $perguntasSatisfPesq->mtObtemPesquisaSatisfacaoBD();

                                    while ($pesquisaSatisfacao = mysql_fetch_row($pesquisaSatisfacaoBD)) {
                                        $itemRespSatisfPesq->codigo_pesquisa = $codigoPesquisa;
                                        $itemRespSatisfPesq->cod_pergunta = $codigoPergunta;
                                        $itemRespSatisfPesq->cod_pesq_satisfacao = $pesquisaSatisfacao[0];

                                        $respostaPesqSatisfacaoBD = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();

                                        while ($respostaSatisfacao = mysql_fetch_row($respostaPesqSatisfacaoBD)) {
                                            // Código da pesquisa de satisfação
                                            $itemPesqBD = $respostaSatisfacao[2];

                                            // Excelente, Bom, Regular, Ruim, Péssimo
                                            $valores = $respostaSatisfacao[3];
                                        }

                                        // Código da pesquisa de satisfação
                                        $itemperg1 = $pesquisaSatisfacao[0];
                                        $pesqTec = "pesqSatisfTec" . $itemperg1 . "[]";

                                        echo("<tr>");

                                        //print "---$cod_perg_pesquisa";
                                        if ($cod_perg_pesquisa == 0) {
                                            //if ($cod_agrup <> 15) {

                                            echo("<td>$pesquisaSatisfacao[1]</td>");
                                            ?>

                                            <td align="center"><input type="radio" value="4" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 4) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?>>
                                            </td>
                                            <td align="center"><input type="radio" value="3" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 3) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?>>
                                            </td>
                                            <td align="center"><input type="radio" value="2" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 2) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?>>
                                            </td>
                                            <td align="center"><input type="radio" value="1" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 1) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?>>
                                            </td>
                                            <td align="center"><input type="radio" value="0" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 0) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?>>
                                            </td>
                                            </tr>
                                            <?php
                                        } else {

                                            // Link pesquisa
                                            //Contribuição técnica - Indicadores de Produção
                                            // $itemRespSatisfPesq->cod_pergunta == 7
                                            // Este link foi utilizado em 2017
                                            //$link = "<a href=\"http://intranet.cnpma.embrapa.br/intranet/php3/pat_indicadores_producao.php?flag=I$matricula&ano=$ANO_REF\" target=\"_blank\">Mais informações</a>";
                                            
                                            $link = "<a href=\"http://intranet.cnpma.embrapa.br/intranet/php3/indicadores_producao_2019.php?flag=I$matricula&ano=$ANO_REF\" target=\"_blank\">Mais informações</a>";
                                            
                                            //Engajamento com o trabalho - Indicadores de Engajamento	
                                            if ($itemRespSatisfPesq->cod_pergunta == 8) {
                                                // Este link foi utilizado em 2017
                                                //$link = "<a href=\"http://intranet.cnpma.embrapa.br/intranet/php3/indicadores_engajamento.php?flag=I$matricula&ano=$ANO_REF\" target=\"_blank\">Mais informações</a>";
                                                $link = "<a href=\"http://intranet.cnpma.embrapa.br/intranet/php3/indicadores_engajamento_2019.php?flag=I$matricula&ano=$ANO_REF\" target=\"_blank\">Mais informações</a>";
                                            }

                                            echo("<td>$pesquisaSatisfacao[1] - $link</td>");
                                            ?> 

                                            <td align="center"><input type="radio" value="4" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 4) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?> disabled="disabled" >
                                            </td>
                                            <td align="center"><input type="radio" value="3" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 3) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?> disabled="disabled" >
                                            </td>
                                            <td align="center"><input type="radio" value="2" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 2) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?> disabled="disabled" >
                                            </td>
                                            <td align="center"><input type="radio" value="1" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 1) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?> disabled="disabled" >
                                            </td>
                                            <td align="center"><input type="radio" value="0" name="<?= $pesqTec ?>"
                                                                      <?= (($valores == 0) and ( $itemperg1 == $itemPesqBD)) ? "checked" : "" ?> disabled="disabled" >
                                            </td>
                                            </tr>

                                            <?
                                        }


                                        $num++;
                                    }
                                    //}
                                }
                            }
                            ?>
                        </table><br>
                        <?
                        /* Início: Cláudia Vaz Crecci
                         * Tratamento para o Memorial - para todos os agrupamentos
                         */

                        if ($tipoAval == 1) {


                            /* ----------------------
                             * Alterações implementadas em 06/03/2017 - Cláudia Vaz Crecci
                             * - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
                             * - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
                             * - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO. 
                             * ----------------------
                             * Tabela: Pesquisa_Satisfacao_Perguntas.cod_pesq_satisfacao
                             * ----------------------
                             * cod_pesq_satisfacao = 14:
                             * Questao 1. MEMORIAL: Avalie de maneira objetiva suas principais contibuições no período, indicando a importância/impacto/alcance no contexto da missão da Embrapa Meio Ambiente.
                             * A expectativa é que voce realize uma autocritica sobre sua participação em processos de produção, melhoria e/ou inovação no setor de atuação.
                             * ----------------------
                             * cod_pesq_satisfacao = 13:
                             * Questao 2. RELATO DO EMPREGADO: Faça uma autocritica sobre sua atuação no setor, relatando seu compromisso na obtenção dos resultados, sua dedicação para superar dificuldades e seu esforço
                             * para apresentar soluções não identificadas anteriormente na realização do trabalho.
                             * 
                             * - Relacionamento com Pesquisa_Perguntas.cod_pergunta ($codigoPergunta):
                             * cod_pergunta	| desc_pergunta
                             * 5	| Contribuição Técnica - Memorial
                             * 6	| Engajamento com o trabalho - Relato do Empregado
                             */     

                              /*$imprimi_mem = 0; - Trecho de código utilizado em ano base 2017

                              // - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
                              if (in_array($cod_agrup, $aAgrupPesquisa)) {
                              $codigoPergunta = 5;
                              $codPesqSatisfacao = 14;
                              $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD(6, 10);
                              $codPesqSatisfacao_perg = 5; // Contribuição Técnica
                              // - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO.
                              } else if (in_array($cod_agrup, $aAgrupAssisTecCAACGE) or in_array($cod_agrup, $aAgrupAssistTecnico)) {
                              $codigoPergunta = 6;
                              $codPesqSatisfacao = 13;
                              $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD(21, 25);
                              $codPesqSatisfacao_perg = 4; //  Relato do Empregado
                              // - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
                              } else {
                              $perguntasPesq->cod_pergunta = 5;
                              $codPesqSatisfacao_perg_contr = 5; // Contribuição Técnica
                              $codigoPergunta_contr = $perguntasPesq->cod_pergunta;
                              $descricaoPergunta_contr = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();
                              $sqlTipoResposta_contr = $tipoResposta->mtObtemDescricaoTiposRespostaBD(6, 10);
                              $codPesqSatisfacao_contr = 14;

                              $perguntasPesq->cod_pergunta = 6;
                              $codPesqSatisfacao_perg_engaj = 4; //  Relato do Empregado
                              $codigoPergunta_engaj = $perguntasPesq->cod_pergunta;
                              $descricaoPergunta_engaj = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();
                              $sqlTipoResposta_engaj = $tipoResposta->mtObtemDescricaoTiposRespostaBD(21, 25);
                              $codPesqSatisfacao_engaj = 13;

                              $imprimi_mem = 1;
                              } */

                            // Início alteração: 20/02/2019 - Cláudia Vaz Crecci    
                            $agrupamento->cod_agrupamento = $cod_agrup;
                            $qry_perguntas_agrup = $agrupamento->mtObtemPerguntaMemorialAgrupamentoBD();
                            $i = 0;
                            while ($agrup = mysql_fetch_row($qry_perguntas_agrup)) {

                                $aCodPerg[$i] = $agrup[0];
                                $i++;
                            }

                            // print_r($aCodPerg);


                            $imprimi_mem = 0;
                            if ((in_array(7, $aCodPerg))) {
                                // - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;
                                $codigoPergunta = 5;
                                $codPesqSatisfacao = 14;
                                $codPesqSatisfacao_perg = 5;
                                $tipoResposta->cod_indicador = 2;
                                $tipoResposta->cod_pesq_satisfacao = 14;
                                $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                            } else if ((in_array(5, $aCodPerg)) and ( in_array(6, $aCodPerg))) {
                                // - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;
                                $perguntasPesq->cod_pergunta = 5;
                                $codPesqSatisfacao_perg_contr = 5; // Contribuição Técnica
                                $codigoPergunta_contr = $perguntasPesq->cod_pergunta;
                                $descricaoPergunta_contr = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();
                                $tipoResposta->cod_indicador = 2;
                                $tipoResposta->cod_pesq_satisfacao = 14;
                                $sqlTipoResposta_contr = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                                $codPesqSatisfacao_contr = 14;

                                $perguntasPesq->cod_pergunta = 6;
                                $codPesqSatisfacao_perg_engaj = 4; //  Relato do Empregado
                                $codigoPergunta_engaj = $perguntasPesq->cod_pergunta;
                                $descricaoPergunta_engaj = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();
                                $tipoResposta->cod_indicador = 3;
                                $tipoResposta->cod_pesq_satisfacao = 13;
                                $sqlTipoResposta_engaj = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                                $codPesqSatisfacao_engaj = 13;

                                $imprimi_mem = 1;
                            } else {
                                // - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO. 
                                $codigoPergunta = 6;
                                $codPesqSatisfacao = 13;
                                $codPesqSatisfacao_perg = 4; //  Relato do Empregado
                                $tipoResposta->cod_indicador = 3;
                                $tipoResposta->cod_pesq_satisfacao = 13;
                                $sqlTipoResposta = $tipoResposta->mtObtemDescricaoTiposRespostaBD();
                            }
                            // Fim alteração: 20/02/2019 - Cláudia Vaz Crecci    

                            if ($imprimi_mem == 0) {
                                $perguntasPesq->cod_pergunta = $codigoPergunta;
                                $descricaoPergunta = $perguntasPesq->mtObtemDescricaoPerguntaPesquisaBD();
                                ?>
                                <br>
                                <table width="100%" border="0">
                                    <tr  class="subtitulo_tarja_escura">

                                        <td width="50%"><? print $descricaoPergunta; ?></td>

                                        <?
                                        // Início: Exibe radiobuttons para as notas
                                        while ($dadosTipoResp = mysql_fetch_row($sqlTipoResposta)) {
                                            ?>
                                            <td align="center"><?php print $dadosTipoResp[2]; ?></td>
                                            <?php
                                        }
                                        // Fim - Exibe notas
                                        ?>
                                    </tr>
                                    <?
                                    $perguntasSatisfPesq->cod_tipo_resposta = $codPesqSatisfacao_perg;
                                    $pesquisaSatisfacaoBD = $perguntasSatisfPesq->mtObtemPesquisaSatisfacaoBD();

                                    while ($pesquisaSatisfacao = mysql_fetch_row($pesquisaSatisfacaoBD)) {
                                        $itemRespSatisfPesq->codigo_pesquisa = $codigoPesquisa;
                                        $itemRespSatisfPesq->cod_pergunta = $codigoPergunta;
                                        $itemRespSatisfPesq->cod_pesq_satisfacao = $codPesqSatisfacao;

                                        $respostaPesqSatisfacaoBD = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();

                                        while ($respostaSatisfacao = mysql_fetch_row($respostaPesqSatisfacaoBD)) {
                                            // Código da pesquisa de satisfação
                                            $itemPesqBD = $respostaSatisfacao[2];

                                            // Excelente, Bom, Regular, Ruim, Péssimo
                                            $valores = $respostaSatisfacao[3];
                                        }

                                        // Código da pesquisa de satisfação
                                        $itemMemorial = $pesquisaSatisfacao[0];

                                        echo("<tr>");
                                        //echo("<td>$pesquisaSatisfacao[1]</td>");
                                        echo("<td></td>");

                                        $perg_memorial = "memPerg" . $itemMemorial . "[]";
                                        ?>

                                        <td align="center"><input type="radio" value="4" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 4) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="3" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 3) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="2" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 2) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="1" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 1) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="0" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 0) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                                </table>

                            <?php } else {
                                ?>

                                <br>
                                <table width="100%" border="0">
                                    <tr class="subtitulo_tarja_escura">

                                        <td width="50%"><? print $descricaoPergunta_contr; ?></td>

                                        <?
                                        while ($dadosTipoResp = mysql_fetch_row($sqlTipoResposta_contr)) {
                                            ?>
                                            <td align="center"><?php print $dadosTipoResp[2]; ?></td>
                                            <?php
                                        }

                                        // Fim - Exibe notas
                                        ?>
                                    </tr>
                                    <?
                                    $perguntasSatisfPesq->cod_tipo_resposta = $codPesqSatisfacao_perg_contr;
                                    $pesquisaSatisfacaoBD = $perguntasSatisfPesq->mtObtemPesquisaSatisfacaoBD();

                                    while ($pesquisaSatisfacao = mysql_fetch_row($pesquisaSatisfacaoBD)) {
                                        $itemRespSatisfPesq->codigo_pesquisa = $codigoPesquisa;
                                        $itemRespSatisfPesq->cod_pergunta = $codigoPergunta_contr;
                                        $itemRespSatisfPesq->cod_pesq_satisfacao = $codPesqSatisfacao_contr;

                                        $respostaPesqSatisfacaoBD = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();

                                        while ($respostaSatisfacao = mysql_fetch_row($respostaPesqSatisfacaoBD)) {
                                            // Código da pesquisa de satisfação
                                            $itemPesqBD = $respostaSatisfacao[2];

                                            // Excelente, Bom, Regular, Ruim, Péssimo
                                            $valores = $respostaSatisfacao[3];
                                        }

                                        // Código da pesquisa de satisfação
                                        $itemMemorial = $pesquisaSatisfacao[0];

                                        echo("<tr>");
                                        //echo("<td>$pesquisaSatisfacao[1]</td>");
                                        echo("<td></td>");

                                        $perg_memorial = "memPerg" . $codPesqSatisfacao_contr . "[]";
                                        ?>

                                        <td align="center"><input type="radio" value="4" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 4) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="3" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 3) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="2" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 2) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="1" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 1) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="0" name="<?= $perg_memorial ?>"
                                                                  <?= (($valores == 0) and ( $itemMemorial == $itemPesqBD)) ? "checked" : "" ?>>
                                        </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                    <tr border="0" class="subtitulo_tarja_escura">

                                        <td width="50%"><? print $descricaoPergunta_engaj; ?></td>

                                        <?
                                        while ($dadosTipoResp = mysql_fetch_row($sqlTipoResposta_engaj)) {
                                            ?>
                                            <td align="center"><?php print $dadosTipoResp[2]; ?></td>
                                            <?php
                                        }

                                        // Fim - Exibe notas
                                        ?>
                                    </tr>
                                    <?
                                    $perguntasSatisfPesq->cod_tipo_resposta = $codPesqSatisfacao_perg_engaj;
                                    $pesquisaSatisfacaoBD = $perguntasSatisfPesq->mtObtemPesquisaSatisfacaoBD();

                                    while ($pesquisaSatisfacao = mysql_fetch_row($pesquisaSatisfacaoBD)) {
                                        $itemRespSatisfPesq->codigo_pesquisa = $codigoPesquisa;
                                        $itemRespSatisfPesq->cod_pergunta = $codigoPergunta_engaj;
                                        $itemRespSatisfPesq->cod_pesq_satisfacao = $codPesqSatisfacao_engaj;

                                        $respostaPesqSatisfacaoBD = $itemRespSatisfPesq->mtObtemRespostasPesquisaSatisfacaoBD();

                                        while ($respostaSatisfacao = mysql_fetch_row($respostaPesqSatisfacaoBD)) {
                                            // Código da pesquisa de satisfação
                                            $itemEngajBD = $respostaSatisfacao[2];

                                            // Excelente, Bom, Regular, Ruim, Péssimo
                                            $valores = $respostaSatisfacao[3];
                                        }

                                        // Código da pesquisa de satisfação
                                        $itemEngaj = $pesquisaSatisfacao[0];

                                        echo("<tr>");
                                        //echo("<td>$pesquisaSatisfacao[1]</td>");
                                        echo("<td></td>");

                                        $perg_engaj = "pergEngaj" . $codPesqSatisfacao_engaj . "[]";
                                        ?>

                                        <td align="center"><input type="radio" value="4" name="<?= $perg_engaj ?>"
                                                                  <?= (($valores == 4) and ( $itemEngaj == $itemEngajBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="3" name="<?= $perg_engaj ?>"
                                                                  <?= (($valores == 3) and ( $itemEngaj == $itemEngajBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="2" name="<?= $perg_engaj ?>"
                                                                  <?= (($valores == 2) and ( $itemEngaj == $itemEngajBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="1" name="<?= $perg_engaj ?>"
                                                                  <?= (($valores == 1) and ( $itemEngaj == $itemEngajBD)) ? "checked" : "" ?>>
                                        </td>
                                        <td align="center"><input type="radio" value="0" name="<?= $perg_engaj ?>"
                                                                  <?= (($valores == 0) and ( $itemEngaj == $itemEngajBD)) ? "checked" : "" ?>>
                                        </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                                </table>

                            <?php }
                            ?>

                            <?php
                            $txt_memorial = nl2br($memorial->mtObtemDescricaoMemorialAutoAvaliacaoBD($matricula, $ANO_REF));
                            ?>

                            <div class="textomemorial">
                                <?php
                                //echo("<span><strong>Memorial</strong><br>$txt_memorial</span>");
                                echo("<span><br>$txt_memorial</span>");
                                ?>
                            </div>



                            <?php
                        }
                        ?>
                        <br>
                        <center>
                            <input type="submit" class="textobold" name="btnEnviar" value="Enviar">
                        </center>
                        <br>
                    </form>
                </body>
            </html>


            <?
        }
} // Fim: switch para 1ª vez que a tela é exibida
?>
