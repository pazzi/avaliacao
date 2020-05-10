<?php
/* Embrapa - Empresa Brasileira de Pesquisa Agropecuária
 * Embrapa Meio Ambiente
 * Autor: Cláudia Vaz Crecci
 * Data: 19/03/2018
 * Sistema: Formulário de Avaliação de Desempenho Individual - Ano Base 2017
 * ------------------------Atualizações---------------------
 * Autor: Cláudia Vaz Crecci
 * 
 */

include ("config.inc");
include ("funcoes_diversas.inc");
include ("security.php");

if (isset($_GET["oPesq"])) {
    $opesq = xssafe($_GET["oPesq"]);
} elseif (isset($_POST["oPesq"])) {
    $opesq = xssafe($_POST["oPesq"]);
}


if (isset($_GET["anopesq"])) {
    $ano_pesq = xssafe($_GET["anopesq"]);
} elseif (isset($_POST["oPesq"])) {
    $ano_pesq = xssafe($_POST["anopesq"]);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Avaliação de Desempenho Individual - Memorial Pesquisador - <?php print $ANO_REF; ?></title>
        <link rel="stylesheet" href="unidade.css" type="text/css">
        <STYLE TYPE="text/css">
            p.QuebraAqui {page-break-after: always}
        </STYLE>

    </head>

    <body>
        <?
        
        $BD4 = 'AvaliacaoDesemp';
        $str_sql = "SELECT $BD1.empregados.matr,$BD1.empregados.nome
                              FROM $BD1.empregados,$BD4.elegiveis
                              WHERE $BD1.empregados.matr=$BD4.elegiveis.matr
                              AND $BD4.elegiveis.elegivel='1'
                              AND $BD4.elegiveis.ano='$ANO_REF'
				ORDER BY $BD1.empregados.nome ASC";
        //echo $str_sql;
        $ret_str_sql = sql($BD4, $str_sql);
        echo "<h4>Empregados  sem preenchimento de memorial relato do empregado - $ANO_REF</h4>";


        echo "<table border=\"0\" cellspacing=3>";

        $i = 1;
        while ($lista1 = mysql_fetch_row($ret_str_sql)) {
            $str_memorial = "SELECT $BD4.Pesquisa_Opiniao.codigo_pesquisa
                			              FROM $BD4.Pesquisa_Opiniao, $BD4.Memorial
                              				WHERE $BD4.Pesquisa_Opiniao.matricula='$lista1[0]'
                              				AND $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_REF'
                              				AND $BD4.Pesquisa_Opiniao.codigo_pesquisa=$BD4.Memorial.codigo_pesquisa";
            $ret_memorial = sql($BD4, $str_memorial);
            $total_linhas = mysql_num_rows($ret_memorial);
            if ($total_linhas == 0) {
                echo "<tr>";
                echo "<font class=\"corpo\">";
                echo "<td>";
                echo $i;
                echo ":";
                echo $lista1[1];
                echo ":";
                echo $lista1[2];
                echo "</font>";
                echo "</td>";
                echo "</tr>";
                $i++;
            }
        }
        echo "</table>";
  
        ?>
    </body>
</html>