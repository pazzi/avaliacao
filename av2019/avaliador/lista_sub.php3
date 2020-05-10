<?php
include ("../func_avalia.php3");

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
    echo "<a href=./index.php3>User-id ou Senha inv\xe1lidos - entre novamente</a>";
    exit();
   }

##Obtem dados de quem logou - matricula a ser avaliada (matr_da)
$sql_matr=sql($BD1,"select matr,nome,local from empregados where email='$user'");
$matr_ret=mysql_result($sql_matr,0,"matr");
$nome=mysql_result($sql_matr,0,"nome");
$local_ret=mysql_result($sql_matr,0,"local");


cabecalho();

echo "<br>";
echo "<center>";
echo "<a href=\"index.php3\">Voltar</a>";
echo "</center>";
echo "<br>";
echo "<br>";
echo "<center>A v a l i a c a o  - $ANO_AVAL - A n o &nbsp;&nbsp; B a s e  - $ANO_REF</center>";
echo "<br>";
echo "<br>";

$sql_subordinados="SELECT * FROM $BD4.Pesquisa_Opiniao,$BD1.empregados 
				WHERE $BD4.Pesquisa_Opiniao.matricula_superv='$matr_ret' 
				AND $BD4.Pesquisa_Opiniao.matricula=$BD1.empregados.matr 
				AND $BD4.Pesquisa_Opiniao.ano_pesq='$ANO_REF' 
				AND $BD4.Pesquisa_Opiniao.codigo_aval='1'
				ORDER BY $BD1.empregados.nome;";
$res_subordinados=sql($BD4,$sql_subordinados);

echo "<table class=\"table table-striped\">\n";
while ($lista1=mysql_fetch_row($res_subordinados))
	{
          echo "<tr>";
          echo "<td>\n";
          echo "<a href=./aval_resultado.php3?id=".$lista1[0].":::".$lista1[2].">".lista_nome($lista1[2])."</a>";
          echo "</td>";
	  echo "<td>\n";
          echo "<a href=./mostra_ficha.php3?id=".$lista1[0].":::".$lista1[2].">Resultado - visao do empregado</a>";
          echo "</td>";

          echo "</tr>\n";
         }
echo "</table>";

rodape();
?>
