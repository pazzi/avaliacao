<?php
include ("../../func_avalia.php3");
cabecalho();

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

#$cod_ret=1;
   if ($cod_ret == 0)
   {
    echo "<a href=./login.php3>User-id ou Senha inv\xe1lidos - entre novamente</a>";
    exit();
   }

  if (($RESP_SGP_LOGIN1 <> $user) AND ($RESP_SGP_LOGIN2 <> $user) )
   {
    echo "<a href=./index.php>Modulo especifico do SGP</a>";
    exit();
   } 

echo "<a href=cadastra.php>Alteracao nos resultados</a>";
echo "<br>";
echo "<br>";
echo "<a href=relat.php>Relatorio das alteracoes</a>";
rodape();
?>
