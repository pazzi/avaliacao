<?php

include ("../func_avalia.php3");

if (!$_GET["parm"]) {
    $senha = $_POST["password"];
    $user = $_POST["user"];
    setcookie("cookie_senha_aval", $senha);
    setcookie("cookie_user_aval", $user);
} else {
    $password = $_COOKIE["cookie_senha_aval"];
    $user = $_COOKIE["cookie_user_aval"];
}

$ret = authenticateUser($user, $password, $ip);
$cod_ret = substr($ret, 0, 1);
$stamp = substr($ret, 1, strlen($ret) - 1);

#$cod_ret=1;
echo "<br>";
echo "<center>";
echo "<H2>Avaliação de empregados</H2>";
echo "<br>";
cabecalho();
echo "<center>";

if (($cod_ret == 0) or ( empty($senha))) {
    echo "<a href=./index.php3>User-id ou Senha invalidos - entre novamente</a>";
    exit();
}
echo "</center>";
echo "<br>";
echo "<center>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";

$data_atual = date('Y-m-d');

if (($data_atual >= '2020-03-04') && ($data_atual <= '2020-04-08')) {

    echo "<br>";

##Obtem dados de quem logou - matricula a ser avaliada (matr_da)
$sql_matr = sql($BD1, "select matr,local from empregados where email='$user'");
$matr_ret = mysql_result($sql_matr, 0, "matr");
$local_ret = mysql_result($sql_matr, 0, "local");
//*****************************
##Obtem dados do supervisor de quem logou (matr_or) status p
$sql_matr_sup = sql($BD4, "select supervisor from elegiveis where matr='$matr_ret' and ano='$ANO_REF' ");
$matr_sup_ret = mysql_result($sql_matr_sup, 0, "supervisor");
$sql_agrup = sql($BD4, "select Agrupamento.descricao, Agrupamento.cod_agrupamento from Agrupamento,elegiveis where elegiveis.matr='$matr_ret' and Agrupamento.cod_agrupamento=elegiveis.cod_agrupamento and Agrupamento.ano_referencia=$ANO_REF");
$agrupamento = mysql_result($sql_agrup, 0, "descricao");
$cod_agrupamento = mysql_result($sql_agrup, 0, "cod_agrupamento");


$str_rec_reg = "SELECT * 
                    FROM Pesquisa_Opiniao
                    WHERE matricula_superv='$matr_ret'
                    AND ano_pesq='$ANO_REF'
                    AND codigo_aval <>'2'
                    ORDER BY codigo_aval ASC";
$rec_reg = sql($BD4, $str_rec_reg);
if (mysql_num_rows($rec_reg) == 0) {
    echo "<h4>Nao existem avaliacoes a serem relizadas para empregados pertencentes ao <u>$agrupamento</u></h4>";
    exit();
}

echo "<table class=\"table table-striped\">";
echo "<tr>";
echo "<td>";
echo "<small>";
echo "Tipo";
echo "</small>";
echo "</td>";
echo "<td>";
echo "<small>";
echo "Nome";
echo "</small>";
echo "</td>";
echo "<td>";
echo "<small>";
echo "Andamento de avaliacao";
echo "</small>";
echo "</td>";
echo "<td>";
echo "<small>";
echo "Porcentagem de avaliacao";
echo "</small>";
echo "</td>";
echo "</tr>";
echo "<div class=\"container\">";
while ($lista1 = mysql_fetch_row($rec_reg)) {
    $matr_da = $lista1[2];
    $matr_or = $lista1[5];
    $cod_aval = $lista1[7];

    echo "<tr>\n";
    switch ($cod_aval) {
        case 2:
            echo "<td>\n";
            echo "<small>";
            echo "Auto-avaliacao";
            echo "</small>";
            echo "</td>\n";
            break;

        case 1:
            echo "<td>\n";
            echo "<div class=\"alert alert-success\" role=\"alert\">";
            echo "<small>";
            echo "Avaliacao de supervisor";
            echo "</small>";
            echo "</div>";
            echo "</td>\n";
            break;

        case 3:
            echo "<td>\n";
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "<small>";
            echo "Avaliacao de clientes";
            echo "</small>";
            echo "</div>";
            echo "</td>\n";
            break;
    }

    echo "<td>\n";
    echo "<a href=./desempenho/AvaliacaoDesempenho.php?parm=";
    echo $lista1[0];
    echo "&oPesq=I>";
    $str_busca_nome = "SELECT nome
                          FROM empregados
                          WHERE matr=$matr_da";
    $res_busca_nome = sql($BD1, $str_busca_nome);
    $nome = mysql_result($res_busca_nome, 0, "nome");
    echo "<text-info\">";
    echo "<small>";
    echo $nome;
    echo "</a>";
    echo "</small>";
    echo "</td>";

    $str_ve_agrupamento = "SELECT cod_agrupamento from Agrupamento WHERE ano_referencia='$ANO_REF' AND cod_agrupamento='$lista1[3]'";
    $res_ve_agrupamento = sql($BD4, $str_ve_agrupamento);
    $cod_agrupamento = mysql_result($res_ve_agrupamento, 0, "cod_agrupamento");

    $str_quant_questoes = "select sum(z_fontes.questoes) from z_itens, z_indicador, z_fontes 
                  where z_indicador.cod_agrupamento='$cod_agrupamento'
                  and z_indicador.id=z_itens.id_indicador 
                  and z_fontes.id = z_itens.id_fonte";
    $res_quant_questoes = sql($BD4, $str_quant_questoes);
    $total_aval_form = mysql_result($res_quant_questoes, 0, 0);

    $str_conta_aval = "SELECT COUNT(codigo_pesquisa) FROM Pesq_Satisfacao_Resp_Item WHERE codigo_pesquisa='$lista1[0]'";
    $res_conta_aval = sql($BD4, $str_conta_aval);
    $total_aval = mysql_result($res_conta_aval, 0, 0);


    echo "<td>\n";
    echo "<p class=\"text text-info\">";
    $a_avaliar = $total_aval_form - $total_aval;
    echo "<small>Questoes ja avaliadas : " . $total_aval . "&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; Questoes a avaliar - </small>" . $a_avaliar;
    echo "</p>\n";

    echo "</td>\n";
    $percent = $total_aval / $total_aval_form * 100;
    echo "<td>\n";

    if ($percent <= 20) {
        $cor_barra = "bg-danger";
    } else {
        if ($percent == 100) {
            $cor_barra = "bg-success";
        } else {
            $cor_barra = "bg-warning";
        }
    }

    echo "<div class=\"progress\">";
    echo "<div class=\"progress-bar " . $cor_barra . "  progress-bar-striped active\" role=\"progressbar\" aria-valuenow=\"70\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:" . round($percent, 2) . "%\">" . round($percent, 2) . "%";
    echo "</div>";
    echo "</div>";
    echo "</tr>\n";
}
echo "</td>\n";
echo "</table>";
echo "</center>\n";

} else {
    // Atenção: Colocar a data do encerramento, no formato dd/mm/yyyy
    $data_encerramento = '08/04/2020.';

    echo("<p align=\"center\" class = \"tituloaviso\">");
    echo("<br>O prazo para a Avaliação de Desempenho Individual foi encerrado em $data_encerramento<br>");
    echo("<br>");
    echo("Agradecemos sua atenção.<br>");
    echo("</p>");
    exit();
}
echo "<br>\n";
rodape();
?>
