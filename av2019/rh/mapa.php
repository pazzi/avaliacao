<?php
include ("../func_avalia.php");
if (!$_GET["parm"])
    {
    $senha=$_POST["password"];
    $user=$_POST["user"];
    setcookie("cookie_senha_aval",$senha);
    setcookie("cookie_user_aval",$user);
    }
     else
         {
           $password=$_COOKIE["cookie_senha_aval"];
           $user=$_COOKIE["cookie_user_aval"];
         }


   $ret=authenticateUser($user, $password, $ip);
   $cod_ret=substr($ret, 0, 1);
   $stamp=substr($ret, 1, strlen($ret)-1);

    if ( ($user <> "bel") and ($user <> "cristina") and ($user <> "carlos") and ($user <> "paula"))
        {
         echo $user;
          echo "Usuario nao permitido para este acesso";
          exit();
        }
  $cod_ret=1;
   if ($cod_ret == 0)
   {
    echo "<a href=./index.php3>User-id ou Senha inv\xe1lidos - entre novamente</a>";
    exit();
   }

cabecalho();
echo "<center>";
echo "<h3> Mapa dos acessos do SGP </h3>";
echo "</center>";
echo "<div class=\"container\">";
echo "<div class=\"row\">";
echo "<div class=\"col\">";
echo "<h4>Definicao de agrupamentos</h4>";
echo "<a href=../agrupamentos/agrup.php?ano=$ANO_REF>Definir agrupamentos</a>";
echo "</div>";
echo "<div class=\"col\">";
echo "<h4>Insercao dos empregados</h4>";      
echo "<a href=./rh_mostra.php3?ano=$ANO_REF>Dados dos empregados</a>";
echo "</div>";
echo "<div class=\"col\">";
echo "<h4>Monitoramento</h4>";      
echo "</div>";
echo "</div>";
echo "</div>";

rodape();
?>
