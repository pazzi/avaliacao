<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 * Embrapa Meio Ambiente
 * Autor: Cláudia Vaz Crecci
 * Data: 06/02/2018
 * Sistema: Formulário de Avaliação de Desempenho Individual - Ano Base 2017
 * ------------------------Atualizações---------------------
 * Autor: Cláudia Vaz Crecci
 * Data: 20/02/2019
 * Alterações: Tratamento do método mtObtemPerguntaMemorialAgrupamentoBD() para verificar os agrupamentos dinamicamente
 * pela tabela Indicador_Agrup e seus relacionamentos
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Formulário de Avaliação de Desempenho Individual</title>

        <link rel="stylesheet" href="unidade.css" type="text/css">

        <style type="text/css">
            body {font: 12px Verdana, Geneva, sans-serif;}

            p {margin: 0px;
               background-color: #D3D3D3;
               line-height: 20px;
            }

            .conteudo {border:none; padding:5px; margin-top:5px; width:1000px;}

            .box{
                padding: 20px;
                display: none;
                margin-top: 20px;
                border: 1px solid #000;
            }
            .erro{
                border:1px solid #6495ED;//#bf1e2c;
                background-color: #FFFACD;

            }

            .slidingDiv {
                height:300px;
                background-color: #F8F8FF;//#99CCFF;
                padding:20px;
                margin-top:10px;
                //border-bottom:5px solid #3399FF;
                font: 12px Verdana, Geneva, sans-serif;

            }


            .show_hide {
                display:none;
            }


        </style>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

        <script>

            $(document).ready(function () {




                // Legendas    
                $(".slidingDiv").hide();
                $(".show_hide").show();
                $('.show_hide').click(function () {
                    $(".slidingDiv").fadeToggle();
                });



            });


            function textCounter(campo, countcampo, maxlimit) {
                if (campo.value.length > maxlimit) {
                    campo.value = campo.value.substring(0, maxlimit);
                }
                else {
                    countcampo.value = maxlimit - campo.value.length;
                }
            }

        </script>

    </head>

    <body>

        <?
        include ("config.inc");
        include ("funcoes_diversas.inc");
        include ("./classes/classPesquisa.inc");
        include ("./classes/classPerguntasPesquisa.inc");
        include ("./classes/classPerguntasSatisfPesquisa.inc");
        include ("./classes/classTipoCargo.inc");
        include ("./classes/classTipoAvaliador.inc");
        include ("./classes/classTipoResposta.inc");
        include ("./classes/classMemorial.inc");
        include ("./classes/classAgrupamento.inc");
        include ("security.php");

        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');
        $link_login = "http://www.cnpma.embrapa.br/avaliacao/av$ANO_REF/avaliacao/desempenho/memorial/login.php";

        //Paula: alterar esta data para liberar/bloquear o memorial
        if (($data_atual >= '2020-02-10') && ($data_atual <= '2020-03-03')) {
            $erroTipoCliente = '0';
        } else {
            // Recebe o valor 3 para encerrar a pesquisa
            $erroTipoCliente = '3';

            // Atenção: Colocar a data do encerramento, no formato dd/mm/yyyy
            $encerramento = "03/03/$ANO_AVAL às 24:00 horas.";
            $data_encerramento = "O prazo para o preenchimento do memorial/relato do empregado foi encerrado em " . $encerramento;

            echo("<p align=\"center\" class = \"tituloaviso\">");
            echo("<br>$data_encerramento<br>");
            echo("<br>");
            echo("Agradecemos sua atenção.<br><br>Comissão de Progressão Salarial");
            echo("</p>");
            exit();
        }

        $pesq = new pesquisa();
        $perguntasPesq = new perguntasPesquisa();
        $perguntasSatisfPesq = new perguntasSatisfPesquisa();
        $tipoCargo = new tipoCargo();
        $tipoAvaliador = new tipoAvaliador();
        $tipoResposta = new tipoResposta();
        $memorial = new memorial();
        $agrupamento = new agrupamento();

        $pesq->bd = $BD3;
        $perguntasPesq->bd = $pesq->bd;
        $perguntasSatisfPesq->bd = $pesq->bd;
        $tipoCargo->bd = $pesq->bd;
        $tipoAvaliador->bd = $pesq->bd;
        $tipoResposta->bd = $pesq->bd;
        $memorial->bd = $pesq->bd;
        $agrupamento->bd = $pesq->bd;

        //print $pesq->bd . "::: ";

        $erro = "";


