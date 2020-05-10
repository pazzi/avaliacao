<?php
include ("../func_avalia.php3");
setcookie('cookie_senha_aval');
setcookie('cookie_user_aval');
cabecalho($ANO_REF);
   echo "<br>";
   echo "<br>";
   echo "<center>";
   echo "<form  action=\"mapa.php\" method=\"POST\">\n";
   echo "<legend>Avaliacao de Competencias - Modulo RH -  Informe login e senha</legend>";
   echo "<br>";
   echo "<br>";
   echo "<label>Login:</label>";
   echo "<input type=\"text\" name=\"user\" size=\"15\" placeholder=\"Informe o Login\">";
   echo "<br>";
   echo "<br>";
   echo "<label>Senha:</label>";
   echo "<input type=\"password\" name=\"password\" size=\"15\" placeholder=\"Informe a senha\">";
   echo "<input type=\"hidden\" name=\"checksenha\" value=\"0\">";
   echo "<br>";
   echo "<br>";
   print "<button type=\"submit\" class=\"btn btn-primary\" name=\"BEentra\">Entrar</button>";
   print "</form>";
   print "</center>";
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
