<?php


#Verifica data de encerramento e encerra a avaliacao

$dia=date(d);
$mes=date(m);
$ano=date(o);
$hora=date(h);
$minuto=date(i);
$numero=$ano.$mes.$dia.$hora.$minuto;

if ($numero >= 202004152400)
   {
     #echo "Avaliacao de Clientes encerrada as 24hs de 11-04-2016";
     //echo "Avaliacao de Clientes Pares encerrada";
    
     echo "Avaliacao de Competencias fechada.";
     exit();
   }



##################################################################

//include ("../../func_avalia.php3");
include ("../func_avalia.php3");   
setcookie('cookie_senha_aval');
setcookie('cookie_user_aval');
cabecalho();
   print "<form  action=\"aval_mostra.php3\" method=\"POST\">\n";
   echo "<center><table border=1 width=40%><tr bgcolor=#FFFFFF><td align=center colspan=3>";
   echo  "<font class=title>Avaliação de Competências</font></td></tr>";
   echo  "<tr><td align=center>";

      echo "<font class=corpo>";
      echo "Login:";
      echo "</font>\n";
      echo "</td>\n";
      echo "<td colspan=2>\n";
      echo "<input type=\"text\" name=\"user\" size=\"15\" style=\"font-size: 10pt\"></td>";
      echo "<tr>\n";
      echo "<td align=center>\n";
      echo "<font class=corpo>";
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
   echo "<a href=/intranet/>Voltar</a>";
   echo "</td>";
   echo "</tr>";
   echo "</table></center>";
   print "<br>";


rodape();
?>
