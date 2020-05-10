<?
include ("../../func_avalia.php3");
setcookie('cookie_senha_aval');
setcookie('cookie_user_aval');
cabecalho();
##***bandeira=1 libera o acesso, bandeira<>1 fecha o acesso e abre avaliacao";
$bandeira="1";

echo "<br>";
echo "<br>";
echo "Cadastramento de Pares/Clientes";
if ($bandeira==1)
 {
   echo " - Acesso Liberado";
 }
  else
       {
        echo "<br>";
        echo "<a href=../avaliacao>Acesse a avaliacao</a>";
        echo "<br>";
        echo "<br>";
        exit();
      }

   echo "<center>\n";
   echo "<form  action=\"empr_mostra.php3\" method=\"POST\">\n";
   echo "<fieldset>";
   echo "<legend>Avaliacao de Competencias - Escolha de pares/clientes</legend>";
   echo "<label>Login:</label>";
   echo "<input type=\"text\" name=\"user\" size=\"15\" placeholder=\"Informe o Login\">";
   echo "<br>";
   echo "<label>Senha:</label>";
   echo "<input type=\"password\" name=\"password\" size=\"15\" placeholder=\"Informe a senha\">";
   echo "<input type=\"hidden\" name=\"checksenha\" value=\"0\">";
   echo "<br>";
   echo "<br>";
   print "<button type=\"submit\" class=\"btn btn-primary\" name=\"BEentra\">Entrar</button>";
   echo "</fieldset>";

   echo "</form>";
   echo "</center>\n";
   echo "<br>";
   echo "<br>";
   echo "<center>";
   echo "<a href=/intranet/>Voltar</a>";
   echo "</center>";
   print "<br>";


rodape();
 ?>
</html>
