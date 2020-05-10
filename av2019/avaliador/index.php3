<?php
include ("../func_avalia.php3");
setcookie('cookie_senha_aval');
setcookie('cookie_user_aval');
cabecalho();
   #print "<form  action=\"aval_resultado.php3\" method=\"POST\">\n";
   print "<form  action=\"lista_sub.php3\" method=\"POST\">\n";
   echo "<center><table><td align=center>";
   echo  "Avaliação de Empregados</td></tr>";
   echo  "<tr><td>";
      echo "Login:";
      echo "</td>\n";
      echo "<td>\n";
      echo "<input type=\"text\" name=\"user\" size=\"15\" style=\"font-size: 10pt\"></td>";
      echo "<tr>\n";
      echo "<td>\n";
      echo "Senha:";
      echo "</td>\n";
      echo "<td>\n";
      echo "<input type=\"password\" name=\"password\" size=\"15\" style=\"font-size: 10pt\">";
      echo "<input type=\"hidden\" name=\"checksenha\" value=\"0\">";

   echo "</td></tr>";
   print "<tr><td>";
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
   echo "<a href=/blog.cnpma.embrapa.br/>Voltar</a>";
   echo "</td>";
   echo "</tr>";
   echo "</table></center>";
   print "<br>";
   print "<br>";


rodape();
?>
