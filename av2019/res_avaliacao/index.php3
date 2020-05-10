<?
include ("../func_avalia.php3");
setcookie('cookie_senha_aval');
setcookie('cookie_user_aval');
cabecalho();
$ano=date(Y) - 1;
   print "<form  action=\"aval_resultado.php3\" method=\"POST\">\n";
   echo  "<center><h3>Avaliação de Empregados ano base - ". $ano. " </h3></center>";
   echo "<center><table><tr><td>";

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
      echo "<tr><td>";
      echo "<input type=\"submit\" name=\"BEentra\" value=\"Entrar\">";
      echo "</td>\n";
      echo "</tr>";
      echo "</table>";
      echo "</center>";
   echo "</form>";
   echo "<br>";
   echo "<br>";
   print "<br>";
   print "<br>";


/*
echo "<center>";
echo "<a href=\"mailto:cnpma.comiteprogsalarial@embrapa.br\" class=\"link\" title=\"Comite de progressao salarial\">Contate a Comite por e-mail</a>";
echo "</center>";
*/

   echo "<br>";
java_voltar();
   echo "<br>";

rodape();
?>
