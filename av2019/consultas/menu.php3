<?
include ("../func_avalia.php3");



if (!$HTTP_GET_VARS["parm"])
    {
    $senha=$HTTP_POST_VARS["password"];
    $user=$HTTP_POST_VARS["user"];
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

    if ( ($user <> "bel") and ($user <> "cristina") and ($user <> "paula") and ($user <> "claudia") )
        {
         echo $user;
          echo "Usuario nao permitido para este acesso";
          exit();
        }

   if ($cod_ret == 0)
   {
    echo "<a href=./index.php3>User-id ou Senha inv\xe1lidos - entre novamente</a>";
    exit();
   }



//setcookie('cookie_senha_aval');
//setcookie('cookie_user_aval');
cabecalho();
echo "<br>\n";
echo "<br>\n";
   echo "<center><table border=1 width=40%><tr bgcolor=#FFFFFF><td align=center colspan=3>";
   echo  "<font class=title>Avaliação - Clientes</font></td></tr>";
   echo  "<tr>";
   echo "<td align=center>";
   echo "<font class=corpo>";
   echo "<a href=./consultas.php3?parm=0>Elegiveis</a>";
   echo "</font>\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td align=center>";
   echo "<font class=corpo>";
   echo "<a href=\"./consultas.php3?parm=1\">Sem preenchimento de Memorial/Relato</a>";
   echo "</font>\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td align=center>";
   echo "<font class=corpo>";
   echo "<a href=consultas.php3?parm=5>Andamento da avaliacao </a>";
   echo "</font>\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "</table></center>";
echo "<br>\n";
rodape();
?>
