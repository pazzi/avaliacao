<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 * Embrapa Meio Ambiente
 * Autor: Cláudia Vaz Crecci
 * Data: 19/03/2018
 * Sistema: Formulário de Avaliação de Desempenho Individual - Ano Base 2017
 * ------------------------Atualizações---------------------
 * Autor: Cláudia Vaz Crecci
 * Data: 31/01/2020
 * Inclusão do tratamento de login e da variável $AGP no formulário para o Agrupamento da Pesquisa.
 * Esta variável está no config.inc.
 *  
 * 
 */

include ("../config.inc");
include ("../funcoes_diversas.inc");
include ("../security.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Avaliação de Desempenho Individual - Memorial Pesquisador</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <!--STYLE TYPE="text/css">
            tr.QuebraAqui {page-break-after: always}
        </STYLE-->
        <STYLE TYPE="text/css">
            p.QuebraAqui {page-break-after: always}
        </STYLE>

    </head>


    <body>

        <?php
        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');

        $erro = "";

        setcookie("cookie_senha_aval", $senha);
        setcookie("cookie_user_aval", $user);
        ?>

        <form method="post" action="pesquisador.php">

            <?php
            print "<span class='textobold'><h2>Avaliação de Desempenho Individual - Ano Base $ANO_REF - Memorial Pesquisador</h2></span>";

            if (empty($user) or ( $user != 'rmendes')) {
                echo("<p align=\"center\" class = \"tituloaviso\">");
                echo("<br>Acesso indevido.<br>");
                exit();

                echo("</p>");

                //$senha = $_POST["password"];

                $ret = authenticateUser($user, $password, $ip);
                $cod_ret = substr($ret, 0, 1);

                if (($cod_ret == 0) or ( empty($senha))) {
                    echo "<a href=./index.php3>User-id ou Senha invalidos - entre novamente</a>";

                    echo("<p align=\"center\"><a href=\"http://intranet.cnpma.embrapa.br/blog/cnpma/\">Voltar</a></p>");
                    exit();
                }

                //print "<span class='textoazulclaro'>Utilize o botão direito do mouse para imprimir e/ou salvar a listagem em formato .pdf.<br><br></span>";

                $query_mem_pesq = "select a.matricula, b.nome, c.desc_memorial ";
                $query_mem_pesq .= "from Pesquisa_Opiniao a, cnpma.empregados b, Memorial c ";
                $query_mem_pesq .= "where (a.matricula = b.matr) ";
                $query_mem_pesq .= "and (a.codigo_aval = '2') and (a.tipo_cliente = '$AGP') and (a.ano_pesq = '$ANO_REF') ";
                $query_mem_pesq .= "and (a.codigo_pesquisa = c.codigo_pesquisa) ";
                $query_mem_pesq .= "and (c.cod_pergunta = '5') and (cod_tipo_resposta = '5') ORDER BY b.nome ASC ";

                /* print $query_mem_pesq;

                  print "<table class='celWhite'>";
                  print "<tr class='textobold'><td>Matrícula</td><td with='10%'>Nome</td><td>Memorial</td></tr>";

                  $sqlDescMem = sql($BD3, $query_mem_pesq);
                  while ($desc = mysql_fetch_row($sqlDescMem)) {

                  print "<tr class='QuebraAqui'>";

                  //print "<td class='celClara'>$desc[0]</td><td class='celClara' width='10%'>$desc[1]</td><td>$desc[2]</td>";
                  print "<td class='textobold'>$desc[0]</td><td class='textobold'width='10%'>$desc[1]</td><td>$desc[2]</td>";
                  print "</tr>";
                  }
                  print "</table>"; */

                $sqlDescMem = sql($BD3, $query_mem_pesq);
                while ($desc = mysql_fetch_row($sqlDescMem)) {
                    ?>
                    <p class='QuebraAqui'>
                        <?
                        print "<span class='textobold'>$desc[0] - $desc[1]</span>";
                        print "<br><br><span class='textoazul'>$desc[2]</span>";
                        ?>
                    </p>
                <?php
                }
            }
            ?>
        </form>
    </body>
</html>

