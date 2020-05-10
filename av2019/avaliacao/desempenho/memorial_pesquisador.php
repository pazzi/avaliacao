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
        $data_atual = date('Y-m-d');
        $hora_atual = date('H:i:s');

        $erro = "";

        // AGP = Agrupamento Pesquisa 
        if (($opesq <> 'AGP') or ( $ano_pesq <> $ANO_REF)) {
            echo("<center><span class=\"tituloaviso\">1 - Acesso negado</span></center>");
            exit();
        }

        print "<span class='textobold'><h2>Avaliação de Desempenho Individual - Ano Base $ANO_REF - Memorial Pesquisador e Apoio à Gestão de Pesquisa</h2></span>";

        //print "<span class='textoazulclaro'>Utilize o botão direito do mouse para imprimir e/ou salvar a listagem em formato .pdf.<br><br></span>";

        $query_mem_pesq = "select a.matricula, b.nome, c.desc_memorial ";
        $query_mem_pesq .= "from Pesquisa_Opiniao a, cnpma.empregados b, Memorial c ";
        $query_mem_pesq .= "where a.matricula = b.matr ";
        $query_mem_pesq .= "and a.codigo_aval = 2 and a.tipo_cliente = $AGP and a.ano_pesq = $ANO_REF ";
        $query_mem_pesq .= "and a.codigo_pesquisa = c.codigo_pesquisa ";
        $query_mem_pesq .= "and c.cod_pergunta = 5 and cod_tipo_resposta = 5 ORDER BY b.nome ASC ";

        //print $query_mem_pesq;
        
        $query_mem_apoio = "select a.matricula, b.nome, c.desc_memorial ";
        $query_mem_apoio .= "from Pesquisa_Opiniao a, cnpma.empregados b, Memorial c ";
        $query_mem_apoio .= "where a.matricula = b.matr ";
        $query_mem_apoio .= "and a.codigo_aval = 2 and a.tipo_cliente = $APP and a.ano_pesq = $ANO_REF ";
        $query_mem_apoio .= "and a.codigo_pesquisa = c.codigo_pesquisa ";
        $query_mem_apoio .= "and c.cod_pergunta = 5 and cod_tipo_resposta = 5 ORDER BY b.nome ASC ";


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
        
        $sqlDescMem = sql($BD3, $query_mem_apoio);
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
        
        ?>

    </body>
</html>