// Início: switch para 2ª, n vez que a tela é exibida
        switch ($oPesq) {
            case 'IC': // Inclui Pesquisa Opinião Cliente
            case 'C':
                // Início: opção = "IC"
                if (($oPesq == "IC") or ( $oPesq == "C")) {

                    $erro = 0;
                    if ($erro == '0') {


                        if (trim($_POST['txt_memorial']) <> "") {

                            $pesq->ano_pesq = $ANO_REF;  // Corresponde ao ano atual - 1, isto é, o ano anterior - ano referencia da avaliação     
                            $pesq->matricula = $matricula;
                            $codigoPesquisa = $pesq->mtObtemPesquisaSatisfacaoAutoAvaliacaoBD();

                            $pesq->data_pesquisa = date(Y) . "-" . date(m) . "-" . date(d);

                            if ($codigoPesquisa == '') {
                                $pesq->matricula = $matricula;
                                $pesq->tipo_cliente = $cod_agrup;
                                $pesq->ano_pesq = $ANO_REF;
                                $pesq->matricula_superv = $matricula;
                                $pesq->tempo_superv = 12;
                                $pesq->codigo_aval = 2;

                                $pesq->mtIncluirPesquisaBD();
                            }

                            $memorial->codigo_pesquisa = $pesq->mtObtemPesquisaSatisfacaoAutoAvaliacaoBD();

                            // Início alteração: 19/02/2019 - Cláudia Vaz Crecci
                            $agrupamento->cod_agrupamento = $cod_agrup;
                            $agrupamento->ano_referencia = $ANO_REF;
                            $qry_perguntas_agrup = $agrupamento->mtObtemPerguntaMemorialAgrupamentoBD();
                            $i = 0;
                            while ($agrup = mysql_fetch_row($qry_perguntas_agrup)) {

                                $aCodPerg[$i] = $agrup[0];
                                $i++;
                            }

                            //print_r($aCodPerg);

                            if ((in_array(7, $aCodPerg)) or ( in_array(5, $aCodPerg)) and ( in_array(6, $aCodPerg))) {
                                $memorial->cod_pergunta = 5; // Contribuição Técnica - Memorial
                            } else {
                                $memorial->cod_pergunta = 6; // Engajamento com o trabalho - Memorial
                            }
                            // Fim alteração: 21/02/2019 - Cláudia Vaz Crecci

                            $memorial->cod_tipo_resposta = 5; //$codigoResposta;
                            $memorial->desc_memorial = trim($txt_memorial);

                            if ($memorial->mtObtemMemorialBD() > 0) {

                                // Fazer update com a data da pesquisa
                                $pesq->codigo_pesquisa = $codigoPesquisa;
                                $pesq->mtAtualizarDataAvaliacaoBD();

                                $memorial->mtAtualizarMemorialBD();
                            } else {

                                $memorial->mtIncluirMemorialBD();
                            }
                        }
                        ?>

                        <p class="subtitulo_tarja_clara">
                            Formulário de Avaliação de Desempenho Individual - Ano base <?php echo $ANO_REF; ?>
                        </p>
                        <div class="dadosagrupamento">

                            <?php
                            print "<b>" . $dg . "</b><br>";
                            print "<b>Empregado: </b>" . $nemp . "<br>";
                            print "<b>$ind</b>";
                            ?>

                        </div>
                        <?php
                        $descricaoPergunta = "";
                        
                        echo("<center><p align=\"center\" class = \"tituloaviso\">");
                        echo("<br>Memorial enviado com sucesso!<br></p>");
                        echo("<br><br><span class='textomedio'>Para alterá-lo, clique no link encaminhado no e-mail pelo comitê ou <a href=\"$link_login\">clique aqui</a></span><br><br>");
                        echo("</center>");
                        exit();
                    } else {
                        //$mensagem = "Erro na inclusão da avaliação.
                        echo("<p align=\"center\" class = \"tituloaviso\">");
                        echo("<br>ATENÇÃO: O memorial não foi enviado com sucesso.<br>");
                        echo("<br>Contate o Comitê de Avaliação de Desempenho.");
                        echo("Agradecemos sua atenção.<br>");
                        echo("</p>");
                        exit();
                    }

                    echo("<center><p align=\"center\" class = \"tituloaviso\">");
                    echo("<br><br>Memorial enviado com sucesso.<br><br></p>");
                    echo("<span class='textomedio'>Para alterá-lo, localize o e-mail encaminhado pelo comite e clique no link do Memorial ou <a href=\"$link_login\">clique aqui</a>");
                    echo("</span></center>");

                    exit();
                }
            //}// Fim: opção = IC
        } // Fim: switch para 2ª, n vez que a tela é exibida
