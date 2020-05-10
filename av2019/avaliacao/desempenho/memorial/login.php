<?php
//include ("/usr/local/www/data/avaliacao/func_avalia.php3");
include '../config.inc';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Formulário de Avaliação de Desempenho Individual</title>

        <link rel="stylesheet" href="../unidade.css" type="text/css">

    </head>

    <body>
        <?
        $ano_avaliacao = $ANO_REF;  // Corresponde ao ano atual - 1, isto é, o ano anterior - ano referencia da avaliação 
        
        print "<form  action=\"../memorial.php?oPesq=I\" method=\"POST\">\n";
        echo "<center><table border=1 width=40%><tr bgcolor=#FFFFFF><td align=center colspan=3>";
        echo "<font class=titulocor><b>Avaliação do Desempenho Individual - Ano Base $ANO_REF</font></b></td></tr>";
        echo "<tr><td align=center>";

        echo "<font class=textomedio>";
        echo "Login:";
        echo "</font>\n";
        echo "</td>\n";
        echo "<td colspan=2>\n";
        echo "<input type=\"text\" name=\"user\" size=\"15\" style=\"font-size: 10pt\"></td>";
        echo "<tr>\n";
        echo "<td align=center>\n";
        echo "<font class=textomedio>";
        echo "Senha:";
        echo "</font>\n";
        echo "</td>\n";
        echo "<td colspan=2>\n";
        echo "<input type=\"password\" name=\"password\" size=\"15\" style=\"font-size: 10pt\">";
        echo "<input type=\"hidden\" name=\"checksenha\" value=\"0\">";

        echo "</td></tr>";
        print "<tr><td align=center colspan=3>";
        print "<input type=\"submit\" name=\"BEentra\" value=\"Entrar\">";
        print "</td>\n";
        echo "</tr>";
        echo "</table>";
        echo "</center>";
        print "</form>";
        echo "<br>";
        echo "<br>";
        echo "<center>";
        echo "<table>";
        echo "<tr>";
        echo "<td colspan=3 align=center>";
        echo "<a href=\"http://intranet.cnpma.embrapa.br/blog/cnpma/\">Voltar</a>";
        echo "</td>";
        echo "</tr>";
        echo "</table></center>";
        print "<br>";
        ?>

</body>
</html>