// Início: switch para 1ª vez que a tela é exibida

        switch ($oPesq) {
            case 'I': // Inclui dados da pesquisa
                ?>

                <form method="post" action="<?php print "memorial.php?oPesq=$oPesq" . "C"; ?>">

                    <?
                    if ($erroTipoCliente == '3') {
                        //Mensagem para avaliação de desempenho encerrada
                        echo("<p align=\"center\" class = \"tituloaviso\">");
                        echo("<br>$data_encerramento<br>");
                        echo("<br>");
                        echo("Agradecemos sua atenção.<br>");
                        echo("</p>");
                        exit();
                    } else {

                        $oPesq = "I";

                        $emp_login = xssafe($_POST[$_COOKIE['cookie_user_aval']]);

                        // Login    
                        if ($emp_login == '') {
                            $password = $_POST["password"];
                            $user = $_POST["user"];
                            $ret = authenticateUser($user, $password, $ip);
                            $cod_ret = substr($ret, 0, 1);
                            $stamp = substr($ret, 1, strlen($ret) - 1);

                            $voto = 0;
                            $mensagem = '';

                            if ($cod_ret == 0) {
                                echo "<br><br><center><a href=\"$link_login\">Usuário ou Senha inválidos - entre novamente</a></center><br><br>";
                                exit();
                            }

                            $statement = "select matr, nome from empregados where email = '$user'";

                            $matr = sql("cnpma", $statement);
                            while ($m = mysql_fetch_row($matr)) {
                                $matricula = $m[0];
                                $nome_empr = $m[1];
                            }
                        }
                        ?>

                        <input type="hidden" name='matricula' id='matricula' value=<?= $matricula ?>>

                        <?
                        // Início alteração: 19/02/2019 - Cláudia Vaz Crecci
                        $agrupamento->ano_referencia = $ANO_REF;
                        $empregadoElegivel = $agrupamento->mtDadosAgrupamentoEmpregadoElegivelBD($matricula);

                        while ($agrup_indicador = mysql_fetch_row($empregadoElegivel)) {
                            $cod_agrup = $agrup_indicador[0];
                            $descr_agrup = $agrup_indicador[1];
                        }
                        // Fim alteração: 21/02/2019 - Cláudia Vaz Crecci
                        ?>

                        <input type="hidden" name='cod_agrup' id='cod_agrup' value=<?= $cod_agrup ?>>

                        <?php
                        $pesq->ano_pesq = $ANO_REF;  // Corresponde ao ano atual - 1, isto é, o ano anterior - ano referencia da avaliação     
                        $pesq->matricula = $matricula;
                        $codigoPesquisa = $pesq->mtObtemPesquisaSatisfacaoAutoAvaliacaoBD();
                        ?>

                        <input type = "hidden" id= 'codigoPesquisa' name = 'codigoPesquisa' value = "<?php print $codigoPesquisa; ?>"  />


                        <p class="subtitulo_tarja_clara">Formulário de Avaliação de Desempenho Individual - Ano base <?php print $ANO_REF; ?>
                        </p>

                        <p class="tituloaviso" align="center"><? print($mensagem); ?></p>

                        <div class="dadosagrupamento">

                            <?php
                            print "<b>$descr_agrup</b>" . "<br>";
                            //print "<b>Avaliador: </b>" . $nome_avaliador . "<br>";
                            //if ($tipoAval <> 2) {
                            print "<b>Empregado: </b>" . $nome_empr . "<br>";
                            //}
                            ?>
                        </div>
                        <?php
                        // Início alterações: Cláudia Vaz Crecci - 06/03/2018
                        $descricaoPergunta = "<br><span class='tituloaviso'>ORIENTAÇÕES:</span><br><br><span class='textoazul'><strong> - Pesquisadores deverão responder apenas a Questão 1. MEMORIAL;<br> - Analistas, Supervisores e Gestores Operacionais deverão responder as Questões 1. MEMORIAL e 2. RELATO DO EMPREGADO;<br> - Assistentes e Técnicos deverão responder apenas a Questão 2. RELATO DO EMPREGADO.";
                        echo("$descricaoPergunta</strong><br><br>");

                        print "<span class='textobold'>Questão 1. MEMORIAL: Avalie de maneira objetiva suas principais contibuições no período, indicando a importância/impacto/alcance no contexto da missão da Embrapa Meio Ambiente.<br> A expectativa é que voce realize uma autocritica sobre sua participação em processos de produção, melhoria e/ou inovação no setor de atuação.</span><br><br>";
                        print "<span class='textobold'>Questão 2. RELATO DO EMPREGADO: Faça uma autocritica sobre sua atuação no setor, relatando seu compromisso na obtenção dos resultados, sua dedicação para superar dificuldades e seu esforço<br> para apresentar soluções não identificadas anteriormente na realização do trabalho.</span>";
                        // Fim
                        ?>

                        <br><br><a href="#legenda1" class="show_hide"><span class="textoazulclaro">Clique aqui para exibir e/ou ocultar o Memorial/Relato do ano anterior (<?php print $ANO_ANT;?>)</span></a><br>

                        <div class="slidingDiv">

                            <?php
                            $memorial->ano_referencia = $ANO_ANT;
                            print $memorial->mtObtemDescricaoMemorialAnoAnteriorBD($matricula);
                            ?>
                        </div>   

                        <?php
                        /* Este trecho de código era para ser dinâmico, mas ficou fixo com a descrição acima
                         * echo("<br><b><span class=\"textomedio\"> $descricaoPerguntaSatisf</span></b><br>");
                         * $perguntasSatisfPesq->cod_pesq_satisfacao = 14; // Tabela: Pesquisa_Satisfacao_Perguntas - 13 ou 14 (verificar agrupamento)
                         * descricaoPerguntaSatisf = $perguntasSatisfPesq->mtDescricaoPerguntaPesquisaSatisfacaoBD();
                         */
                        ?>
                        <input type = "hidden" id= 'dg' name = 'dg' value = "<?php print $descr_agrup; ?>"  />
                        <input type = "hidden" id= 'nemp' name = 'nemp' value = "<?php print $nome_empr; ?>"  />
                        <!-- input type = "hidden" id= 'ind' name = 'ind' value = "<?php print $descricaoPerguntaSatisf; ?>"/ -->
                        <?php
                        echo("<font class=\"textoazulclaro\"><br>Digite no máximo 3500 caracteres.</font>");

                        $memorial->codigo_pesquisa = $codigoPesquisa;
                        //$memorial->cod_pergunta = $pergunta;
                        $txt_memorial = $memorial->mtObtemDescricaoMemorialBD();
                        ?>
                        <table width="100%">
                            <tr>
                                <td class="textomedio"><textarea class="textomedio" rows="25" cols="190" name="txt_memorial" onkeyup="textCounter(this.form.txt_memorial, this.form.caracteresP13, 3500);" onkeydown="textCounter(this.form.txt_memorial, this.form.caracteresP13, 3500);"><?= $txt_memorial ?></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td><font class="textoazulclaro">Ainda resta(m)</font> <input type="text" class="textomedio" name="caracteresP13" value="<?= $caracteresP13 ?>" size="3" maxlength="3"> <font class="textoazulclaro">caracteres.</font>
                                </td>
                            </tr>
                        </table>

                        <?php ?>
                        <br>
                        <center>
                            <input type="submit" class="textobold" name="btnEnviar" value="<?php xecho(Enviar); ?>">
                        </center>
                        <br>

                        <?php
                    }
                    ?>


                </form>
            </body>
        </html>


    <?
} // Fim: switch para 1ª vez que a tela é exibida
?>
